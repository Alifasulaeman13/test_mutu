@extends('layouts.app')

@section('title', 'Master Indikator')
@section('page-title', 'Master Indikator')

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

.badge {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-primary {
    background: var(--primary-color);
    color: white;
}

.badge-secondary {
    background: #64748b;
    color: white;
}

.badge-success {
    background: #10b981;
    color: white;
}

.badge-danger {
    background: #ef4444;
    color: white;
}

.badge-warning {
    background: #f59e0b;
    color: white;
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
@endsection

@section('content')
<x-sweet-alert />

<div class="dashboard-section">
    <div class="section-header">
        <div class="header-title">
            <i class="ri-list-check-2"></i>
            Master Indikator
        </div>
        <div class="header-actions">
            <div class="search-wrapper">
                <i class="ri-search-line"></i>
                <input type="text" class="search-input" placeholder="Cari indikator..." name="search" form="filterForm">
            </div>
            <div class="action-buttons">
                <a href="{{ route('master-indikator.create') }}" class="btn btn-primary">
                    <i class="ri-add-line"></i>
                    Tambah Indikator
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
        <x-table-paginate 
            :columns="[
                ['label' => 'NO', 'field' => 'no'],
                ['label' => 'NAMA', 'field' => 'nama'],
                ['label' => 'UNIT', 'field' => 'unit'],
                ['label' => 'TARGET', 'field' => 'target'],
                ['label' => 'TIPE', 'field' => 'tipe'],
                ['label' => 'PERIODE', 'field' => 'periode'],
                ['label' => 'STATUS', 'field' => 'status'],
                ['label' => 'AKSI', 'field' => 'aksi'],
            ]"
            :data="$data"
            :pagination="$indicators"
            :filter="true"
            title="Daftar Indikator"
        />
    </div>
</div>

<form id="filterForm" method="GET" style="display: none;"></form>
@endsection 