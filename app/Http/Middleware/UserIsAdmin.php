<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->role != 'admin') {
            // Redirect to the home page or show an error message
            return redirect('/')->with('alert', [
                'type' => 'error',
                'message' => 'Anda tidak memiliki akses ke halaman ini.',
            ]);
        }
        return $next($request);
    }
}
