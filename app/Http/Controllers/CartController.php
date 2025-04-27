<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController
{
    public function user_index()
    {
        $carts = Cart::get_cached(Auth::id());
        return view('user.cart', [
            'carts' => $carts,
        ]);
    }

    public function api_add(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->where('catalog_id', $request->catalog_id)->first();

        if ($cart) {
            $cart->increment('qty');
        } else {
            /** @var User $user */
            $user = Auth::user();
            $user->carts()->create([
                'catalog_id' => $request->catalog_id,
                'qty' => $request->qty,
            ]);
        }

        Cart::sync_cache(Auth::id());

        return response()->json([
            'status' => true,
            'message' => 'Berhasil.',
        ]);
    }

    public function api_remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->first();

        if ($cart) {
            $cart->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil.',
            ]);
        }
        
        Cart::sync_cache(Auth::id());

        return response()->json([
            'status' => false,
            'message' => 'Gagal.',
        ]);
    }
}
