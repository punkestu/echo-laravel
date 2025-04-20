<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => '/cart', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/', [App\Http\Controllers\CartController::class, 'api_add'])->middleware('auth:sanctum')->name('cart.add');
    Route::delete('/{id}', [App\Http\Controllers\CartController::class, 'api_remove'])->middleware('auth:sanctum')->name('cart.remove');
});

Route::get('/validate-token', [App\Http\Controllers\AuthController::class, 'api_validateToken'])->name('api.validate-token');
Route::get('/users', [App\Http\Controllers\UserController::class, 'api_getUsers'])->middleware('auth:sanctum')->name('api.users');
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'api_getCustomers'])->middleware('auth:sanctum')->name('api.customers');
Route::get('/order/{id}/items', [App\Http\Controllers\OrderController::class, 'api_getItems'])->middleware('auth:sanctum')->name('api.order.items');
