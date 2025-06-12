<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\IndicatorController;
use App\Http\Controllers\IndicatorFormulaController;
use App\Http\Controllers\DailyIndicatorDataController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MonthlyIndicatorDataController;

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
            'session' => session()->all()
        ]);
        
    $username = $request->input('username');
    $password = $request->input('password');
        
        $user = User::where('username', $username)
            ->where('is_active', true)
            ->first();
        
        if ($user && Hash::check($password, $user->password)) {
            Log::info('Login successful, setting session');
            session([
                'is_logged_in' => true,
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_role' => $user->role->slug
            ]);
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
    Route::prefix('master-users')->name('master-users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
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

    // Routes untuk manajemen unit
    Route::prefix('master-units')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('master.units.index');
        Route::get('/create', [UnitController::class, 'create'])->name('master.units.create');
        Route::post('/', [UnitController::class, 'store'])->name('master.units.store');
        Route::get('/{unit}/edit', [UnitController::class, 'edit'])->name('master.units.edit');
        Route::put('/{unit}', [UnitController::class, 'update'])->name('master.units.update');
        Route::delete('/{unit}', [UnitController::class, 'destroy'])->name('master.units.destroy');
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
            Log::info('Updating user', [
                'user_id' => $id,
                'request_data' => $request->all()
            ]);
            
            $user = User::findOrFail($id);
            
            // Validate request
            $rules = [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . $id,
                'email' => 'required|email|max:255|unique:users,email,' . $id,
                'role_id' => 'required|exists:roles,id',
                'unit_id' => 'nullable|exists:units,id',
                'is_active' => 'required|boolean',
                'password' => 'nullable|string|min:6',
            ];

            $validated = $request->validate($rules);
            
            Log::info('Validation passed', [
                'validated_data' => $validated
            ]);

            // Only update password if provided
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);
            
            Log::info('User updated successfully', [
                'user_id' => $id,
                'updated_data' => $validated
            ]);

            return response()->json([
                'success' => true,
                'message' => 'User berhasil diupdate',
                'data' => $user->fresh()->load('role')
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error updating user', [
                'user_id' => $id,
                'errors' => $e->errors()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error validasi',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error updating user', [
                'user_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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

    // API Routes untuk unit
    Route::get('/api/units', function () {
        $units = Unit::orderBy('name')->get();
        return response()->json($units);
    })->name('api.units.index');

    Route::get('/api/units/{id}', function ($id) {
        try {
            $unit = Unit::findOrFail($id);
            return response()->json($unit);
        } catch (\Exception $e) {
            Log::error('Error fetching unit: ' . $e->getMessage());
            return response()->json(['error' => 'Unit tidak ditemukan'], 404);
        }
    })->name('api.units.show');

    // Routes untuk master indikator
    Route::prefix('master-indikator')->name('master-indikator.')->middleware(['web'])->group(function () {
        // Main Indicator Routes
        Route::get('/', [IndicatorController::class, 'index'])->name('index');
        Route::get('/create', [IndicatorController::class, 'create'])->name('create');
        Route::post('/', [IndicatorController::class, 'store'])->name('store');
        Route::get('/{indicator}/edit', [IndicatorController::class, 'edit'])->name('edit');
        Route::put('/{indicator}', [IndicatorController::class, 'update'])->name('update');
        Route::delete('/{indicator}', [IndicatorController::class, 'destroy'])->name('destroy');

        // Formula Routes
        Route::get('/formula', [IndicatorFormulaController::class, 'index'])->name('formula.index');
        Route::get('/formula/create', [IndicatorFormulaController::class, 'create'])->name('formula.create');
        Route::post('/formula', [IndicatorFormulaController::class, 'store'])->name('formula.store');
        Route::get('/formula/{formula}/edit', [IndicatorFormulaController::class, 'edit'])->name('formula.edit');
        Route::put('/formula/{formula}', [IndicatorFormulaController::class, 'update'])->name('formula.update');
        Route::delete('/formula/{formula}', [IndicatorFormulaController::class, 'destroy'])->name('formula.destroy');
    });

    // Routes untuk laporan dan analisis
    Route::prefix('laporan-analisis')->name('laporan-analisis.')->group(function () {
        Route::get('/', [MonthlyIndicatorDataController::class, 'index'])->name('index');
        Route::get('/create', [MonthlyIndicatorDataController::class, 'create'])->name('create');
        Route::post('/', [MonthlyIndicatorDataController::class, 'store'])->name('store');
        Route::get('/{monthlyData}/edit', [MonthlyIndicatorDataController::class, 'edit'])->name('edit');
        Route::put('/{monthlyData}', [MonthlyIndicatorDataController::class, 'update'])->name('update');
        Route::delete('/{monthlyData}', [MonthlyIndicatorDataController::class, 'destroy'])->name('destroy');
    });
});

// Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Routes untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Laporan & Analisis Routes
    Route::prefix('laporan-analisis')->name('laporan-analisis.')->group(function () {
        Route::get('/', [MonthlyIndicatorDataController::class, 'index'])->name('index');
        Route::get('/create', [MonthlyIndicatorDataController::class, 'create'])->name('create');
        Route::post('/', [MonthlyIndicatorDataController::class, 'store'])->name('store');
        Route::get('/{monthlyData}/edit', [MonthlyIndicatorDataController::class, 'edit'])->name('edit');
        Route::put('/{monthlyData}', [MonthlyIndicatorDataController::class, 'update'])->name('update');
        Route::delete('/{monthlyData}', [MonthlyIndicatorDataController::class, 'destroy'])->name('destroy');
    });
});