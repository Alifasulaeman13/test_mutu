@extends('layouts.app')

@section('title', 'Laporan & Analisis')
@section('page-title', 'Laporan & Analisis')

@push('scripts')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
// Definisikan fungsi-fungsi sebagai variabel global
window.modalHandler = {
    bukaModal: function(indicatorId) {
        // Set ID indikator
        document.getElementById('modalIndicatorId').value = indicatorId;
        
        // Ambil nilai bulan dan tahun dari filter
        const filterBulan = document.getElementById('bulan').value;
        const filterTahun = document.getElementById('tahun').value;
        
        // Set nilai bulan dan tahun di modal sesuai filter
        const monthSelect = document.getElementById('month');
        const yearSelect = document.getElementById('year');
        
        monthSelect.value = filterBulan;
        yearSelect.value = filterTahun;
        
        // Tampilkan modal
        document.getElementById('inputModal').style.display = 'block';
        
        // Atur style untuk field yang readonly
        [monthSelect, yearSelect].forEach(function(select) {
            select.style.backgroundColor = '#f1f5f9';
            select.style.cursor = 'not-allowed';
            
            // Cegah perubahan
            select.addEventListener('mousedown', function(e) {
                e.preventDefault();
            });
        });
    },

    tutupModal: function() {
        document.getElementById('inputModal').style.display = 'none';
        document.getElementById('inputForm').reset();
        
        // Reset kembali nilai bulan dan tahun sesuai filter
        const filterBulan = document.getElementById('bulan').value;
        const filterTahun = document.getElementById('tahun').value;
        const monthSelect = document.getElementById('month');
        const yearSelect = document.getElementById('year');
        
        monthSelect.value = filterBulan;
        yearSelect.value = filterTahun;
    }
};

// Ketika dokumen sudah siap
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('inputModal');
    const form = document.getElementById('inputForm');

    // Tutup modal ketika klik di luar modal
    window.onclick = function(event) {
        if (event.target == modal) {
            window.modalHandler.tutupModal();
        }
    };

    // Handle submit form
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Buat objek FormData dari form
        const formData = new FormData(this);
        
        // Tambahkan header X-Requested-With untuk menandai ini sebagai request AJAX
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        })
        .then(async response => {
            // Baca response sebagai text dan parse sebagai JSON
            const responseText = await response.text();
            let data;
            
            try {
                data = JSON.parse(responseText);
            } catch (e) {
                throw new Error('Terjadi kesalahan saat memproses response dari server');
            }
            
            // Jika ada pesan dari server, gunakan itu
            if (data.message) {
                if (!response.ok) {
                    throw new Error(data.message);
                }
            } else if (!response.ok) {
                // Jika tidak ada pesan spesifik
                if (response.status === 403) {
                    throw new Error('Anda tidak memiliki akses untuk melakukan tindakan ini');
                } else if (response.status === 422 && data.errors) {
                    throw new Error(Object.values(data.errors).flat().join('\n'));
                } else {
                    throw new Error('Terjadi kesalahan pada server');
                }
            }
            
            return data;
        })
        .then(data => {
            if (data.success) {
                // Tutup modal
                window.modalHandler.tutupModal();
                
                // Tampilkan SweetAlert untuk sukses
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message || 'Data berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Reload halaman setelah alert tertutup
                    window.location.reload();
                });
            } else {
                throw new Error(data.message || 'Terjadi kesalahan yang tidak diketahui');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // Tampilkan SweetAlert untuk error
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: error.message || 'Terjadi kesalahan. Silakan coba lagi.'
            });
            
            // Jika error berkaitan dengan akses, tutup modal
            if (error.message.toLowerCase().includes('akses')) {
                window.modalHandler.tutupModal();
            }
        });
    });
});
</script>
@endpush

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

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

.modal-content {
    position: relative;
    background-color: white;
    margin: 2rem auto;
    padding: 1rem;
    width: 90%;
    max-width: 600px;
    border-radius: 8px;
    max-height: 90vh;
    overflow-y: auto;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    cursor: pointer;
    font-size: 1.5rem;
    color: #64748b;
}

.modal-header {
    padding-bottom: 1rem;
    margin-bottom: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary-color);
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px var(--primary-color);
}

.invalid-feedback {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
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
                        <th class="column-header">PERIODE</th>
                        <th class="column-header">UNIT</th>
                        <th class="column-header">TARGET</th>
                        <th class="column-header">NILAI</th>
                        <th class="column-header">PENCAPAIAN</th>
                        <th class="column-header">STATUS</th>
                        <th class="column-header">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($displayData as $index => $data)
                        <tr class="table-row {{ !$data['has_data'] ? 'table-row-empty' : '' }}">
                            <td class="column-cell">{{ $index + 1 }}</td>
                            <td class="column-cell">{{ $data['indikator'] }}</td>
                            <td class="column-cell">
                                {{ $data['periode']['bulan'] }} {{ $data['periode']['tahun'] }}
                            </td>
                            <td class="column-cell">{{ $data['unit'] }}</td>
                            <td class="column-cell">{{ $data['target'] }}</td>
                            <td class="column-cell">
                                @if($data['has_data'])
                                    {{ $data['numerator'] }}/{{ $data['denominator'] }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="column-cell">
                                @if($data['has_data'])
                                    @php
                                        $achievement = min($data['total'], 100);
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
                                        <button type="button" 
                                           class="btn btn-primary btn-sm"
                                           onclick="window.modalHandler.bukaModal({{ $data['id'] }})">
                                            <i class="ri-add-line"></i>
                                            Input Data
                                        </button>
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

<!-- Modal Input Data -->
<div id="inputModal" class="modal">
    <div class="modal-content">
        <span class="modal-close" onclick="window.modalHandler.tutupModal()">&times;</span>
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="ri-add-line"></i>
                Tambah Data Indikator
            </h3>
        </div>
        <div class="modal-body">
            <form id="inputForm" action="{{ route('laporan-analisis.store') }}" method="POST">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <input type="hidden" name="indicator_id" id="modalIndicatorId">
                
                <div class="form-group">
                    <label for="month" class="form-label">Bulan</label>
                    <select name="month" id="month" class="form-select" required readonly>
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}" {{ $currentMonth == $month ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="year" class="form-label">Tahun</label>
                    <select name="year" id="year" class="form-select" required readonly>
                        @foreach(range(date('Y')-5, date('Y')+5) as $year)
                            <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="numerator" class="form-label">Numerator</label>
                    <input type="number" name="numerator" id="numerator" class="form-input"
                        min="0" required>
                </div>

                <div class="form-group">
                    <label for="denominator" class="form-label">Denominator</label>
                    <input type="number" name="denominator" id="denominator" class="form-input"
                        min="1" required>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" class="btn btn-outline" onclick="window.modalHandler.tutupModal()">
                        <i class="ri-close-line"></i>
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="ri-save-line"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection 