<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\PasswordController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Colocations\ColocationController;
use App\Http\Controllers\Colocations\InvitationController;
use App\Http\Controllers\Colocations\MemberController;
use App\Http\Controllers\Finance\ExpenseController;
use App\Http\Controllers\Finance\SettlementController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::view('/', 'index')->name('home');

/*
|--------------------------------------------------------------------------
| Register / Login
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::delete('/logout', [SessionsController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Public invitation
|--------------------------------------------------------------------------
*/
Route::get('/invitations/accept', [InvitationController::class, 'check'])
    ->name('invitations.check');

/*
|--------------------------------------------------------------------------
| Authenticated Area
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'not_banned'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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
    | Members
    |--------------------------------------------------------------------------
    */
    Route::delete('/colocations/{colocation}/members/{user}', [MemberController::class, 'destroy'])
        ->name('colocations.members.destroy');

    Route::delete('/colocations/{colocation}/leave', [MemberController::class, 'leave'])
        ->name('colocations.leave');

    /*
    |--------------------------------------------------------------------------
    | Invitations
    |--------------------------------------------------------------------------
    */
    Route::middleware('owner')->group(function () {
        Route::get('/colocations/{colocation}/invitations', [InvitationController::class, 'create'])
        ->name('invitations.create');

        Route::post('/colocations/{colocation}/invitations', [InvitationController::class, 'store'])
        ->name('invitations.store');
    });

    Route::post('/invitations/accept', [InvitationController::class, 'accept'])
        ->name('invitations.accept');

    Route::post('/invitations/refuse', [InvitationController::class, 'refuse'])
        ->name('invitations.refuse');

    /*
    |--------------------------------------------------------------------------
    | Expenses
    |--------------------------------------------------------------------------
    */
    Route::get('/colocations/{id}/expenses', [ExpenseController::class, 'index'])->name('expenses.index');

    Route::middleware('colocation.not_cancelled')->group(function () {
        Route::get('/colocations/{id}/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
        Route::post('/colocations/{id}/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
        Route::get('/expenses/{expense}/edit', [ExpenseController::class, 'edit'])->name('expenses.edit');
        Route::patch('/expenses/{expense}', [ExpenseController::class, 'update'])->name('expenses.update');
        Route::delete('/expenses/{expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    /*
    |--------------------------------------------------------------------------
    | Settlements
    |--------------------------------------------------------------------------
    */
    Route::get('/settlements', [SettlementController::class, 'index'])->name('settlements.index');
    Route::post('/settlements/mark-paid', [SettlementController::class, 'markPaid'])->name('settlements.markPaid');

    /*
    |--------------------------------------------------------------------------
    | Admin
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');
        Route::patch('/admin/users/{user}/ban', [\App\Http\Controllers\Admin\AdminController::class, 'ban'])->name('admin.users.ban');
        Route::patch('/admin/users/{user}/unban', [\App\Http\Controllers\Admin\AdminController::class, 'unban'])->name('admin.users.unban');
    });

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
