@extends('layouts.app')

@section('title', 'Formula Indikator')
@section('page-title', 'Formula Indikator')

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

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

.btn-warning {
    background: #f59e0b;
    color: white;
    border: none;
}

.btn-warning:hover {
    background: #d97706;
}

.btn-danger {
    background: #ef4444;
    color: white;
    border: none;
}

.btn-danger:hover {
    background: #dc2626;
}

.badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-success {
    background: #10b981;
    color: white;
}

.badge-danger {
    background: #ef4444;
    color: white;
}

.alert {
    padding: 1rem;
    border-radius: 0.375rem;
    margin-bottom: 1rem;
}

.alert-success {
    background: #f0fdf4;
    border: 1px solid #86efac;
    color: #166534;
}

.alert-danger {
    background: #fef2f2;
    border: 1px solid #fca5a5;
    color: #991b1b;
}

.mb-4 {
    margin-bottom: 1rem;
}

.d-inline {
    display: inline;
}

.table-container {
    overflow-x: auto;
    border-radius: 8px;
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

.text-right {
    text-align: right;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
}

.status-badge.active {
    background-color: #dcfce7;
    color: #15803d;
}

.status-badge.inactive {
    background-color: #fee2e2;
    color: #dc2626;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

.status-badge.active .status-dot {
    background-color: #15803d;
}

.status-badge.inactive .status-dot {
    background-color: #dc2626;
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #64748b;
}

.empty-state i {
    font-size: 3rem;
    color: #e2e8f0;
    margin-bottom: 1rem;
}

.empty-state-text {
    font-size: 0.875rem;
    margin-bottom: 1rem;
}

.table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem;
    background: #f8fafc;
    border-bottom-left-radius: 4px;
    border-bottom-right-radius: 4px;
    border-top: 1px solid #e2e8f0;
}

.items-per-page {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.items-per-page select {
    padding: 0.25rem 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    font-size: 0.875rem;
}

.pagination-info {
    font-size: 0.875rem;
    color: #64748b;
}

.pagination-links {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.pagination-links nav {
    display: flex;
    align-items: center;
}

.pagination-links .pagination {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0.25rem;
}

.pagination-links .page-item {
    display: inline-flex;
}

.pagination-links .page-link {
    padding: 0.5rem 0.75rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    color: #64748b;
    text-decoration: none;
    transition: all 0.2s;
    min-width: 2.5rem;
    text-align: center;
    font-size: 0.875rem;
}

.pagination-links .page-item.active .page-link {
    background-color: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.pagination-links .page-link:hover:not(.active) {
    background-color: #f1f5f9;
    border-color: #e2e8f0;
}

.pagination-links .page-item.disabled .page-link {
    opacity: 0.5;
    pointer-events: none;
}

@media (max-width: 768px) {
    .table-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .pagination-links {
        width: 100%;
        justify-content: center;
    }
}
@endsection

@section('content')
<x-sweet-alert />

<div class="dashboard-section">
    <div class="section-header">
        <div class="header-title">
            <i class="ri-functions"></i>
            Formula Indikator
        </div>
        <div class="header-actions">
            <div class="search-wrapper">
                <i class="ri-search-line"></i>
                <input type="text" class="search-input" placeholder="Cari formula..." name="search" form="filterForm">
            </div>
            <div class="action-buttons">
                <a href="{{ route('master-indikator.formula.create') }}" class="btn btn-primary">
                    <i class="ri-add-line"></i>
                    Tambah Formula
                </a>
                <x-action-dropdown>
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
                        <th class="column-header">NAMA FORMULA</th>
                        <th class="column-header">NUMERATOR</th>
                        <th class="column-header">DENOMINATOR</th>
                        <th class="column-header">TIPE</th>
                        <th class="column-header">STATUS</th>
                        <th class="column-header text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($formulas as $index => $formula)
                        <tr class="table-row">
                            <td class="column-cell">{{ $formulas->firstItem() + $index }}</td>
                            <td class="column-cell">{{ $formula->indicator->name }}</td>
                            <td class="column-cell">{{ $formula->name }}</td>
                            <td class="column-cell">
                                <div class="formula-info">
                                    <span class="formula-label">{{ $formula->numerator_label }}</span>
                                    <span class="formula-type badge {{ $formula->numerator_type == 'boolean' ? 'badge-warning' : 'badge-info' }}">
                                        {{ ucfirst($formula->numerator_type) }}
                                    </span>
                                </div>
                            </td>
                            <td class="column-cell">
                                <div class="formula-info">
                                    <span class="formula-label">{{ $formula->denominator_label }}</span>
                                    <span class="formula-type badge {{ $formula->denominator_type == 'boolean' ? 'badge-warning' : 'badge-info' }}">
                                        {{ ucfirst($formula->denominator_type) }}
                                    </span>
                                </div>
                            </td>
                            <td class="column-cell">
                                <span class="badge {{ $formula->calculation_type == 'percentage' ? 'badge-primary' : 'badge-secondary' }}">
                                    {{ ucfirst($formula->calculation_type) }}
                                    @if($formula->calculation_type == 'percentage')
                                        (× {{ $formula->multiplier }})
                                    @endif
                                </span>
                            </td>
                            <td class="column-cell">
                                <span class="status-badge {{ $formula->is_active ? 'active' : 'inactive' }}">
                                    <span class="status-dot"></span>
                                    {{ $formula->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td class="column-cell text-right">
                                <x-action-buttons 
                                    :editUrl="route('master-indikator.formula.edit', $formula->id)"
                                    :deleteUrl="route('master-indikator.formula.destroy', $formula->id)"
                                />
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="ri-inbox-line"></i>
                                    <p class="empty-state-text">Belum ada data formula yang tersedia</p>
                                    <a href="{{ route('master-indikator.formula.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line"></i>
                                        Tambah Formula Baru
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($formulas->count() > 0)
                <div class="table-footer">
                    <div class="items-per-page">
                        <span>Tampilkan:</span>
                        <select id="itemsPerPage" name="per_page" form="filterForm" onchange="document.getElementById('filterForm').submit()">
                            <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                        </select>
                    </div>
                    <div class="pagination-info">
                        Menampilkan {{ $formulas->firstItem() ?? 0 }} - {{ $formulas->lastItem() ?? 0 }} dari {{ $formulas->total() }} data
                    </div>
                    <div class="pagination-links">
                        {{ $formulas->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<form id="filterForm" method="GET" style="display: none;"></form>
@endsection 