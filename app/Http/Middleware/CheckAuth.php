<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('CheckAuth middleware', [
            'session' => session()->all(),
            'is_logged_in' => session('is_logged_in')
        ]);

        if (!session('is_logged_in')) {
            Log::info('Not logged in, redirecting to login');
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
        }

        Log::info('Auth check passed');
        return $next($request);
    }
} 