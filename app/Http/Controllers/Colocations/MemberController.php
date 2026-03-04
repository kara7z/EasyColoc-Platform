<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\User;
use App\Services\BalanceService;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function __construct(private BalanceService $balanceService)
    {
    }

    public function leave(Request $request, Colocation $colocation)
    {
        $user = $request->user();

        $membership = $colocation->memberships()
            ->where('user_id', $user->id)
            ->whereNull('left_at')
            ->first();

        if (! $membership) {
            return back()->withErrors(['member' => 'You are not an active member of this colocation.']);
        }

        if ($membership->role === 'owner') {
            return back()->withErrors(['member' => 'Owner cannot leave directly. Cancel the colocation instead.']);
        }

        $netBalance = $this->balanceService->getUserNetBalance($colocation, $user->id);

        $membership->update(['left_at' => now()]);

        if ($netBalance < -0.01) {
            $user->decrement('reputation');
        } else {
            $user->increment('reputation');
        }

        return redirect()->route('colocations.index')->with('success', 'You left the colocation.');
    }

    public function destroy(Request $request, Colocation $colocation, User $user)
    {
        $auth = $request->user();

        $authHasAnyMembership = $colocation->memberships()
            ->where('user_id', $auth->id)
            ->exists();

        if (! $authHasAnyMembership) {
            abort(403);
        }

        $authMembership = $colocation->memberships()
            ->where('user_id', $auth->id)
            ->whereNull('left_at')
            ->first();

        if (! $authMembership) {
            return back()->withErrors(['member' => 'You are not an active member of this colocation.']);
        }

        $authIsOwner = ($authMembership->role === 'owner');

        $targetMembership = $colocation->memberships()
            ->where('user_id', $user->id)
            ->whereNull('left_at')
            ->first();

        if (! $targetMembership) {
            return back()->withErrors(['member' => 'This user is not an active member.']);
        }

        if ($targetMembership->role === 'owner') {
            return back()->withErrors(['member' => 'You cannot remove the owner.']);
        }

        if (! $authIsOwner && $auth->id !== $user->id) {
            abort(403);
        }

        $netBalance = $this->balanceService->getUserNetBalance($colocation, $user->id);

        $targetMembership->update([
            'left_at' => now(),
        ]);

        if ($netBalance < -0.01) {
            $user->decrement('reputation');
        } else {
            $user->increment('reputation');
        }

        if ($authIsOwner && $auth->id !== $user->id && $netBalance < -0.01) {
            $ownerMembership = $colocation->memberships()
                ->where('user_id', $auth->id)
                ->where('role', 'owner')
                ->whereNull('left_at')
                ->first();

            if ($ownerMembership) {
                \App\Models\Payment::create([
                    'colocation_id' => $colocation->id,
                    'from_user_id' => $auth->id,
                    'to_user_id' => $user->id,
                    'amount' => abs($netBalance),
                    'paid_at' => now(),
                ]);
            }
        }

        if ($auth->id === $user->id) {
            return redirect()->route('colocations.index')->with('success', 'You left the colocation.');
        }

        return back()->with('success', 'Member removed successfully.');
    }
}
