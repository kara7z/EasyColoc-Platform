<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    function create()
    {
        return view('auth.register');
    }

    function store(Request $request)
    {
        $validate = $request->validate([
            'name' => ['required', 'string', 'min:4', 'max:50'],
            'email' => ['required', 'string', 'max:256', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        $isAdmin = false;
        if (User::count() === 0) $isAdmin = true;

        $member = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password']),
            'isAdmin' => $isAdmin,

        ]);

        Auth::login($member);

        return redirect('/');
    }
}
