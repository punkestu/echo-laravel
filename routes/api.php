<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/generate-token', [App\Http\Controllers\AuthController::class, 'get_token'])->middleware('auth:sanctum')->name('generate-token');
Route::post('/cart', [App\Http\Controllers\CartController::class, 'add'])->middleware('auth:sanctum')->name('cart.add');