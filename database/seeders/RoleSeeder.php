<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Super admin dengan akses penuh'
            ],
            [
                'name' => 'Kepala Unit',
                'slug' => 'unit_head',
                'description' => 'Kepala unit dengan akses ke data unit'
            ],
            [
                'name' => 'Staff Unit',
                'slug' => 'unit_staff',
                'description' => 'Staff unit dengan akses terbatas'
            ],
            [
                'name' => 'Tim Mutu',
                'slug' => 'quality_team',
                'description' => 'Tim mutu dengan akses ke semua data mutu'
            ],
            [
                'name' => 'Manajemen',
                'slug' => 'management',
                'description' => 'Manajemen dengan akses monitoring'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
} 