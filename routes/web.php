<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return redirect("/");
})->name('home');
Route::get("/login", function () {
    return redirect("/#auth");
})->name("login");

Route::prefix('auth')->group(function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login'])->name('auth.login');
    Route::post('register', [App\Http\Controllers\AuthController::class, 'register'])->name('auth.register');
    Route::get('logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/catalog', [App\Http\Controllers\CatalogController::class, 'user_index'])->name('catalog');

Route::group(["prefix" => "/dashboard", "middleware" => [
    'auth',
    'admin'
]], function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'route'])->name('dashboard');
    Route::prefix("/catalog")->group(function () {
        Route::get("/", [App\Http\Controllers\CatalogController::class, 'index'])->name('dashboard.catalog');
        Route::get("/create", [App\Http\Controllers\CatalogController::class, 'create'])->name('dashboard.catalog.create');
        Route::post("/store", [App\Http\Controllers\CatalogController::class, 'store'])->name('dashboard.catalog.store');
        Route::get("/edit/{id}", [App\Http\Controllers\CatalogController::class, 'edit'])->name('dashboard.catalog.edit');
        Route::post("/update/{id}", [App\Http\Controllers\CatalogController::class, 'update'])->name('dashboard.catalog.update');
        Route::get("/delete/{id}", [App\Http\Controllers\CatalogController::class, 'destroy'])->name('dashboard.catalog.delete');
    });
    Route::prefix("/item")->group(function () {
        Route::get("/", [App\Http\Controllers\ItemController::class, 'index'])->name('dashboard.item');
        Route::get("/create", [App\Http\Controllers\ItemController::class, 'create'])->name('dashboard.item.create');
        Route::post("/store", [App\Http\Controllers\ItemController::class, 'store'])->name('dashboard.item.store');
        Route::get("/edit/{id}", [App\Http\Controllers\ItemController::class, 'edit'])->name('dashboard.item.edit');
        Route::post("/update/{id}", [App\Http\Controllers\ItemController::class, 'update'])->name('dashboard.item.update');
        Route::get("/delete/{id}", [App\Http\Controllers\ItemController::class, 'destroy'])->name('dashboard.item.delete');
    });
    Route::prefix('/item-type')->group(function () {
        Route::get('/', [App\Http\Controllers\ItemTypeController::class, 'index'])->name('dashboard.item-type');
        Route::get('/create', [App\Http\Controllers\ItemTypeController::class, 'create'])->name('dashboard.item-type.create');
        Route::post('/store', [App\Http\Controllers\ItemTypeController::class, 'store'])->name('dashboard.item-type.store');
        Route::get('/edit/{id}', [App\Http\Controllers\ItemTypeController::class, 'edit'])->name('dashboard.item-type.edit');
        Route::post('/update/{id}', [App\Http\Controllers\ItemTypeController::class, 'update'])->name('dashboard.item-type.update');
        Route::get('/delete/{id}', [App\Http\Controllers\ItemTypeController::class, 'destroy'])->name('dashboard.item-type.delete');
    });
});
