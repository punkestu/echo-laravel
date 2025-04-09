<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['welcome', 'user.*'], function ($view) {
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->get();
                $cart_count = $cart->count();
                $view->with('cart_count', $cart_count);
            }
        });
    }
}
