@extends('layouts.app')

@section('title', 'Dashboard')

@section('page-title', 'Selamat Datang di Dashboard')

@section('styles')
.dashboard-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.card-title {
    font-size: 1rem;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.card-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--primary-color);
}

@media (max-width: 768px) {
    .dashboard-cards {
        grid-template-columns: 1fr;
    }
}
@endsection

@section('content')
<div class="dashboard-cards">
    <div class="card">
        <div class="card-title">Total Pasien</div>
        <div class="card-value">1,234</div>
    </div>
    <div class="card">
        <div class="card-title">Dokter Aktif</div>
        <div class="card-value">45</div>
    </div>
    <div class="card">
        <div class="card-title">Kamar Tersedia</div>
        <div class="card-value">28</div>
    </div>
    <div class="card">
        <div class="card-title">Jadwal Hari Ini</div>
        <div class="card-value">56</div>
    </div>
</div>
@endsection 