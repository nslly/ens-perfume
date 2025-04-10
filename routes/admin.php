<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Filepond\FileUploadController;

/**
 * ---------------------
 * 
 *  Admin Routes 
 * 
 * -----------------------
 */

Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('products/create', [ProductAdminController::class, 'create'])->name('products.create');
    Route::post('products', [ProductAdminController::class, 'store'])->name('products.store');
    Route::get('products', [ProductAdminController::class, 'index'])->name('products.index');
    Route::get('products/{product}/edit', [ProductAdminController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductAdminController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductAdminController::class, 'destroy'])->name('products.destroy');



    /**
     * Filepond Routes
     */

    Route::post('/upload', [FileUploadController::class, 'upload']); // For file uploads
    Route::get('/upload/load', [FileUploadController::class, 'load']); // For loading files
    Route::delete('/upload/delete', [FileUploadController::class, 'delete']); // For deleting files

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
