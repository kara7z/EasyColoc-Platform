<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Services\BalanceService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(private BalanceService $balanceService)
    {
    }
    

    public function index(Request $request)
    {
        $user = $request->user();

        $activeColocation = Colocation::query()
            ->where('status', 'active')
            ->whereHas('memberships', function ($q) use ($user) {
                $q->where('user_id', $user->id)->whereNull('left_at');
            })
            ->latest()
            ->first();

        $balance = 0.0;
        $recentExpenses = [];

        if ($activeColocation) {
            $balance = $this->balanceService->getUserNetBalance($activeColocation, $user->id);

            $recentExpenses = $activeColocation->expenses()
                ->latest('spent_at')
                ->limit(5)
                ->get()
                ->map(fn($expense) => [
                    'id' => $expense->id,
                    'title' => $expense->title,
                    'amount' => number_format((float) $expense->amount, 2) . ' MAD',
                    'date' => $expense->spent_at?->format('d/m/Y'),
                ])
                ->all();
        }

        return view('dashboard.index', [
            'userName' => $user->name ?? 'Utilisateur',
            'reputation' => (int) $user->reputation,
            'balance' => number_format($balance, 2, '.', ''),
            'activeColocation' => $activeColocation,
            'activeColocationName' => $activeColocation?->name,
            'recentExpenses' => $recentExpenses,
        ]);
    }
}
