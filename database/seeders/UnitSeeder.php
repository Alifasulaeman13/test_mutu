<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run()
    {
        $units = [
            [
                'name' => 'Unit Mutu',
                'code' => 'UNT001',
                'description' => 'Unit yang menangani mutu rumah sakit',
                'is_active' => true
            ],
            [
                'name' => 'Unit Pelayanan',
                'code' => 'UNT002',
                'description' => 'Unit yang menangani pelayanan pasien',
                'is_active' => true
            ],
            [
                'name' => 'Unit Keuangan',
                'code' => 'UNT003',
                'description' => 'Unit yang menangani keuangan rumah sakit',
                'is_active' => true
            ]
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
} 