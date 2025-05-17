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
    Route::post('generate-token', [App\Http\Controllers\AuthController::class, 'getToken'])->middleware('auth')->name('generate-token');
    Route::post('set-nohp', [App\Http\Controllers\AuthController::class, 'setNoHp'])->middleware('auth')->name('set-nohp');
});

Route::get('/profile', [App\Http\Controllers\UserController::class, 'user_index'])->middleware('auth')->name('profile');
Route::get('/catalog', [App\Http\Controllers\CatalogController::class, 'user_index'])->name('catalog');
Route::get('/cart', [App\Http\Controllers\CartController::class, 'user_index'])->middleware(['auth'])->name('cart');
Route::get('/gallery', [App\Http\Controllers\GalleryController::class, 'user_index'])->name('gallery');
Route::get("/destination", [App\Http\Controllers\DestinationController::class, 'user_index'])->name('destination');

Route::group(["prefix" => "/dashboard", "middleware" => [
    'auth',
    'admin'
]], function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'route'])->name('dashboard');
    Route::prefix("/discount")->group(function () {
        Route::get("/", [App\Http\Controllers\DiscountController::class, 'index'])->name('dashboard.discount');
        Route::get("/create", [App\Http\Controllers\DiscountController::class, 'create'])->name('dashboard.discount.create');
        Route::post("/store", [App\Http\Controllers\DiscountController::class, 'store'])->name('dashboard.discount.store');
        Route::get("/edit/{id}", [App\Http\Controllers\DiscountController::class, 'edit'])->name('dashboard.discount.edit');
        Route::post("/update/{id}", [App\Http\Controllers\DiscountController::class, 'update'])->name('dashboard.discount.update');
        Route::get("/delete/{id}", [App\Http\Controllers\DiscountController::class, 'destroy'])->name('dashboard.discount.delete');
    });
    Route::prefix("/order")->group(function () {
        Route::get("/", [App\Http\Controllers\OrderController::class, 'index'])->name('dashboard.order');
        Route::get("/create", [App\Http\Controllers\OrderController::class, 'create'])->name('dashboard.order.create');
        Route::post("/store", [App\Http\Controllers\OrderController::class, 'store'])->name('dashboard.order.store');
        Route::get("/edit/{id}", [App\Http\Controllers\OrderController::class, 'edit'])->name('dashboard.order.edit');
        Route::post("/update/{id}", [App\Http\Controllers\OrderController::class, 'update'])->name('dashboard.order.update');
        Route::post("/put/status/{id}", [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('dashboard.order.put-status');
        Route::get("/delete/{id}", [App\Http\Controllers\OrderController::class, 'destroy'])->name('dashboard.order.delete');
    });
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
    Route::prefix("/gallery")->group(function () {
        Route::get("/", [App\Http\Controllers\GalleryController::class, 'index'])->name('dashboard.gallery');
        Route::get("/create", [App\Http\Controllers\GalleryController::class, 'create'])->name('dashboard.gallery.create');
        Route::post("/store", [App\Http\Controllers\GalleryController::class, 'store'])->name('dashboard.gallery.store');
        Route::get("/edit/{id}", [App\Http\Controllers\GalleryController::class, 'edit'])->name('dashboard.gallery.edit');
        Route::post("/update/{id}", [App\Http\Controllers\GalleryController::class, 'update'])->name('dashboard.gallery.update');
        Route::get("/delete/{id}", [App\Http\Controllers\GalleryController::class, 'destroy'])->name('dashboard.gallery.delete');
    });
    Route::prefix("/destination")->group(function () {
        Route::get("/", [App\Http\Controllers\DestinationController::class, 'index'])->name('dashboard.destination');
        Route::get("/create", [App\Http\Controllers\DestinationController::class, 'create'])->name('dashboard.destination.create');
        Route::post("/store", [App\Http\Controllers\DestinationController::class, 'store'])->name('dashboard.destination.store');
        Route::get("/edit/{id}", [App\Http\Controllers\DestinationController::class, 'edit'])->name('dashboard.destination.edit');
        Route::post("/update/{id}", [App\Http\Controllers\DestinationController::class, 'update'])->name('dashboard.destination.update');
        Route::get("/delete/{id}", [App\Http\Controllers\DestinationController::class, 'destroy'])->name('dashboard.destination.delete');
    });
    Route::prefix("/customer")->group(function () {
        Route::get("/", [App\Http\Controllers\CustomerController::class, 'index'])->name('dashboard.customer');
        Route::get("/create", [App\Http\Controllers\CustomerController::class, 'create'])->name('dashboard.customer.create');
        Route::post("/store", [App\Http\Controllers\CustomerController::class, 'store'])->name('dashboard.customer.store');
        Route::get("/edit/{id}", [App\Http\Controllers\CustomerController::class, 'edit'])->name('dashboard.customer.edit');
        Route::post("/update/{id}", [App\Http\Controllers\CustomerController::class, 'update'])->name('dashboard.customer.update');
        Route::get("/delete/{id}", [App\Http\Controllers\CustomerController::class, 'destroy'])->name('dashboard.customer.delete');
    });
    Route::prefix("/user")->group(function () {
        Route::get("/", [App\Http\Controllers\UserController::class, 'index'])->name('dashboard.user');
    });
});
