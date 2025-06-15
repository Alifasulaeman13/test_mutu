<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\MenuAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ManageAksesController extends Controller
{
    protected $defaultMenus = [
        'dashboard', 'master_indikator', 'formula', 'laporan_analisis',
        'database', 'unit', 'manajemen_user', 'manage_role', 'manajemen_unit', 'hak_akses'
    ];

    public function index()
    {
        $roles = Role::all();
        $menuAccess = MenuAccess::all()->groupBy('role_id');
        
        // Set default akses untuk Administrator
        $adminRole = $roles->where('slug', 'admin')->first();
        if ($adminRole) {
            if (!isset($menuAccess[$adminRole->id])) {
                $menuAccess[$adminRole->id] = collect($this->defaultMenus)->map(function($menu) {
                    return (object)[
                        'menu_key' => $menu
                    ];
                });
            }
        }

        // Log akses ke halaman
        Log::info('User mengakses halaman manajemen hak akses', [
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'timestamp' => now()
        ]);

        return view('manage_akses.hak_akses', compact('roles', 'menuAccess'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'menu_access' => 'array'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::find($request->role_id);
            $oldAccess = MenuAccess::where('role_id', $request->role_id)->pluck('menu_key')->toArray();
            
            // Log perubahan yang akan dilakukan
            Log::info('Memulai perubahan hak akses', [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'role_name' => $role->name,
                'old_access' => $oldAccess,
                'timestamp' => now()
            ]);

            // Jika role adalah admin, berikan akses penuh
            if ($role->slug === 'admin') {
                MenuAccess::where('role_id', $request->role_id)->delete();
                foreach ($this->defaultMenus as $menu) {
                    MenuAccess::create([
                        'role_id' => $request->role_id,
                        'menu_key' => $menu
                    ]);
                }

                // Log pemberian akses admin
                Log::info('Memberikan akses penuh untuk Administrator', [
                    'role_name' => $role->name,
                    'menus' => $this->defaultMenus,
                    'user_id' => Auth::id(),
                    'timestamp' => now()
                ]);
            } else {
                // Untuk role lain, gunakan input yang dipilih
                MenuAccess::where('role_id', $request->role_id)->delete();
                $newAccess = $request->menu_access ?? [];

                if (!empty($newAccess)) {
                    foreach ($newAccess as $menuKey) {
                        MenuAccess::create([
                            'role_id' => $request->role_id,
                            'menu_key' => $menuKey
                        ]);
                    }
                }

                // Log perubahan hak akses untuk role non-admin
                Log::info('Mengubah hak akses role', [
                    'role_name' => $role->name,
                    'old_access' => $oldAccess,
                    'new_access' => $newAccess,
                    'changed_by_user' => Auth::user()->name,
                    'timestamp' => now()
                ]);

                // Log detail perubahan
                $addedMenus = array_diff($newAccess, $oldAccess);
                $removedMenus = array_diff($oldAccess, $newAccess);

                if (!empty($addedMenus)) {
                    Log::info('Menu yang ditambahkan', [
                        'role_name' => $role->name,
                        'menus' => $addedMenus,
                        'user_id' => Auth::id(),
                        'timestamp' => now()
                    ]);
                }

                if (!empty($removedMenus)) {
                    Log::info('Menu yang dihapus', [
                        'role_name' => $role->name,
                        'menus' => $removedMenus,
                        'user_id' => Auth::id(),
                        'timestamp' => now()
                    ]);
                }
            }

            DB::commit();

            // Log sukses
            Log::info('Berhasil memperbarui hak akses', [
                'role_name' => $role->name,
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->back()->with('success', 'Hak akses berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();

            // Log error
            Log::error('Gagal memperbarui hak akses', [
                'role_name' => $role->name ?? 'unknown',
                'error_message' => $e->getMessage(),
                'user_id' => Auth::id(),
                'timestamp' => now()
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
