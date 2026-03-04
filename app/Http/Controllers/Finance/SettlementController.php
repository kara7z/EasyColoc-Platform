<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Payment;
use App\Services\BalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SettlementController extends Controller
{
    public function __construct(private BalanceService $balanceService)
    {
    }

    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $colocations = Colocation::query()
            ->whereHas('memberships', fn($q) => $q->where('user_id', $userId))
            ->with(['memberships.user', 'payments.from', 'payments.to', 'expenses.payer'])
            ->latest()
            ->get();

        $groups = $colocations->map(function (Colocation $colocation) use ($userId) {
            $balances = collect($this->balanceService->computeBalances($colocation));
            $detailedSettlements = $this->buildDetailedSettlements($colocation);
            $detailedWithPayments = $this->applyPaymentsToDetailedSettlements(
                $detailedSettlements,
                collect($colocation->payments)
            );

            $myMembership = $colocation->memberships
                ->first(fn($membership) => (int) $membership->user_id === (int) $userId && $membership->left_at === null);

            $canMarkAny = $myMembership !== null && $colocation->status === 'active';

            $pendingSettlements = $detailedWithPayments
                ->filter(fn(array $row) => (int) $row['remaining_cents'] > 0)
                ->values()
                ->map(function (array $row) use ($userId, $canMarkAny) {
                return [
                    'expense_id' => $row['expense_id'],
                    'expense_title' => $row['expense_title'],
                    'expense_total' => number_format(($row['expense_total_cents'] ?? 0) / 100, 2),
                    'spent_at' => $row['spent_at'],
                    'from_id' => $row['from_id'],
                    'to_id' => $row['to_id'],
                    'from' => $row['from'],
                    'to' => $row['to'],
                    'amount' => number_format($row['amount_cents'] / 100, 2),
                    'remaining' => number_format($row['remaining_cents'] / 100, 2),
                    'amount_value' => number_format($row['remaining_cents'] / 100, 2, '.', ''),
                    'can_mark_paid' => $canMarkAny
                        && (int) $row['remaining_cents'] > 0
                        && (
                            (int) $row['from_id'] === (int) $userId
                            || (int) $row['to_id'] === (int) $userId
                        ),
                ];
            })->values();

            $members = $this->buildMemberStatusRows($balances, $pendingSettlements);

            $payments = collect($colocation->payments)
                ->sortByDesc('paid_at')
                ->values()
                ->map(function (Payment $payment) {
                    return [
                        'from' => $payment->from?->name ?? 'Utilisateur supprimé',
                        'to' => $payment->to?->name ?? 'Utilisateur supprimé',
                        'amount' => number_format((float) $payment->amount, 2),
                        'paid_at' => $payment->paid_at?->format('d/m/Y H:i') ?? '—',
                    ];
                });

            return [
                'colocation' => $colocation,
                'members' => $members,
                'pending_settlements' => $pendingSettlements,
                'payments' => $payments,
                'can_mark_paid' => $canMarkAny,
            ];
        });

        return view('settlements.index', [
            'groups' => $groups,
        ]);
    }

    public function markPaid(Request $request)
    {
        $validated = $request->validate([
            'from_id' => 'required|exists:users,id',
            'to_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'colocation_id' => 'required|exists:colocations,id',
        ]);

        $colocation = Colocation::findOrFail($validated['colocation_id']);
        $userId = $request->user()->id;

        $membership = $colocation->memberships()->where('user_id', $userId)->whereNull('left_at')->first();

        if (!$membership) {
            abort(403);
        }

        $fromInColocation = $colocation->memberships()
            ->where('user_id', $validated['from_id'])
            ->exists();
        $toInColocation = $colocation->memberships()
            ->where('user_id', $validated['to_id'])
            ->exists();

        if (! $fromInColocation || ! $toInColocation) {
            return back()->withErrors(['payment' => 'Paiement invalide pour cette colocation.']);
        }

        $userIsDebtor = (int) $validated['from_id'] === (int) $userId;
        $userIsCreditor = (int) $validated['to_id'] === (int) $userId;
        if (! $userIsDebtor && ! $userIsCreditor) {
            abort(403, 'Seul le débiteur ou le créancier de cette ligne peut marquer payé.');
        }

        Payment::create([
            'colocation_id' => $validated['colocation_id'],
            'from_user_id' => $validated['from_id'],
            'to_user_id' => $validated['to_id'],
            'amount' => $validated['amount'],
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Paiement enregistré.');
    }

    private function buildDetailedSettlements(Colocation $colocation): Collection
    {
        $memberships = $colocation->memberships;

        $rows = [];

        foreach ($colocation->expenses->sortBy([
            ['spent_at', 'asc'],
            ['id', 'asc'],
        ]) as $expense) {
            if (! $expense->spent_at || ! $expense->payer) {
                continue;
            }

            $referenceDate = ($expense->created_at ?? $expense->spent_at)->copy();

            $activeUserIds = [];
            foreach ($memberships as $membership) {
                $joinedAt = ($membership->joined_at ?? $membership->created_at)?->copy();
                $leftAt = $membership->left_at?->copy();

                $wasActive = ($joinedAt === null || $joinedAt->lte($referenceDate))
                    && ($leftAt === null || $leftAt->gte($referenceDate));

                if ($wasActive) {
                    $activeUserIds[] = $membership->user_id;
                }
            }

            $activeCount = count($activeUserIds);
            if ($activeCount === 0) {
                continue;
            }

            $shareCents = (int) round(((float) $expense->amount * 100) / $activeCount);

            foreach ($activeUserIds as $fromUserId) {
                if ((int) $fromUserId === (int) $expense->payer_id) {
                    continue;
                }

                $fromMembership = $memberships->firstWhere('user_id', $fromUserId);
                $fromName = $fromMembership?->user?->name ?? 'Utilisateur supprimé';
                $toName = $expense->payer?->name ?? 'Utilisateur supprimé';

                $rows[] = [
                    'expense_id' => $expense->id,
                    'expense_title' => $expense->title,
                    'expense_total_cents' => (int) round((float) $expense->amount * 100),
                    'spent_at' => $expense->spent_at->format('d/m/Y'),
                    'from_id' => (int) $fromUserId,
                    'to_id' => (int) $expense->payer_id,
                    'from' => $fromName,
                    'to' => $toName,
                    'amount_cents' => $shareCents,
                    'remaining_cents' => $shareCents,
                ];
            }
        }

        return collect($rows)->values();
    }

    private function applyPaymentsToDetailedSettlements(Collection $settlements, Collection $payments): Collection
    {
        $rows = $settlements->values()->all();
        $orderedPayments = $payments->sortBy([
            ['paid_at', 'asc'],
            ['id', 'asc'],
        ])->values();

        foreach ($orderedPayments as $payment) {
            $remainingCents = (int) round((float) $payment->amount * 100);

            if ($remainingCents <= 0) {
                continue;
            }

            for ($index = 0; $index < count($rows) && $remainingCents > 0; $index++) {
                if ((int) $rows[$index]['from_id'] !== (int) $payment->from_user_id) {
                    continue;
                }
                if ((int) $rows[$index]['to_id'] !== (int) $payment->to_user_id) {
                    continue;
                }
                if ((int) $rows[$index]['remaining_cents'] <= 0) {
                    continue;
                }

                $consumed = min($remainingCents, (int) $rows[$index]['remaining_cents']);
                $rows[$index]['remaining_cents'] -= $consumed;
                $remainingCents -= $consumed;
            }
        }

        return collect($rows)->values();
    }

    private function buildMemberStatusRows(Collection $balances, Collection $pendingSettlements): Collection
    {
        $pendingByUser = $pendingSettlements
            ->groupBy('from_id')
            ->map(fn(Collection $rows) => $rows->sum(fn(array $row) => (float) ($row['amount_value'] ?? 0)));

        return $balances->map(function (array $balance) use ($pendingByUser) {
            $pendingAmount = (float) ($pendingByUser->get($balance['id']) ?? 0);
            $isDebtor = $pendingAmount > 0.009;

            return [
                'id' => $balance['id'],
                'name' => $balance['name'],
                'status' => $isDebtor ? 'Non payé' : 'Payé',
                'detail' => $isDebtor
                    ? 'Reste ' . number_format($pendingAmount, 2) . ' MAD'
                    : 'Solde OK',
                'is_debtor' => $isDebtor,
            ];
        })->values();
    }
}
