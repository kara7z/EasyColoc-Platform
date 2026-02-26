<?php

namespace App\Http\Controllers\Colocations;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Membership;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    public function index()
    {
        $userId = request()->user()->id;

        $activeColocation = Colocation::whereHas('memberships', function ($q) use ($userId) {
            $q->where('user_id', $userId)->whereNull('left_at');
        })
            ->where('status', 'active')
            ->latest()
            ->first();

        $colocations = Colocation::whereHas('memberships', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
            ->latest()
            ->get();

        return view('colocations.index', compact('activeColocation', 'colocations'));
    }
    function create()
    {
        return view('colocations.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'min:4', 'string', 'max:20'],
            'description' => ['nullable', 'string', 'min:6', 'max:300'],
        ]);

        $userId = request()->user()->id;
        $alreadyActive = Membership::where('user_id', $userId)
            ->whereNull('left_at')
            ->exists();

        if ($alreadyActive) {
            return back()->withErrors(['name' => 'Vous avez déjà une colocation active.'])->withInput();
        }

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
        ]);

        return redirect()->route('colocations.index');
    }
}
