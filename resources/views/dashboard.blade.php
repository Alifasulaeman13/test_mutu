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

/* Stats Cards */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.stat-title {
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.stat-value {
    color: #1e293b;
    font-size: 1.5rem;
    font-weight: 600;
}

/* Chart Section */
.chart-container {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    margin: 2rem 0;
}

.chart-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.chart-title {
    color: #1e293b;
    font-size: 1.125rem;
    font-weight: 500;
    margin: 0;
}

.chart-legend {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #64748b;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 3px;
}

.chart-wrapper {
    position: relative;
    height: 300px;
    width: 100%;
    margin-top: 1rem;
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    color: #64748b;
    height: 100%;
    background: #f8fafc;
    border-radius: 8px;
}

.empty-state-icon {
    font-size: 2.5rem;
    color: #94a3b8;
    margin-bottom: 1rem;
}

.empty-state-text {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    color: #475569;
}

.empty-state-subtext {
    font-size: 0.8125rem;
    color: #64748b;
}

/* Chart Filters */
.chart-filters {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 1rem;
    gap: 1rem;
}

.filter-group {
    display: flex;
    gap: 0.5rem;
}

.filter-select {
    padding: 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    color: #475569;
    background-color: white;
    cursor: pointer;
    transition: all 0.2s;
}

.filter-select:hover {
    border-color: #cbd5e1;
}

.filter-select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 1px #2563eb;
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
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
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
    .stats-grid {
        grid-template-columns: 1fr;
    }
}
@endsection

@section('content')
<!-- Error Display -->
@if(isset($error))
    <div class="alert alert-danger">
        {{ $error }}
    </div>
@endif

<div class="container">
    <!-- Statistics Section -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-title">Total Indikator</div>
            <div class="stat-value">{{ $stats['total_indicators'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Indikator Aktif</div>
            <div class="stat-value">{{ $stats['active_indicators'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Pencapaian ≥ 80%</div>
            <div class="stat-value">{{ $stats['above_target'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-title">Pencapaian < 80%</div>
            <div class="stat-value">{{ $stats['below_target'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Menu Sections -->
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

    <!-- Chart Section -->
    <div class="chart-container">
        <div class="chart-header">
            <h3 class="chart-title">Rata-rata Pencapaian Indikator</h3>
            <div class="chart-filters">
                <div class="filter-group">
                    <select id="yearFilter" class="filter-select">
                        @for($y = date('Y'); $y >= date('Y')-5; $y--)
                            <option value="{{ $y }}" {{ request('year', date('Y')) == $y ? 'selected' : '' }}>
                                Tahun {{ $y }}
                            </option>
                        @endfor
                    </select>
                    <select id="periodFilter" class="filter-select">
                        <option value="6" {{ request('period', '6') == '6' ? 'selected' : '' }}>6 Bulan Terakhir</option>
                        <option value="12" {{ request('period') == '12' ? 'selected' : '' }}>1 Tahun</option>
                    </select>
                </div>
                <div class="chart-legend">
                    <div class="legend-item">
                        <div class="legend-color" style="background: #2563eb"></div>
                        <span>Pencapaian</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="chart-wrapper">
            <canvas id="achievementChart"></canvas>
        </div>
    </div>
</div>

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let chart = null;
    const initialData = {
        labels: @json($labels),
        data: @json($data),
        details: @json($details ?? [])
    };
    
    function createChart(chartData) {
        console.log('Creating/updating chart with data:', chartData);
        const ctx = document.getElementById('achievementChart').getContext('2d');
        
        if (chart) {
            chart.destroy();
        }
        
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Rata-rata Pencapaian (%)',
                    data: chartData.data,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#2563eb',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            title: function(tooltipItems) {
                                return tooltipItems[0].label;
                            },
                            label: function(context) {
                                const dataIndex = context.dataIndex;
                                const value = context.parsed.y;
                                const details = chartData.details[dataIndex];
                                let lines = [`Rata-rata: ${value.toFixed(2)}%`];
                                
                                if (details && details.length > 0) {
                                    lines.push('');
                                    lines.push('Detail Indikator:');
                                    details.forEach(detail => {
                                        const status = detail.value >= 80 ? '✅' : '❌';
                                        lines.push(`${status} ${detail.name}: ${detail.value.toFixed(2)}%`);
                                    });
                                }
                                
                                return lines;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 500,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        },
                        grid: {
                            color: 'rgba(226, 232, 240, 0.5)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    function updateChart(year, period) {
        console.log('Updating chart with filters:', { year, period });
        
        // Show loading state
        const wrapper = document.querySelector('.chart-wrapper');
        wrapper.style.opacity = '0.5';
        
        // Build URL with base path
        const basePath = '{{ url('/') }}';
        const url = `${basePath}/chart-data?year=${year}&period=${period}`;
        console.log('Fetching data from:', url);
        
        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(chartData => {
            console.log('Received chart data:', chartData);
            createChart(chartData);
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
            alert('Gagal mengambil data grafik. Silakan coba lagi.');
        })
        .finally(() => {
            wrapper.style.opacity = '1';
        });
    }

    // Event listeners for filters
    const yearFilter = document.getElementById('yearFilter');
    const periodFilter = document.getElementById('periodFilter');

    yearFilter.addEventListener('change', function() {
        console.log('Year filter changed:', this.value);
        updateChart(this.value, periodFilter.value);
    });

    periodFilter.addEventListener('change', function() {
        console.log('Period filter changed:', this.value);
        updateChart(yearFilter.value, this.value);
    });

    // Initial chart load with data from server
    console.log('Initial chart data:', initialData);
    createChart(initialData);
});
</script>
@endpush 