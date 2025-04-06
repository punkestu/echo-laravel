<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('auth')->group(function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
    Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});