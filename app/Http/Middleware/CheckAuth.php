<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('CheckAuth middleware running', [
            'session_all' => session()->all(),
            'is_logged_in' => session('is_logged_in'),
            'user_id' => session('user_id'),
            'user_name' => session('user_name'),
            'user_role' => session('user_role'),
            'request_path' => $request->path(),
            'request_method' => $request->method()
        ]);

        if (!session('is_logged_in')) {
            Log::warning('Auth check failed - User not logged in', [
                'redirect_to' => '/login',
                'current_url' => $request->fullUrl()
            ]);
            return redirect('/login')
                ->with('error', 'Silakan login terlebih dahulu')
                ->with('intended_url', $request->fullUrl());
        }

        Log::info('Auth check passed', [
            'user_id' => session('user_id'),
            'user_role' => session('user_role')
        ]);
        
        return $next($request);
    }
} 