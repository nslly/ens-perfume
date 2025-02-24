<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\ProductAdminController;

/**
 * ---------------------
 * 
 *  Admin Routes 
 * 
 * -----------------------
 */

Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');


    Route::get('products', [ProductAdminController::class, 'index'])->name('products.index');


    /**
     * 
     * Logout
     */
    Route::post('/logout', [AdminLoginController::class, 'destroy'])->name('logout');
});



Route::middleware(['alreadyAuth'])->group(function () {


    /**
     * -----------------
     * 
     *  Admin Authentication
     * 
     * ------------------
     */
    Route::get('admin/login', [AdminLoginController::class, 'index'])->name('login');
    Route::post('admin/login', [AdminLoginController::class, 'store'])->name('login.store');
});
