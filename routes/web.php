<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Fungsi middleware untuk cek autentikasi
function checkAuth($request, $next) {
    if (!session('is_logged_in')) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu');
    }
    return $next($request);
}

// Fungsi middleware untuk guest
function checkGuest($request, $next) {
    if (session('is_logged_in')) {
        return redirect('/dashboard');
    }
    return $next($request);
}

Route::middleware(['web'])->group(function () {
    // Route untuk root
Route::get('/', function () {
        Log::info('Accessing root route');
        if (!session('is_logged_in')) {
            Log::info('Not logged in, redirecting to login');
            return redirect('/login');
        }
        Log::info('Logged in, redirecting to dashboard');
        return redirect('/dashboard');
    });

    // Route untuk login
Route::get('/login', function () {
        Log::info('Accessing login page', [
            'session' => session()->all()
        ]);
        if (session('is_logged_in')) {
            return redirect('/dashboard');
        }
        return view('login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
        Log::info('Login attempt', [
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'session' => session()->all()
        ]);
        
    $username = $request->input('username');
    $password = $request->input('password');
        
    if ($username === 'admin' && $password === 'admin') {
            Log::info('Login successful, setting session');
            session(['is_logged_in' => true]);
            Log::info('Session set, redirecting to dashboard', [
                'session' => session()->all()
            ]);
            return redirect()->intended('/dashboard');
        }
        
        Log::info('Login failed');
    return redirect('/login')->with('error', 'Username atau password salah!');
});

    // Route untuk dashboard (perlu login)
    Route::get('/dashboard', function () {
        Log::info('Accessing dashboard', [
            'session' => session()->all()
        ]);
        if (!session('is_logged_in')) {
        return redirect('/login');
    }
    return view('dashboard');
});

    // Route untuk logout
Route::post('/logout', function (\Illuminate\Http\Request $request) {
        Log::info('Logging out');
        session()->forget('is_logged_in');
        session()->flush();
        return redirect('/login')->with('message', 'Anda telah berhasil logout');
    });

    // Routes untuk manajemen users
    Route::prefix('master-users')->group(function () {
        // Route view utama
        Route::get('/', function () {
            return view('master_users.create');
        })->name('master-users.index');

        // Route untuk create user
        Route::post('/', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'role_id' => 'required|exists:roles,id',
                'unit' => 'nullable|string|max:255',
            ]);

            $validated['password'] = bcrypt($validated['password']);
            
            User::create($validated);

            return redirect()->route('master-users.index')
                ->with('success', 'User berhasil ditambahkan');
        })->name('master-users.store');
    });

    // Routes untuk manajemen role
    Route::prefix('manage-role')->group(function () {
        Route::get('/', function () {
            return view('manage_role.manage_role');
        })->name('manage-role.index');

        Route::post('/', function (\Illuminate\Http\Request $request) {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles',
                'description' => 'nullable|string|max:1000',
                'slug' => 'required|string|max:255|unique:roles'
            ]);
            
            \App\Models\Role::create($validated);

            return redirect()->route('manage-role.index')
                ->with('success', 'Role berhasil ditambahkan');
        })->name('manage-role.store');
    });

    // API Routes (pindahkan ke luar prefix master-users)
    Route::get('/api/users/{id}', function ($id) {
        try {
            $user = User::with('role')->findOrFail($id);
            return response()->json($user);
        } catch (\Exception $e) {
            Log::error('Error fetching user: ' . $e->getMessage());
            return response()->json(['error' => 'User tidak ditemukan'], 404);
        }
    })->name('api.users.show');

    Route::put('/api/users/{id}', function (\Illuminate\Http\Request $request, $id) {
        try {
            $user = User::findOrFail($id);
            
            // Validate request
            $rules = [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $id,
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'role_id' => 'required|exists:roles,id',
                'unit' => 'nullable|string|max:255',
                'is_active' => 'required|boolean',
                'password' => 'nullable|string|min:6',
            ];

            $validated = $request->validate($rules);

            // Only update password if provided
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data' => $user->fresh()->load('role')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error updating user: ' . json_encode($e->errors()));
            return response()->json([
                'success' => false,
                'message' => 'Error validasi',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate user'
            ], 500);
        }
    })->name('api.users.update');

    Route::delete('/api/users/{id}', function ($id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus user'
            ], 500);
        }
    })->name('api.users.delete');

    // API Routes untuk role
    Route::get('/api/roles/{id}', function ($id) {
        try {
            $role = \App\Models\Role::findOrFail($id);
            return response()->json($role);
        } catch (\Exception $e) {
            Log::error('Error fetching role: ' . $e->getMessage());
            return response()->json(['error' => 'Role tidak ditemukan'], 404);
        }
    })->name('api.roles.show');

    Route::put('/api/roles/{id}', function (\Illuminate\Http\Request $request, $id) {
        try {
            $role = \App\Models\Role::findOrFail($id);
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'description' => 'nullable|string|max:1000',
            ]);

            $role->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diupdate',
                'data' => $role->fresh()
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengupdate role'
            ], 500);
        }
    })->name('api.roles.update');

    Route::delete('/api/roles/{id}', function ($id) {
        try {
            $role = \App\Models\Role::findOrFail($id);
            
            if ($role->users()->count() > 0) {
                throw new \Exception('Role masih digunakan oleh beberapa user');
            }
            
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage() ?: 'Terjadi kesalahan saat menghapus role'
            ], 500);
        }
    })->name('api.roles.delete');
});