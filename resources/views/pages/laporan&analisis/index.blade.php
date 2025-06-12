@extends('layouts.app')

@section('title', 'Laporan & Analisis')
@section('page-title', 'Laporan & Analisis')

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

.filter-section {
    background: #f8fafc;
    padding: 1rem;
    border-radius: 0.5rem;
}

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table-default {
    width: 100%;
    border-collapse: collapse;
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    text-transform: uppercase;
}

.badge-success {
    background: #dcfce7;
    color: #166534;
}

.badge-warning {
    background: #fef9c3;
    color: #854d0e;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.btn-warning {
    background: #fef9c3;
    color: #854d0e;
    border: 1px solid #fde047;
}

.btn-warning:hover {
    background: #fef08a;
}

.btn-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

.btn-danger:hover {
    background: #fecaca;
}

.flex {
    display: flex;
}

.gap-2 {
    gap: 0.5rem;
}

.gap-4 {
    gap: 1rem;
}

.items-end {
    align-items: flex-end;
}

.mb-4 {
    margin-bottom: 1rem;
}

.mb-0 {
    margin-bottom: 0;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #1e293b;
}

.form-select {
    padding: 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    min-width: 150px;
}

.text-center {
    text-align: center;
}

.py-4 {
    padding-top: 1rem;
    padding-bottom: 1rem;
}

.table-row-empty {
    background-color: #f8fafc;
}

.text-muted {
    color: #94a3b8;
}

.badge-secondary {
    background: #e2e8f0;
    color: #475569;
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
            <i class="ri-file-chart-line"></i>
            Data Indikator
        </div>
        <div>
            <a href="{{ route('laporan-analisis.create') }}" class="btn btn-primary">
                <i class="ri-add-line"></i>
                Tambah Data
            </a>
        </div>
    </div>
    
    <div class="section-body">
        <div class="filter-section mb-4">
            <form action="{{ route('laporan-analisis.index') }}" method="GET" class="flex gap-4">
                <div class="form-group mb-0">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select name="bulan" id="bulan" class="form-select" onchange="this.form.submit()">
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $currentMonth == $month ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-0">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select name="tahun" id="tahun" class="form-select" onchange="this.form.submit()">
                        @foreach(range(date('Y')-5, date('Y')+5) as $year)
                            <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-0 flex items-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-filter-line"></i>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table-default">
                <thead>
                    <tr>
                        <th class="column-header">NO</th>
                        <th class="column-header">INDIKATOR</th>
                        <th class="column-header">UNIT</th>
                        <th class="column-header">TARGET</th>
                        <th class="column-header">NUMERATOR</th>
                        <th class="column-header">DENOMINATOR</th>
                        <th class="column-header">PENCAPAIAN</th>
                        <th class="column-header">PERIODE</th>
                        <th class="column-header">STATUS</th>
                        <th class="column-header">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($displayData as $index => $data)
                        <tr class="table-row {{ !$data['has_data'] ? 'table-row-empty' : '' }}">
                            <td class="column-cell">{{ $index + 1 }}</td>
                            <td class="column-cell">{{ $data['indikator'] }}</td>
                            <td class="column-cell">{{ $data['unit'] }}</td>
                            <td class="column-cell">{{ $data['target'] }}</td>
                            <td class="column-cell">
                                @if($data['has_data'])
                                    {{ $data['numerator'] }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="column-cell">
                                @if($data['has_data'])
                                    {{ $data['denominator'] }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="column-cell">
                                @if($data['has_data'])
                                    @php
                                        $achievement = $data['total'];
                                        $badgeClass = $achievement >= 80 ? 'success' : ($achievement >= 60 ? 'warning' : 'danger');
                                    @endphp
                                    <span class="badge badge-{{ $badgeClass }}">
                                        {{ number_format($achievement, 2) }}%
                                    </span>
                                @else
                                    <span class="badge badge-secondary">
                                        Belum Ada Data
                                    </span>
                                @endif
                            </td>
                            <td class="column-cell">
                                {{ $data['periode']['bulan'] }} {{ $data['periode']['tahun'] }}
                            </td>
                            <td class="column-cell">
                                <span class="badge badge-{{ $data['status_periode'] === 'Aktif' ? 'success' : 'warning' }}">
                                    {{ $data['status_periode'] }}
                                </span>
                            </td>
                            <td class="column-cell">
                                <div class="flex gap-2">
                                    @if($data['has_data'])
                                        <a href="{{ route('laporan-analisis.edit', ['monthlyData' => $data['data_id']]) }}" 
                                           class="btn btn-warning btn-sm">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <form action="{{ route('laporan-analisis.destroy', ['monthlyData' => $data['data_id']]) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('laporan-analisis.create') }}?indicator_id={{ $data['id'] }}" 
                                           class="btn btn-primary btn-sm">
                                            <i class="ri-add-line"></i>
                                            Input Data
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4">
                                Tidak ada indikator yang tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endsection 