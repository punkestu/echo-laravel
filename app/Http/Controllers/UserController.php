<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController
{
    public function user_index()
    {
        $user = \App\Models\User::where('id', Auth::id())->first();
        return view('user.profile', [
            'user' => $user
        ]);
    }
}
