<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $menuList = [
            'utama' => [
                [
                    'key' => 'dashboard',
                    'label' => 'Dashboard',
                    'icon' => 'ri-dashboard-line',
                    'route' => 'dashboard',
                ],
                [ 
                    'key' => 'laporan_analisis', 
                    'label' => 'Laporan dan Analisis', 
                    'icon' => 'ri-file-chart-line', 
                    'route' => 'laporan-analisis.index' 
                ],
                [ 
                    'key' => 'kamus_indikator_mutu', 
                    'label' => 'Kamus Indikator Mutu', 
                    'icon' => 'ri-book-2-line', 
                    'route' => 'kamus-indikator.index' 
                ],
            ],
            'manajemen_mutu' => [
                [ 'key' => 'master_indikator', 'label' => 'Master Indikator', 'icon' => 'ri-list-check-2', 'route' => 'master-indikator.index' ],
                [ 'key' => 'formula', 'label' => 'Formula', 'icon' => 'ri-functions', 'route' => 'master-indikator.formula.index' ],
                [ 'key' => 'cakupan_data', 'label' => 'Cakupan Data', 'icon' => 'ri-checkbox-multiple-blank-line', 'route' => 'cakupan_data.index' ],
                [ 'key' => 'dimensi_mutu', 'label' => 'Dimensi Mutu', 'icon' => 'ri-shape-2-line', 'route' => 'dimensi_mutu.index' ],
                [ 'key' => 'frekuensi_analisa_data', 'label' => 'Frekuensi Analisa Data', 'icon' => 'ri-bar-chart-2-line', 'route' => 'frekuensi_analisa_data.index' ],
                [ 'key' => 'frekuensi_pengumpulan_data', 'label' => 'Frekuensi Pengumpulan Data', 'icon' => 'ri-calendar-check-line', 'route' => 'frekuensi_pengumpulan_data.index' ],
                [ 'key' => 'interpretasi_data', 'label' => 'Interpretasi Data', 'icon' => 'ri-lightbulb-flash-line', 'route' => 'interpretasi_data.index' ],
                [ 'key' => 'metodologi_analisa_data', 'label' => 'Metodologi Analisa Data', 'icon' => 'ri-flask-line', 'route' => 'metodologi_analisa_data.index' ],
                [ 'key' => 'metodologi_pengumpulan_data', 'label' => 'Metodologi Pengumpulan Data', 'icon' => 'ri-database-2-line', 'route' => 'metodologi_pengumpulan_data.index' ],
                [ 'key' => 'publikasi_data', 'label' => 'Publikasi Data', 'icon' => 'ri-share-forward-line', 'route' => 'publikasi_data.index' ],
            ],
            'manajemen_mutu_lain' => [],
            'pengaturan' => [
                [ 'key' => 'database', 'label' => 'Database', 'icon' => 'ri-database-2-line', 'route' => '#' ],
                [ 'key' => 'unit', 'label' => 'Unit', 'icon' => 'ri-building-2-line', 'route' => '#' ],
                [ 'key' => 'manajemen_user', 'label' => 'Manajemen User', 'icon' => 'ri-user-settings-line', 'route' => 'master-users.index' ],
                [ 'key' => 'manage_role', 'label' => 'Manage Role', 'icon' => 'ri-shield-user-line', 'route' => 'manage-role.index' ],
                [ 'key' => 'manajemen_unit', 'label' => 'Manajemen Unit', 'icon' => 'ri-building-2-line', 'route' => 'master.units.index' ],
                [ 'key' => 'hak_akses', 'label' => 'Hak Akses', 'icon' => 'ri-shield-check-line', 'route' => 'manage-akses.index' ],
            ],
        ];
        View::share('menuList', $menuList);
    }
}
