<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $mutuUnit = Unit::where('code', 'UNT001')->first();

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@rsazra.com',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
            'unit_id' => $mutuUnit->id,
            'is_active' => true
        ]);
    }
} 