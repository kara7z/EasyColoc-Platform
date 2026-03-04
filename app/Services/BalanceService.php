<?php

namespace App\Services;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Payment;

class BalanceService
{
    /**
     * Compute net balance for every user who ever was a member of $colocation.
     *
     * Net balance > 0 => the member is OWED money (creditor).
     * Net balance < 0 => the member OWES money (debtor).
     *
     * Formula per member M:
     *   paid   = SUM of amount on all expenses where payer_id = M
     *   share  = SUM of (expense.amount / expense.member_count) for each expense
     *            where M was an active member when the expense was recorded
     *            i.e. M joined_at <= spent_at AND (left_at IS NULL OR left_at > spent_at)
     *   net    = paid - share
     *
     * Additionally, recorded Payments (mark-as-paid) shift existing balances.
     *
     * @return array<int, array{id:int, name:string, paid:float, share:float, net:float}>
     */
    public function computeBalances(Colocation $colocation): array
    {
        // ── 1. Load all expenses for this colocation ──────────────────────────
        $expenses = Expense::where('colocation_id', $colocation->id)->get();

        // ── 2. Load every membership (all time) ──────────────────────────────
        $memberships = $colocation->memberships()->with('user')->get();

        // Build lookup: user_id -> membership record
        $members = [];
        foreach ($memberships as $ms) {
            $uid = $ms->user_id;
            if (!isset($members[$uid])) {
                $members[$uid] = [
                    'id'        => $uid,
                    'name'      => $ms->user->name ?? '?',
                    'paid'      => 0.0,
                    'share'     => 0.0,
                    'joined_at' => $ms->joined_at,
                    'left_at'   => $ms->left_at,
                ];
            }
        }

        // ── 3. Compute paid + shares from expenses ────────────────────────────
        foreach ($expenses as $expense) {
            // Business rule: participation depends on when the expense row was created.
            // Members who joined later can see old expenses but are not included in them.
            $referenceDate = ($expense->created_at ?? $expense->spent_at)?->copy();
            $amount  = (float) $expense->amount;

            if (! $referenceDate) {
                continue;
            }

            $activeUserIds = [];

            foreach ($memberships as $ms) {
                $uid = $ms->user_id;
                $joinedAt = ($ms->joined_at ?? $ms->created_at)?->copy();
                $leftAt = $ms->left_at?->copy();

                $wasActive = ($joinedAt === null || $joinedAt->lte($referenceDate))
                    && ($leftAt === null || $leftAt->gte($referenceDate));

                if ($wasActive) {
                    $activeUserIds[] = $uid;
                }
            }

            $memberCount = max(1, count($activeUserIds));
            $sharePerPerson = $amount / $memberCount;

            // Add paid to the payer
            if (isset($members[$expense->payer_id])) {
                $members[$expense->payer_id]['paid'] += $amount;
            }

            // Add share to active members for this expense date
            foreach ($activeUserIds as $uid) {
                if (isset($members[$uid])) {
                    $members[$uid]['share'] += $sharePerPerson;
                }
            }
        }

        // ── 4. Apply already-recorded Payments ───────────────────────────────
        // A recorded payment from A to B means A's debt was reduced by that amount
        // (A gets "credit" for paying, B effectively paid less net).
        $payments = Payment::where('colocation_id', $colocation->id)->get();
        foreach ($payments as $payment) {
            $from   = $payment->from_user_id;
            $to     = $payment->to_user_id;
            $amount = (float) $payment->amount;

            // The payer effectively "paid" more into the pool
            if (isset($members[$from])) {
                $members[$from]['paid'] += $amount;
            }
            // The recipient had some of their "paid" returned
            if (isset($members[$to])) {
                $members[$to]['paid'] -= $amount;
            }
        }

        // ── 5. Compute net balances ───────────────────────────────────────────
        foreach ($members as &$m) {
            $m['net'] = round($m['paid'] - $m['share'], 2);
        }
        unset($m);

        return array_values($members);
    }

    /**
     * From a list of net balances, produce the MINIMAL set of transactions
     * needed to settle all debts (greedy algorithm).
     *
     * Returns array of ['from_id', 'from_name', 'to_id', 'to_name', 'amount']
     */
    public function simplifyDebts(array $balances): array
    {
        // Build creditor / debtor lists
        $creditors = []; // positive net
        $debtors   = []; // negative net

        foreach ($balances as $b) {
            $net = round($b['net'], 2);
            if ($net > 0.001) {
                $creditors[] = ['id' => $b['id'], 'name' => $b['name'], 'amount' => $net];
            } elseif ($net < -0.001) {
                $debtors[]   = ['id' => $b['id'], 'name' => $b['name'], 'amount' => abs($net)];
            }
        }

        $transactions = [];
        $ci = 0;
        $di = 0;

        while ($ci < count($creditors) && $di < count($debtors)) {
            $credit = $creditors[$ci]['amount'];
            $debt   = $debtors[$di]['amount'];
            $settle = min($credit, $debt);

            $transactions[] = [
                'from_id'   => $debtors[$di]['id'],
                'from_name' => $debtors[$di]['name'],
                'to_id'     => $creditors[$ci]['id'],
                'to_name'   => $creditors[$ci]['name'],
                'amount'    => round($settle, 2),
            ];

            $creditors[$ci]['amount'] -= $settle;
            $debtors[$di]['amount']   -= $settle;

            if ($creditors[$ci]['amount'] < 0.001) { $ci++; }
            if ($debtors[$di]['amount']   < 0.001) { $di++; }
        }

        return $transactions;
    }

    /**
     * Get the net balance of a single user within a colocation.
     * Positive = owed money, Negative = owes money.
     */
    public function getUserNetBalance(Colocation $colocation, int $userId): float
    {
        $balances = $this->computeBalances($colocation);
        foreach ($balances as $b) {
            if ($b['id'] === $userId) {
                return $b['net'];
            }
        }
        return 0.0;
    }
}
