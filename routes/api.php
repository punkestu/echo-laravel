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

Route::get('/users', [App\Http\Controllers\UserController::class, 'api_getUsers'])->middleware('auth:sanctum')->name('api.users');
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'api_getCustomers'])->middleware('auth:sanctum')->name('api.customers');
Route::get('/order/{id}/items', [App\Http\Controllers\OrderController::class, 'api_getItems'])->middleware('auth:sanctum')->name('api.order.items');
