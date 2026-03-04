<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Membership;
use App\Services\BalanceService;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function __construct(private BalanceService $balanceService)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;
        $isAdmin = (bool) $user->isAdmin;

        $activeColocationsQuery = Colocation::query()
            ->where('status', 'active');

        if (! $isAdmin) {
            $activeColocationsQuery->whereHas('memberships', function ($q) use ($userId) {
                $q->where('user_id', $userId)->whereNull('left_at');
            });
        }

        $activeColocations = $activeColocationsQuery
            ->latest()
            ->get();

        $activeColocation = $activeColocations->first();

        $colocations = Colocation::query()
            ->whereHas('memberships', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->get();

        return view('colocations.index', compact('activeColocation', 'activeColocations', 'colocations', 'isAdmin'));
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;

        if (! $user->isAdmin()) {
            $alreadyActive = Membership::query()
                ->where('user_id', $userId)
                ->whereNull('left_at')
                ->exists();

            if ($alreadyActive) {
                return back()->withErrors([
                    'name' => 'Vous avez déjà une colocation active.'
                ])->withInput();
            }
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:7', 'max:20'],
            'description' => ['nullable', 'string', 'min:9', 'max:300'],
        ]);

        $colocation = Colocation::create([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'created_by' => $userId,
            'status' => 'active',
        ]);

        Membership::create([
            'user_id' => $userId,
            'colocation_id' => $colocation->id,
            'role' => 'owner',
            'joined_at' => now(),
            'left_at' => null,
        ]);

        $defaultCategories = [
            ['name' => 'Loyer', 'color' => '#EF4444'],
            ['name' => 'Électricité', 'color' => '#F59E0B'],
            ['name' => 'Eau', 'color' => '#3B82F6'],
            ['name' => 'Internet', 'color' => '#8B5CF6'],
            ['name' => 'Courses', 'color' => '#10B981'],
            ['name' => 'Ménage', 'color' => '#6366F1'],
            ['name' => 'Autre', 'color' => '#6B7280'],
        ];

        foreach ($defaultCategories as $cat) {
            \App\Models\Category::create([
                'colocation_id' => $colocation->id,
                'name' => $cat['name'],
                'color' => $cat['color'],
            ]);
        }

        return redirect()->route('colocations.index')
            ->with('success', 'Colocation créée.');
    }

    public function show(Request $request, Colocation $colocation)
    {
        $user = $request->user();
        $userId = $user->id;
        $isAdminViewer = (bool) $user->isAdmin;

        $hasMembership = $colocation->memberships()
            ->where('user_id', $userId)
            ->exists();

        if (! $hasMembership && ! $isAdminViewer) abort(404);

        $isCancelled = ($colocation->status === 'cancelled');

        $activeMembers = $colocation->members()
            ->wherePivotNull('left_at')
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'role' => $u->pivot->role,
                    'reputation' => $u->reputation,
                    'joined_at' => optional($u->pivot->joined_at)->format('Y-m-d'),
                    'left_at' => null,
                ];
            });

        $membersHistory = $colocation->members()
            ->get()
            ->map(function ($u) {
                return [
                    'id' => $u->id,
                    'name' => $u->name,
                    'email' => $u->email,
                    'role' => $u->pivot->role,
                    'reputation' => $u->reputation,
                    'joined_at' => optional($u->pivot->joined_at)->format('Y-m-d'),
                    'left_at' => optional($u->pivot->left_at)->format('Y-m-d'),
                ];
            });

        $expenses = $colocation->expenses()
            ->with(['payer', 'category'])
            ->latest('spent_at')
            ->limit(10)
            ->get()
            ->map(fn($e) => [
                'id' => $e->id,
                'payer_id' => $e->payer_id,
                'title' => $e->title,
                'amount' => number_format($e->amount, 2) . ' MAD',
                'payer' => $e->payer->name,
                'category' => $e->category->name ?? 'Sans catégorie',
                'color' => $e->category->color ?? '#6B7280',
                'date' => $e->spent_at->format('d/m/Y'),
            ]);

        return view('colocations.show', [
            'colocation' => $colocation,
            'activeMembers' => $activeMembers,
            'membersHistory' => $membersHistory,
            'expenses' => $expenses,
            'isCancelled' => $isCancelled,
            'isAdminViewer' => $isAdminViewer,
        ]);
    }

    public function cancel(Request $request, Colocation $colocation)
    {
        $userId = $request->user()->id;

        $isOwnerActive = $colocation->memberships()
            ->where('user_id', $userId)
            ->where('role', 'owner')
            ->whereNull('left_at')
            ->exists();

        if (! $isOwnerActive) {
            abort(403, 'Owner only.');
        }

        $otherActiveMembers = $colocation->memberships()
            ->whereNull('left_at')
            ->where('user_id', '!=', $userId)
            ->exists();

        if ($otherActiveMembers) {
            return back()->withErrors([
                'cancel' => "Impossible d’annuler : vous n’êtes pas le seul membre actif. Retirez les autres membres d’abord."
            ]);
        }

        if ($colocation->status === 'cancelled') {
            return back();
        }

        $ownerNetBalance = $this->balanceService->getUserNetBalance($colocation, $userId);

        if ($ownerNetBalance < -0.01) {
            $request->user()->decrement('reputation');
        } else {
            $request->user()->increment('reputation');
        }

        $colocation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $colocation->memberships()
            ->where('user_id', $userId)
            ->whereNull('left_at')
            ->update(['left_at' => now()]);

        return redirect()->route('colocations.index')
            ->with('success', 'Colocation annulée.');
    }
}
