<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class AuthController
{
    public function login()
    {
        $validator = validator(
            request()->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ],
            [
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Format email tidak valid',
                'password.required' => 'Password tidak boleh kosong'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Gagal masuk!'
            ])->withErrors($validator)->withInput();
        }
        $credentials = request()->only('email', 'password');
        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->back()->with('alert', [
                'type' => 'success',
                'message' => 'Berhasil masuk!'
            ]);
        }
        return redirect()->back()->with('alert', [
            'type' => 'error',
            'message' => 'Email atau password salah!'
        ]);
    }

    public function register()
    {
        $validator = validator(
            request()->all(),
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8'
            ],
            [
                'name.required' => 'Nama tidak boleh kosong',
                'email.required' => 'Email tidak boleh kosong',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password tidak boleh kosong',
                'password.min' => 'Password minimal 8 karakter'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->with('alert', [
                'type' => 'error',
                'message' => 'Gagal mendaftar!'
            ])->withErrors($validator)->withInput();
        }
        $user = new \App\Models\User();
        $user->name = request('name');
        $user->email = request('email');
        $user->password = bcrypt(request('password'));
        $user->role = request('role', 'user');
        $user->save();
        Auth::login($user);
        request()->session()->regenerate();
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil mendaftar!'
        ]);
    }

    public function logout()
    {
        $user = \App\Models\User::where('id', Auth::id())->first();
        if ($user) {
            $user->tokens()->delete();
        }
        Auth::logout();
        return redirect()->back()->with('alert', [
            'type' => 'success',
            'message' => 'Berhasil keluar!'
        ]);
    }

    public function getToken()
    {
        if (Auth::check()) {
            $user = \App\Models\User::where('id', Auth::id())->first();
            $token = $user->createToken('api-token');
            return response()->json(['token' => $token->plainTextToken]);
        }
        return response()->json([
            'error' => 'Unauthorized'
        ], 401);
    }
}
