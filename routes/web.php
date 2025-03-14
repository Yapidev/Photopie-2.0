<?php

use App\Http\Controllers\GoogleAuthController;
use App\Http\Middleware\CheckGuest;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::middleware(CheckGuest::class)->group(function () {
    Route::get('login', App\Livewire\Auth\Login::class)->name('login');
    Route::get('register', App\livewire\Auth\Register::class)->name('register');
    Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.login');
    Route::get('login/google/callback', [GoogleAuthController::class, 'callbackGoogle']);
});

// User Routes
Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('dashboard', App\livewire\User\Dashboard::class)->name('user.dashboard');
});
