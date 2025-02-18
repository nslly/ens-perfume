<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Product\CheckoutController;
use App\Http\Controllers\Product\ProductCartController;

Route::middleware(['guest'])->group(function () {

    /**
     * Password Configuration
     * 
     */
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

    /**
     * 
     * Logout
     */
    Route::post('/logout', [LoginController::class, 'destroy'])->name('users.logout');


    /**
     * 
     * User Profile
     */
    Route::get('/profile', function () {
        return Inertia::render('Users/Profile');
    })->name('users.profile');

    /**
     * Product Cart 
     * 
     */
    Route::get('/cart', [ProductCartController::class, 'index'])->name('products.cart');
    Route::post('/cart', [ProductCartController::class, 'store'])->name('products.cart.store');
    Route::delete('/cart/{cart}', [ProductCartController::class, 'destroy'])->name('products.cart.destroy');
    Route::put('/cart/{cart}', [ProductCartController::class, 'update'])->name('products.cart.update');


    Route::post('/cart/checkout', [CheckoutController::class, 'store'])->name('products.cart.checkout');
});






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



/**
 * 
 * Navbar
 */
Route::get('/', [HomeController::class, 'index'])->name('users.home');
Route::get('/shop', function () {
    return Inertia::render('Users/Shop');
})->name('users.shop');
Route::get('/brand', function () {
    return Inertia::render('Users/Brand');
})->name('users.brand');
Route::get('/about-us', function () {
    return Inertia::render('Users/About');
})->name('users.about');
