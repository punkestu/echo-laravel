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

    public function index()
    {
        $users = \App\Models\User::with([]);
        $orderBy = request('orderBy');
        $desc = request('desc');
        $search = request('search');
        if ($search) {
            $users = $users->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('nohp', 'like', "%{$search}%");
        }
        if ($orderBy) {
            $specialorderby = ['total_pesan', 'total_pengeluaran'];
            if (in_array($orderBy, $specialorderby)) {
            } else {
                $users = $users->orderBy($orderBy, $desc ? 'desc' : 'asc');
            }
        }
        $users = $users->get();
        return view('dashboard.user.index', [
            'users' => $users,
            'search' => $search,
            'orderBy' => $orderBy,
            'desc' => $desc,
            'params' => request()->all()
        ]);
    }

    public function api_getUsers(Request $request)
    {
        $users = \App\Models\User::with(["discounts"]);
        $search = $request->input('search');
        if ($search) {
            $users = $users->where('name', 'like', "%{$search}%")
                ->orWhere('nohp', 'like', "%{$search}%");
        }
        return response()->json([
            'data' => $users->get(),
            'message' => 'success',
            'meta' => [
                'total' => $users->count(),
                'search' => $search,
            ]
        ]);
    }
}
