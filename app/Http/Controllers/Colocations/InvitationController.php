<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Invitation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    public function create(Colocation $colocation)
    {
        $invites = Invitation::where('colocation_id', $colocation->id)
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('invitations.create', [
            'colocation' => $colocation,
            'invites' => $invites,
        ]);
    }

    public function store(Request $request, Colocation $colocation)
    {
        $request->validate([
            'email' => ['nullable', 'email'],
        ]);

        do {
            $token = Str::upper(Str::random(4)) . '-' . Str::upper(Str::random(4));
        } while (Invitation::where('token', $token)->exists());

        $invite = Invitation::create([
            'colocation_id' => $colocation->id,
            'invited_by'    => $request->user()->id,
            'email'         => $request->input('email'),
            'token'         => $token,
            'status'        => 'pending',
            'expires_at'    => now()->addDays(7),
        ]);

        $link = route('invitations.check', ['token' => $invite->token]);

        return redirect()
            ->route('invitations.create', $colocation)
            ->with('success', 'Invitation créée')
            ->with('token', $invite->token)
            ->with('link', $link);
    }

    public function check(Request $request)
    {
        if (! $request->filled('token')) {
            return view('invitations.accept', [
                'inv' => null,
                'canAct' => false,
                'message' => null,
            ]);
        }

        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $inv = Invitation::with('colocation')
            ->where('token', $request->token)
            ->first();

        if (! $inv) {
            return view('invitations.accept', [
                'inv' => null,
                'canAct' => false,
                'message' => 'Token invalide ou invitation introuvable.',
            ]);
        }

        if ($inv->expires_at && $inv->expires_at->isPast()) {
            $inv->update(['status' => 'expired']);

            return view('invitations.accept', [
                'inv' => null,
                'canAct' => false,
                'message' => 'Invitation expirée.',
            ]);
        }

        if ($inv->accepted_at || ($inv->status && $inv->status !== 'pending')) {
            return view('invitations.accept', [
                'inv' => null,
                'canAct' => false,
                'message' => 'Invitation déjà utilisée.',
            ]);
        }

        $user = $request->user();

        if ($inv->email) {
            $canAct = ($user !== null) && (strcasecmp($user->email, $inv->email) === 0);
        } else {
            $canAct = ($user !== null);
        }

        return view('invitations.accept', [
            'inv' => $inv,
            'canAct' => $canAct,
            'message' => null,
        ]);
    }


    public function accept(Request $request)
    {
        $user = $request->user();
        if (! $user) return redirect()->route('login');

        $request->validate(['token' => ['required', 'string']]);

        $invite = Invitation::where('token', $request->token)->firstOrFail();

        if ($invite->accepted_at || $invite->status !== 'pending') {
            return back()->withErrors(['token' => 'This invitation is already used.']);
        }
        if ($invite->expires_at && Carbon::parse($invite->expires_at)->isPast()) {
            return back()->withErrors(['token' => 'This invitation has expired.']);
        }
        if ($invite->email && strcasecmp($invite->email, $user->email) !== 0) {
            return back()->withErrors(['token' => 'This invitation is not for your email.']);
        }

        $alreadyActive = Membership::where('user_id', $user->id)
            ->whereNull('left_at')
            ->exists();

        if ($alreadyActive) {
            return back()->withErrors(['token' => 'You already belong to an active colocation.']);
        }

        DB::transaction(function () use ($user, $invite) {
            Membership::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'colocation_id' => $invite->colocation_id,
                ],
                [
                    'role' => 'member',
                    'joined_at' => now(),
                    'left_at' => null,
                ]
            );

            $invite->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);
        });

        return redirect()->route('colocations.show', $invite->colocation_id)
            ->with('success', 'You successfully joined the colocation!');
    }
    public function refuse(Request $request)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        $request->validate([
            'token' => ['required', 'string'],
        ]);

        $inv = Invitation::where('token', $request->token)->firstOrFail();

        if ($inv->email && strcasecmp($user->email, $inv->email) !== 0) {
            return back()->withErrors(['token' => "Cette invitation n'est pas pour votre email."]);
        }

        if ($inv->accepted_at || $inv->status !== 'pending') {
            return back()->withErrors(['token' => 'Invitation non valide.']);
        }

        $inv->update(['status' => 'refused']);

        return redirect('/dashboard')->with('success', 'Invitation refusée');
    }
}
