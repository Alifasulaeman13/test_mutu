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

.table-container {
    width: 100%;
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.column-header {
    background-color: #f8fafc;
    padding: 1rem;
    font-weight: 600;
    color: #475569;
    text-align: left;
    border-bottom: 2px solid #e2e8f0;
}

.column-cell {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    background-color: white;
}

.table-row:hover .column-cell {
    background-color: #f8fafc;
}

.achievement-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.achievement-badge.success {
    background-color: #dcfce7;
    color: #15803d;
}

.achievement-badge.warning {
    background-color: #fef3c7;
    color: #d97706;
}

.achievement-badge.danger {
    background-color: #fee2e2;
    color: #dc2626;
}
@endsection

@section('content')
@php
    $currentMonth = request('bulan', date('n'));
    $currentYear = request('tahun', date('Y'));
    
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

    // Cek apakah user adalah Administrator
    $isAdmin = auth()->user()->unit && auth()->user()->unit->code === 'ADM001';
@endphp

<div class="dashboard-section">
    <div class="section-header">
        <div class="header-title">
            <i class="ri-file-list-3-line"></i>
            Laporan Indikator Mutu
            @if($isAdmin)
                <span class="badge badge-primary ml-2">Administrator View</span>
            @endif
        </div>
        <div class="header-actions">
            <div class="month-selector">
                <select name="bulan" form="filterForm" onchange="this.form.submit()">
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $currentMonth == $num ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                <select name="tahun" form="filterForm" onchange="this.form.submit()">
                    @for($year = date('Y'); $year >= date('Y')-2; $year--)
                        <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endfor
                </select>
            </div>
            <div class="action-buttons">
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
        <div class="table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th class="column-header">NO</th>
                        <th class="column-header">INDIKATOR</th>
                        <th class="column-header">UNIT</th>
                        <th class="column-header">TARGET</th>
                        <th class="column-header">NUMERATOR</th>
                        <th class="column-header">DENOMINATOR</th>
                        <th class="column-header">PENCAPAIAN</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyData as $index => $data)
                        <tr class="table-row">
                            <td class="column-cell">{{ $index + 1 }}</td>
                            <td class="column-cell">{{ $data['indikator'] }}</td>
                            <td class="column-cell">{{ $data['unit'] }}</td>
                            <td class="column-cell">{{ $data['target'] }}</td>
                            <td class="column-cell">{{ $data['numerator'] }}</td>
                            <td class="column-cell">{{ $data['denominator'] }}</td>
                            <td class="column-cell">
                                @php
                                    $achievement = $data['total'];
                                    $badgeClass = $achievement >= 80 ? 'success' : ($achievement >= 60 ? 'warning' : 'danger');
                                @endphp
                                <span class="achievement-badge {{ $badgeClass }}">
                                    {{ number_format($achievement, 2) }}%
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="column-cell text-center">
                                Tidak ada data untuk periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<form id="filterForm" method="GET" style="display: none;"></form>
@endsection

@section('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection 