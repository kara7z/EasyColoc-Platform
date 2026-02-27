<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\PasswordController;

use App\Http\Controllers\Colocations\ColocationController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::view('/', 'index')->name('home');

/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});

Route::delete('/logout', [SessionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Middleware
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'not_banned'])->group(function () {

    // Dashboard
    Route::view('/dashboard', 'dashboard.index')->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Colocations
    |--------------------------------------------------------------------------
    */
    Route::get('/colocations', [ColocationController::class, 'index'])->name('colocations.index');
    Route::get('/colocations/create', [ColocationController::class, 'create'])->name('colocations.create');
    Route::post('/colocations', [ColocationController::class, 'store'])->name('colocations.store');

    Route::get('/colocations/{colocation}', [ColocationController::class, 'show'])->name('colocations.show');

    Route::patch('/colocations/{colocation}/cancel', [ColocationController::class, 'cancel'])->name('colocations.cancel');

    /*
    |--------------------------------------------------------------------------
    | Expenses
    |--------------------------------------------------------------------------
    */

    Route::view('/colocations/{id}/expenses', 'expenses.index')->name('expenses.index');

    Route::middleware('colocation.not_cancelled')->group(function () {
        Route::view('/colocations/{id}/expenses/create', 'expenses.create')->name('expenses.create');
        Route::view('/expenses/{id}/edit', 'expenses.edit')->name('expenses.edit');
    });

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */
    Route::view('/categories', 'categories.index')->name('categories.index');
    Route::view('/categories/create', 'categories.create')->name('categories.create');
    Route::view('/categories/{id}/edit', 'categories.edit')->name('categories.edit');

    /*
    |--------------------------------------------------------------------------
    | Settlements
    |--------------------------------------------------------------------------
    */
    Route::view('/settlements', 'settlements.index')->name('settlements.index');

    /*
    |--------------------------------------------------------------------------
    | Invitations
    |--------------------------------------------------------------------------
    */
    Route::view('/invitations/create', 'invitations.create')->name('invitations.create');
    Route::view('/invite/{token}', 'invitations.accept')->name('invitations.accept');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    Route::view('/admin', 'admin.index')->name('admin.index');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
});
