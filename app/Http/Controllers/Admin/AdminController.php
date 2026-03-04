<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Colocation;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->get()->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->isAdmin ? 'Admin' : 'User',
                'banned' => $user->isBanned,
                'reputation' => (int) $user->reputation,
            ];
        });

        $stats = [
            'users' => User::count(),
            'colocations' => Colocation::count(),
            'expenses' => Expense::count(),
            'banned' => User::where('isBanned', true)->count(),
        ];

        return view('admin.index', compact('users', 'stats'));
    }

    public function ban(Request $request, User $user)
    {
        if ($request->user()->id === $user->id) {
            return back()->withErrors(['admin' => 'Vous ne pouvez pas vous bannir vous-même.']);
        }

        $user->update(['isBanned' => true]);
        return back()->with('success', 'User banned successfully');
    }

    public function unban(User $user)
    {
        $user->update(['isBanned' => false]);
        return back()->with('success', 'User unbanned successfully');
    }
}
