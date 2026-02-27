<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $activeColocation = Colocation::query()
            ->where('status', 'active')
            ->whereHas('memberships', function ($q) use ($userId) {
                $q->where('user_id', $userId)->whereNull('left_at');
            })
            ->latest()
            ->first();

        $colocations = Colocation::query()
            ->whereHas('memberships', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->latest()
            ->get();

        return view('colocations.index', compact('activeColocation', 'colocations'));
    }

    public function create()
    {
        return view('colocations.create');
    }

    public function store(Request $request)
    {
        $userId = $request->user()->id;

        $alreadyActive = Membership::query()
            ->where('user_id', $userId)
            ->whereNull('left_at')
            ->exists();

        if ($alreadyActive) {
            return back()->withErrors([
                'name' => 'Vous avez déjà une colocation active.'
            ])->withInput();
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:20'],
            'description' => ['nullable', 'string', 'min:6', 'max:300'],
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

        return redirect()->route('colocations.index');
    }

    public function show(Request $request, Colocation $colocation)
    {
        $userId = $request->user()->id;

        $hasMembership = $colocation->memberships()
            ->where('user_id', $userId)
            ->exists();

        if (!$hasMembership) {
            abort(403);
        }

        $isCancelled = ($colocation->status === 'cancelled');

        $members = $colocation->members()
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

        $expenses = collect([]);

        return view('colocations.show', compact('colocation', 'members', 'expenses', 'isCancelled'));
    }

    public function cancel(Request $request, Colocation $colocation)
    {
        $userId = $request->user()->id;

        $isOwnerActive = $colocation->memberships()
            ->where('user_id', $userId)
            ->where('role', 'owner')
            ->whereNull('left_at')
            ->exists();

        if (!$isOwnerActive) {
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

        $colocation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        $colocation->memberships()
            ->where('user_id', $userId)
            ->whereNull('left_at')
            ->update(['left_at' => now()]);

        return redirect()->route('colocations.index')
            ->with('status', 'Colocation annulée.');
    }
}
