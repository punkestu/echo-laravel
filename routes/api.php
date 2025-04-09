<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => '/cart', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/', [App\Http\Controllers\CartController::class, 'add'])->middleware('auth:sanctum')->name('cart.add');
    Route::delete('/{id}', [App\Http\Controllers\CartController::class, 'remove'])->middleware('auth:sanctum')->name('cart.remove');
});
