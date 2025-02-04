<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return Inertia::render('App', [
        'message' => 'Welcome to Laravel with Inertia and Vue!',
    ]);
});
