<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Colocation;

class MemberMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $colocation = $request->route('colocation');

        if (!$colocation instanceof Colocation) {
            $colocation = Colocation::findOrFail($colocation);
        }

        $isMember = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivotNull('left_at')
            ->exists();

        if (!$isMember) {
            abort(403, 'Members only.');
        }

        return $next($request);
    }
}
