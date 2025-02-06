<?php

use App\Http\Controllers\Auth\LoginController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;



Route::get('/', function () {
    return Inertia::render('Users/Home');
});
Route::get('/shop', function () {
    return Inertia::render('Users/Shop');
});
Route::get('/brand', function () {
    return Inertia::render('Users/Brand');
});
Route::get('/about-us', function () {
    return Inertia::render('Users/About');
});


Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
