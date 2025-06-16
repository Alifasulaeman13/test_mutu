<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KamusIndikatorMutuMasterSeeder extends Seeder
{
    public function run(): void
    {
        // Dimensi Mutu
        DB::table('dimensi_mutu')->insert([
            ['nama' => 'Efektivitas'],
            ['nama' => 'Keselamatan'],
            ['nama' => 'Fokus Kepada Pasien'],
            ['nama' => 'Kesinambungan'],
            ['nama' => 'Aksesibilitas'],
        ]);
        // Metodologi Pengumpulan Data
        DB::table('metodologi_pengumpulan_data')->insert([
            ['nama' => 'Sensus Harian'],
            ['nama' => 'Retrospektif'],
        ]);
        // Cakupan Data
        DB::table('cakupan_data')->insert([
            ['nama' => 'Total'],
            ['nama' => 'Sampel'],
        ]);
        // Frekuensi Pengumpulan Data
        DB::table('frekuensi_pengumpulan_data')->insert([
            ['nama' => 'Harian'],
            ['nama' => 'Mingguan'],
            ['nama' => 'Bulanan'],
        ]);
        // Frekuensi Analisa Data
        DB::table('frekuensi_analisa_data')->insert([
            ['nama' => 'Bulanan'],
            ['nama' => 'Triwulan'],
            ['nama' => 'Semester'],
        ]);
        // Metodologi Analisa Data
        DB::table('metodologi_analisa_data')->insert([
            ['nama' => 'Statistik'],
            ['nama' => 'Run Chart'],
            ['nama' => 'Control Chart'],
            ['nama' => 'Pareto'],
            ['nama' => 'Bar Diagram'],
        ]);
        // Interpretasi Data
        DB::table('interpretasi_data')->insert([
            ['nama' => 'Trend Dibandingkan Dengan Standar'],
            ['nama' => 'Trend Dibandingkan Dengan RS Lain'],
            ['nama' => 'Trend Dibandingkan Dengan Praktek Terbaik'],
        ]);
        // Publikasi Data
        DB::table('publikasi_data')->insert([
            ['nama' => 'Internal'],
            ['nama' => 'Eksternal'],
        ]);

        // Tambah menu Kamus Indikator Mutu ke tabel menu_access (atau menu/akses yang digunakan)
        $menuKey = 'kamus_indikator_mutu';
        $menuName = 'Kamus Indikator Mutu';
        $menuRoute = 'kamus-indikator.index';

        // Contoh: tambahkan ke menu_access untuk role admin
        $adminRoleId = DB::table('roles')->where('slug', 'admin')->value('id');
        if ($adminRoleId) {
            DB::table('menu_access')->updateOrInsert([
                'role_id' => $adminRoleId,
                'menu_key' => $menuKey
            ], [
                'menu_name' => $menuName,
                'menu_route' => $menuRoute
            ]);
        }

        // Tambahkan juga ke role lain jika perlu
    }
} 