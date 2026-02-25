<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Colocation;

class OwnerMiddleware
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

        $isOwner = $colocation->members()
            ->where('users.id', $user->id)
            ->wherePivot('role', 'owner')
            ->wherePivotNull('left_at')
            ->exists();

        if (!$isOwner) {
            abort(403, 'Owner access only.');
        }

        return $next($request);
    }
}
