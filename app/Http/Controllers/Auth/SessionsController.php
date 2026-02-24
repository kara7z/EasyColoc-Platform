<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class SessionsController extends Controller
{

    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'email'    => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($validate)) {
            return back()
                ->withErrors(['email' => 'Invalid infos'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        // $user = $request->user();
        // $role = $user->role ?? 'passenger';

        $fallback = '/';
        return redirect()->intended($fallback);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}//
