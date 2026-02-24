<?php

use App\Http\Controllers\Auth\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/ui', 'preview');

Route::view('/', 'welcome');



// Auth
Route::get('/register', [UserController::class, 'create'])->name('register');
Route::post('/register', [UserController::class, 'store'])->name('register.store');
// Route::view('/login', '');
//

// App
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
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Route::middleware('auth')->group(function () {
//     Route::put('password', [PasswordController::class, 'update'])->name('password.update');
// });
Route::view('/profile', 'profile.index')->name('profile');
