<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{

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

        $targetMembership->update([
            'left_at' => now(),
        ]);

        if ($auth->id === $user->id) {
            return redirect()->route('colocations.index')->with('success', 'You left the colocation.');
        }

        return back()->with('success', 'Member removed successfully.');
    }
}
