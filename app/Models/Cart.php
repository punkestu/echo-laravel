<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'catalog_id',
        'qty',
    ];

    public static function get_cached($user_id)
    {
        $cart = Cache::get("cart" . $user_id);
        if (!$cart) {
            $cart = Cart::with(["catalog"])->where("user_id", $user_id)->get();
            Cache::put("cart" . $user_id, $cart);
        }

        return $cart;
    }

    public static function sync_cache($user_id)
    {
        $cart = Cart::with(["catalog"])->where("user_id", $user_id)->get();
        Cache::put("cart" . $user_id, $cart);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }
}
