<?php

namespace App\Http\Controllers;

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
                'qty' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart successfully.');
    }
}
