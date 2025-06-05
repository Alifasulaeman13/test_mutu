<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('welcome', ['showLogin' => true]);
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');
    if ($username === 'admin' && $password === 'admin') {
        $request->session()->put('is_logged_in', true);
        return redirect('/dashboard');
    }
    return redirect('/login')->with('error', 'Username atau password salah!');
});

Route::get('/dashboard', function (\Illuminate\Http\Request $request) {
    if (!$request->session()->get('is_logged_in')) {
        return redirect('/login');
    }
    return view('dashboard');
});

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    $request->session()->forget('is_logged_in');
    return redirect('/login');
});
