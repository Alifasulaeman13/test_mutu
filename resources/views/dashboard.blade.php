@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('styles')
.dashboard-section {
    background: white;
    border-radius: 4px;
    margin-bottom: 1rem;
    box-shadow: none;
}

.section-header {
    background: #e2e8f0;
    padding: 0.5rem 1rem;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border-bottom: none;
}

.section-title {
    font-size: 0.9375rem;
    font-weight: 500;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.section-title .actions {
    display: flex;
    gap: 1rem;
}

.section-title .action-btn {
    color: #64748b;
    cursor: pointer;
    font-size: 1rem;
}

.section-title .action-btn:hover {
    color: var(--primary-color);
}

.section-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    padding: 0;
}

.grid-item {
    text-align: center;
    text-decoration: none;
    color: inherit;
    padding: 1rem 0.25rem;
    transition: all 0.2s;
    border-radius: 0;
    position: relative;
    border-right: 1px solid #e2e8f0;
    border-bottom: 1px solid #e2e8f0;
}

.grid-item:nth-child(4n) {
    border-right: none;
}

.grid-item:hover {
    background: #f8fafc;
}

.item-icon {
    font-size: 1.75rem;
    color: var(--primary-color);
    margin-bottom: 0.375rem;
    opacity: 0.9;
}

.item-title {
    font-size: 0.8125rem;
    color: #475569;
}

.badge {
    background: #ef4444;
    color: white;
    font-size: 0.6875rem;
    padding: 0.125rem 0.375rem;
    border-radius: 9999px;
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    min-width: 1.25rem;
    height: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

@media (max-width: 1280px) {
    .section-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    .grid-item:nth-child(4n) {
        border-right: 1px solid #e2e8f0;
    }
    .grid-item:nth-child(3n) {
        border-right: none;
    }
}

@media (max-width: 1024px) {
    .section-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .grid-item:nth-child(3n) {
        border-right: 1px solid #e2e8f0;
    }
    .grid-item:nth-child(2n) {
        border-right: none;
    }
}

@media (max-width: 640px) {
    .section-grid {
        grid-template-columns: 1fr;
    }
    .grid-item {
        border-right: none !important;
    }
}
@endsection

@section('content')
<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">
            Dokumen Sistem Mutu / Akreditasi
            <div class="actions">
                <i class="ri-subtract-line action-btn"></i>
                <i class="ri-refresh-line action-btn"></i>
            </div>
        </h2>
    </div>
    <div class="section-grid">
        <a href="#" class="grid-item">
            <i class="ri-download-cloud-line item-icon"></i>
            <div class="item-title">Regulasi</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-download-cloud-line item-icon"></i>
            <div class="item-title">Dokumen</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-download-cloud-line item-icon"></i>
            <div class="item-title">Observasi</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-download-cloud-line item-icon"></i>
            <div class="item-title">Simulasi</div>
        </a>
    </div>
</div>

<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">
            Arsip dan Disposisi
            <div class="actions">
                <i class="ri-subtract-line action-btn"></i>
                <i class="ri-refresh-line action-btn"></i>
            </div>
        </h2>
    </div>
    <div class="section-grid">
        <a href="#" class="grid-item">
            <i class="ri-file-list-line item-icon"></i>
            <div class="item-title">Daftar Regulasi</div>
            <span class="badge">6</span>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-file-paper-line item-icon"></i>
            <div class="item-title">Dokumen Kontrak</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-mail-line item-icon"></i>
            <div class="item-title">Disposisi Masuk</div>
            <span class="badge">9</span>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-file-text-line item-icon"></i>
            <div class="item-title">Dokumen Rapat</div>
        </a>
    </div>
</div>

<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">
            Indikator Mutu
            <div class="actions">
                <i class="ri-subtract-line action-btn"></i>
                <i class="ri-refresh-line action-btn"></i>
            </div>
        </h2>
    </div>
    <div class="section-grid">
        <a href="#" class="grid-item">
            <i class="ri-bar-chart-box-line item-icon"></i>
            <div class="item-title">INM</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-hospital-line item-icon"></i>
            <div class="item-title">IMP-RS</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-building-2-line item-icon"></i>
            <div class="item-title">IMP-Unit</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-line-chart-line item-icon"></i>
            <div class="item-title">IM Dewas</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-building-line item-icon"></i>
            <div class="item-title">IM Unit</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-team-line item-icon"></i>
            <div class="item-title">Supervisi</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-checkbox-circle-line item-icon"></i>
            <div class="item-title">Validasi</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-bar-chart-grouped-line item-icon"></i>
            <div class="item-title">Benchmark</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-line-chart-line item-icon"></i>
            <div class="item-title">Analisis</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-error-warning-line item-icon"></i>
            <div class="item-title">Masalah PDSA</div>
            <span class="badge">2</span>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-refresh-line item-icon"></i>
            <div class="item-title">Siklus PDSA</div>
        </a>
    </div>
</div>

<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">
            Insiden Keselamatan Pasien
            <div class="actions">
                <i class="ri-subtract-line action-btn"></i>
                <i class="ri-refresh-line action-btn"></i>
            </div>
        </h2>
    </div>
    <div class="section-grid">
        <a href="#" class="grid-item">
            <i class="ri-file-list-3-line item-icon"></i>
            <div class="item-title">Lap IKP</div>
            <span class="badge">4</span>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-search-line item-icon"></i>
            <div class="item-title">Investigasi</div>
            <span class="badge">1</span>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-file-chart-line item-icon"></i>
            <div class="item-title">RCA</div>
            <span class="badge">2</span>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-eye-line item-icon"></i>
            <div class="item-title">Monitoring</div>
        </a>
    </div>
</div>

<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">
            Kecelakaan Kerja
            <div class="actions">
                <i class="ri-subtract-line action-btn"></i>
                <i class="ri-refresh-line action-btn"></i>
            </div>
        </h2>
    </div>
    <div class="section-grid">
        <a href="#" class="grid-item">
            <i class="ri-file-list-3-line item-icon"></i>
            <div class="item-title">Lap KK</div>
            <span class="badge">4</span>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-git-merge-line item-icon"></i>
            <div class="item-title">Tindaklanjut</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-eye-line item-icon"></i>
            <div class="item-title">Monitoring</div>
        </a>
    </div>
</div>

<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">
            Manajemen Risiko
            <div class="actions">
                <i class="ri-subtract-line action-btn"></i>
                <i class="ri-refresh-line action-btn"></i>
            </div>
        </h2>
    </div>
    <div class="section-grid">
        <a href="#" class="grid-item">
            <i class="ri-link item-icon"></i>
            <div class="item-title">Konteks</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-list-check item-icon"></i>
            <div class="item-title">Register</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-list-settings-line item-icon"></i>
            <div class="item-title">Asesmen</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-list-check-2 item-icon"></i>
            <div class="item-title">Perlakuan</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-list-ordered item-icon"></i>
            <div class="item-title">Mitigasi</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-eye-line item-icon"></i>
            <div class="item-title">Monitoring</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-list-check-3 item-icon"></i>
            <div class="item-title">Reviu</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-chat-1-line item-icon"></i>
            <div class="item-title">Komunikasi</div>
        </a>
    </div>
</div>

<div class="dashboard-section">
    <div class="section-header">
        <h2 class="section-title">
            Pengaturan Sistem
            <div class="actions">
                <i class="ri-subtract-line action-btn"></i>
                <i class="ri-refresh-line action-btn"></i>
            </div>
        </h2>
    </div>
    <div class="section-grid">
        <a href="#" class="grid-item">
            <i class="ri-database-2-line item-icon"></i>
            <div class="item-title">Database</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-government-line item-icon"></i>
            <div class="item-title">Institusi</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-building-line item-icon"></i>
            <div class="item-title">Unit</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-user-settings-line item-icon"></i>
            <div class="item-title">User</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-hospital-line item-icon"></i>
            <div class="item-title">Hospital</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-git-branch-line item-icon"></i>
            <div class="item-title">Bridging</div>
        </a>
        <a href="#" class="grid-item">
            <i class="ri-palette-line item-icon"></i>
            <div class="item-title">Warna</div>
        </a>
    </div>
</div>
@endsection 