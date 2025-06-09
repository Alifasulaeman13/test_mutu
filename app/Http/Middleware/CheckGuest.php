<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckGuest
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('CheckGuest middleware', [
            'session' => session()->all(),
            'is_logged_in' => session('is_logged_in')
        ]);

        if (session('is_logged_in')) {
            Log::info('Already logged in, redirecting to dashboard');
            return redirect('/dashboard');
        }

        Log::info('Guest check passed');
        return $next($request);
    }
} 