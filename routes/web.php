<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/ui', 'preview');

Route::view('/', 'welcome');
// Auth
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});

Route::delete('/logout', [SessionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'not_banned'])->group(function () {

    Route::view('/dashboard', 'dashboard.index');

    Route::view('/colocations', 'colocations.index');
    Route::view('/colocations/create', 'colocations.create');
    Route::view('/colocations/{id}', 'colocations.show');

    Route::view('/colocations/{id}/expenses', 'expenses.index');
    Route::view('/colocations/{id}/expenses/create', 'expenses.create');
    Route::view('/expenses/{id}/edit', 'expenses.edit');

    Route::view('/categories', 'categories.index');
    Route::view('/categories/create', 'categories.create');
    Route::view('/categories/{id}/edit', 'categories.edit');

    Route::view('/settlements', 'settlements.index');
    Route::view('/invitations/create', 'invitations.create');
    Route::view('/invite/{token}', 'invitations.accept');

    Route::view('/admin', 'admin.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});
