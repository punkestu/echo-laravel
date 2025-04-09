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
        $user = User::find(Auth::id());
        $carts = $user->carts()->with(['catalog'])->get();
        return view('user.cart', [
            'carts' => $carts,
        ]);
    }

    public function add(Request $request)
    {
        $user = User::find(Auth::id());
        $cart = $user->carts()->where('catalog_id', $request->catalog_id)->first();

        if ($cart) {
            $cart->increment('qty');
        } else {
            $user->carts()->create([
                'catalog_id' => $request->catalog_id,
                'qty' => $request->qty,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil.',
        ]);
    }

    public function remove($id)
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

        return response()->json([
            'status' => false,
            'message' => 'Gagal.',
        ]);
    }
}
