@extends('layouts.app')

@section('title', 'Indikator Mutu')
@section('page-title', 'Indikator Mutu')

@section('styles')
.dashboard-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.section-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.header-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    font-weight: 600;
}

.header-title i {
    font-size: 1.25rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.search-wrapper {
    position: relative;
    width: 240px;
}

.search-wrapper i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 1rem;
}

.search-input {
    width: 100%;
    padding: 0.5rem 1rem 0.5rem 2.25rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px var(--primary-color);
}

.section-body {
    padding: 1.5rem;
    overflow-x: auto;
}

.action-buttons {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.btn-primary {
    background: var(--primary-color);
    color: white;
    border: none;
}

.btn-primary:hover {
    background: var(--primary-dark);
}

.btn-outline {
    background: white;
    border: 1px solid #e2e8f0;
    color: #64748b;
}

.btn-outline:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.month-header {
    text-align: center;
    font-weight: 500;
    background-color: #f8fafc;
    padding: 8px;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.875rem;
}

.dates-row {
    display: flex;
    flex-wrap: nowrap;
    border-bottom: 1px solid #e2e8f0;
    font-size: 0.875rem;
}

.date-cell {
    min-width: 30px;
    text-align: center;
    padding: 4px;
    border-right: 1px solid #e2e8f0;
    font-size: 0.875rem;
}

.month-selector {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.month-selector select {
    padding: 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    background-color: white;
    cursor: pointer;
}

.month-selector select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px var(--primary-color);
}
@endsection

@section('content')
@php
    $currentMonth = request('bulan', date('n'));
    $currentYear = request('tahun', date('Y'));
    
    // Get number of days in current month
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $currentMonth, $currentYear);
    
    $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $columns = [
        ['label' => 'NO', 'field' => 'no', 'width' => '50px'],
        ['label' => 'INDIKATOR', 'field' => 'indikator', 'width' => '300px'],
        ['label' => 'TARGET', 'field' => 'target', 'width' => '80px'],
        ['label' => 'N/D', 'field' => 'nd', 'width' => '80px'],
    ];

    // Add date columns
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $columns[] = ['label' => $i, 'field' => 'day_' . $i, 'width' => '40px'];
    }
    
    $columns[] = ['label' => 'TOTAL', 'field' => 'total', 'width' => '80px'];
@endphp

<div class="dashboard-section">
    <div class="section-header">
        <div class="header-title">
            <i class="ri-file-list-3-line"></i>
            Sensus Data Harian
        </div>
        <div class="header-actions">
            <div class="action-buttons">
                <button class="btn btn-outline">
                    <i class="ri-filter-3-line"></i>
                    Filter
                </button>
                <x-action-dropdown>
                    <a href="{{ route('laporan-analisis.create') }}" class="action-dropdown-item">
                        <i class="ri-add-line"></i>
                        Tambah Data
                    </a>
                    <a href="#" class="action-dropdown-item">
                        <i class="ri-file-excel-2-line"></i>
                        Export Excel
                    </a>
                    <a href="#" class="action-dropdown-item">
                        <i class="ri-file-pdf-line"></i>
                        Export PDF
                    </a>
                    <div class="action-dropdown-divider"></div>
                    <a href="#" class="action-dropdown-item">
                        <i class="ri-printer-line"></i>
                        Print
                    </a>
                </x-action-dropdown>
            </div>
        </div>
    </div>
    
    <div class="section-body">
        <div style="margin-bottom: 1rem;">
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                <div class="search-wrapper">
                    <i class="ri-search-line"></i>
                    <input type="text" class="search-input" placeholder="Cari indikator..." name="search" form="filterForm">
                </div>
            </div>
        </div>
        <x-table-paginate 
            :columns="$columns" 
            :data="$dailyData ?? []" 
            :pagination="$dailyData->links() ?? null" 
            :bulan="$currentMonth"
            :tahun="$currentYear"
        />
    </div>
</div>

<form id="filterForm" method="GET" style="display: none;"></form>
@endsection

@section('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection 