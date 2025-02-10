<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;



Route::middleware(['guest'])->group(function () {
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])
        ->name('password.email');
    Route::get('/forgot-password', function () {
        return Inertia::render('Users/Authentication/ForgotPassword');
    });

    Route::post('/reset-password', [PasswordResetController::class, 'reset'])
        ->name('password.update');

    Route::get('/reset-password', function () {
        return Inertia::render('Users/Authentication/ResetPassword');
    });
});
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    Route::get('/profile', function () {
        return Inertia::render('Users/Profile');
    })->name('users.profile');
});
Route::get('/', function () {
    return Inertia::render('Users/Home');
})->name('users.home');
Route::get('/shop', function () {
    return Inertia::render('Users/Shop');
})->name('users.shop');
Route::get('/brand', function () {
    return Inertia::render('Users/Brand');
})->name('users.brand');
Route::get('/about-us', function () {
    return Inertia::render('Users/About');
})->name('users.about');


Route::middleware([RedirectIfAuthenticated::class])->group(function () {

    /**
     * 
     * Authentication 
     */
    Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginController::class, 'index'])->name('login.index');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});
