<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Colocation;

class EnsureColocationNotCancelled
{
    public function handle(Request $request, Closure $next)
    {
        $id = $request->route('id') ?? $request->route('colocation');
        $colocation = $id instanceof Colocation ? $id : Colocation::find($id);

        if ($colocation && $colocation->status === 'cancelled') {
            abort(403, 'Colocation annulée (lecture seule).');
        }

        return $next($request);
    }
}
