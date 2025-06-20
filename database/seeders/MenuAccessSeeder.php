<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\MenuAccess;
use Illuminate\Database\Seeder;

class MenuAccessSeeder extends Seeder
{
    protected $defaultMenus = [
        'dashboard', 'master_indikator', 'laporan_analisis',
        'database', 'unit', 'manajemen_user', 'manage_role', 'manajemen_unit', 'hak_akses',
        'cakupan_data', 'dimensi_mutu', 'frekuensi_analisa_data', 'frekuensi_pengumpulan_data',
        'interpretasi_data', 'metodologi_analisa_data', 'metodologi_pengumpulan_data', 'publikasi_data'
    ];

    protected $roleMenus = [
        'unit_head' => ['dashboard', 'laporan_analisis'],
        'unit_staff' => ['dashboard', 'laporan_analisis'],
        'quality_team' => [
            'dashboard', 'master_indikator', 'laporan_analisis',
            'cakupan_data', 'dimensi_mutu', 'frekuensi_analisa_data', 'frekuensi_pengumpulan_data',
            'interpretasi_data', 'metodologi_analisa_data', 'metodologi_pengumpulan_data', 'publikasi_data'
        ],
        'management' => ['dashboard', 'laporan_analisis']
    ];

    public function run()
    {
        // Set up admin access
        $adminRole = Role::where('slug', 'admin')->first();
        if ($adminRole) {
            foreach ($this->defaultMenus as $menu) {
                MenuAccess::firstOrCreate([
                    'role_id' => $adminRole->id,
                    'menu_key' => $menu
                ]);
            }
        }

        // Set up other roles' access
        foreach ($this->roleMenus as $roleSlug => $menus) {
            $role = Role::where('slug', $roleSlug)->first();
            if ($role) {
                foreach ($menus as $menu) {
                    MenuAccess::firstOrCreate([
                        'role_id' => $role->id,
                        'menu_key' => $menu
                    ]);
                }
            }
        }
    }
} 