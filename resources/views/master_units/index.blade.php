@extends('layouts.app')

@section('title', 'Daftar Unit')

@section('page-title', 'Daftar Unit')

@section('styles')
.dashboard-section {
    background: white;
    border-radius: 4px;
    margin-bottom: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
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
    color: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.section-title i {
    font-size: 1.25rem;
    margin-right: 0.5rem;
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

.table-container {
    overflow-x: auto;
    border-radius: 4px;
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

.code-badge {
    background-color: var(--primary-color);
    color: white;
    padding: 0.375rem 0.75rem;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.unit-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.unit-name {
    font-weight: 600;
    color: #1e293b;
}

.description-text {
    color: #64748b;
    font-size: 0.875rem;
    max-width: 300px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.description-text:hover {
    white-space: normal;
    overflow: visible;
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

.action-buttons {
    display: flex;
    gap: 0.5rem;
    justify-content: flex-end;
}

.action-btn {
    padding: 0.5rem;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.action-btn.edit {
    color: var(--primary-color);
    background-color: #f0fdfa;
}

.action-btn.edit:hover {
    background-color: #ccfbf1;
}

.action-btn.delete {
    color: #dc2626;
    background-color: #fee2e2;
}

.action-btn.delete:hover {
    background-color: #fecaca;
}

.btn {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
}

.search-wrapper {
    position: relative;
    margin-right: 1rem;
}

.search-input {
    padding: 0.5rem 0.75rem 0.5rem 2.25rem;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    font-size: 0.875rem;
    width: 200px;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(0, 119, 116, 0.1);
    width: 250px;
}

.search-wrapper i {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 0.875rem;
    pointer-events: none;
}

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
    display: flex;
    gap: 1rem;
}

.alert-danger {
    background-color: #fee2e2;
    border: 1px solid #fecaca;
    color: #dc2626;
}

.alert-success {
    background-color: #dcfce7;
    border: 1px solid #bbf7d0;
    color: #15803d;
}

.alert-icon {
    font-size: 1.25rem;
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

/* Additional Professional Styles */
.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: white;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.page-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.page-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 4px;
    padding: 1rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.stat-title {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
}

.stat-icon {
    float: right;
    font-size: 2rem;
    color: var(--primary-color);
    opacity: 0.2;
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

.loading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(255, 255, 255, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
    display: none;
}

.loading-overlay.active {
    display: flex;
}

.loading-spinner {
    width: 2rem;
    height: 2rem;
    border: 3px solid #e2e8f0;
    border-top-color: var(--primary-color);
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
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
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="ri-building-2-line"></i>
            Manajemen Unit
        </h1>
        <div class="page-actions">
            <div class="search-wrapper">
                <i class="ri-search-line"></i>
                <input type="text" id="searchTable" placeholder="Cari unit..." class="search-input">
            </div>
            <a href="{{ route('master.units.create') }}" class="btn btn-primary">
                <i class="ri-add-line"></i>
                Tambah Unit
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <i class="ri-building-2-line stat-icon"></i>
            <div class="stat-title">Total Unit</div>
            <div class="stat-value">{{ $units->count() }}</div>
        </div>
        <div class="stat-card">
            <i class="ri-check-line stat-icon"></i>
            <div class="stat-title">Unit Aktif</div>
            <div class="stat-value">{{ $units->where('is_active', true)->count() }}</div>
        </div>
        <div class="stat-card">
            <i class="ri-close-line stat-icon"></i>
            <div class="stat-title">Unit Non-aktif</div>
            <div class="stat-value">{{ $units->where('is_active', false)->count() }}</div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            <div class="alert-icon">
                <i class="ri-checkbox-circle-line"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Berhasil!</div>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            <div class="alert-icon">
                <i class="ri-error-warning-line"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Error!</div>
                <div>{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="ri-list-check-2"></i>
                Daftar Unit
            </h2>
        </div>
        <div class="p-4">
            <div class="table-container" style="position: relative;">
                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loadingOverlay">
                    <div class="loading-spinner"></div>
                </div>

                <table class="modern-table">
                    <thead>
                        <tr>
                            <th class="column-header">
                                <div class="th-content">
                                    <span>Kode</span>
                                    <i class="ri-arrow-up-down-line sort-icon"></i>
                                </div>
                            </th>
                            <th class="column-header">
                                <div class="th-content">
                                    <span>Nama Unit</span>
                                    <i class="ri-arrow-up-down-line sort-icon"></i>
                                </div>
                            </th>
                            <th class="column-header">
                                <div class="th-content">
                                    <span>Deskripsi</span>
                                </div>
                            </th>
                            <th class="column-header">Status</th>
                            <th class="column-header text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $unit)
                            <tr class="table-row">
                                <td class="column-cell">
                                    <span class="code-badge">{{ $unit->code }}</span>
                                </td>
                                <td class="column-cell">
                                    <div class="unit-info">
                                        <div class="unit-name">{{ $unit->name }}</div>
                                    </div>
                                </td>
                                <td class="column-cell">
                                    <div class="description-text">{{ $unit->description ?: '-' }}</div>
                                </td>
                                <td class="column-cell">
                                    <span class="status-badge {{ $unit->is_active ? 'active' : 'inactive' }}">
                                        <span class="status-dot"></span>
                                        {{ $unit->is_active ? 'Aktif' : 'Non-aktif' }}
                                    </span>
                                </td>
                                <td class="column-cell text-right">
                                    <div class="action-buttons">
                                        <a href="{{ route('master.units.edit', $unit) }}" class="action-btn edit" title="Edit Unit">
                                            <i class="ri-edit-line"></i>
                                        </a>
                                        <button type="button" class="action-btn delete" 
                                                onclick="confirmDelete('{{ $unit->id }}')" title="Hapus Unit">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                        <form id="delete-form-{{ $unit->id }}" 
                                              action="{{ route('master.units.destroy', $unit) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="empty-state">
                                        <i class="ri-inbox-line"></i>
                                        <p class="empty-state-text">Belum ada data unit yang tersedia</p>
                                        <a href="{{ route('master.units.create') }}" class="btn btn-primary">
                                            <i class="ri-add-line"></i>
                                            Tambah Unit Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Table Footer with Pagination -->
                @if($units->count() > 0)
                    <div class="table-footer">
                        <div class="items-per-page">
                            <span>Tampilkan:</span>
                            <select id="itemsPerPage" onchange="changeItemsPerPage(this.value)">
                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                            </select>
                        </div>
                        <div class="pagination-info">
                            Menampilkan {{ $units->firstItem() ?? 0 }} - {{ $units->lastItem() ?? 0 }} dari {{ $units->total() }} data
                        </div>
                        <div class="pagination-links">
                            {{ $units->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Search functionality
let searchTimeout;
const searchTable = document.getElementById('searchTable');
const loadingOverlay = document.getElementById('loadingOverlay');

searchTable.addEventListener('input', function(e) {
    clearTimeout(searchTimeout);
    const searchTerm = e.target.value.toLowerCase();
    
    // Show loading overlay
    loadingOverlay.classList.add('active');
    
    searchTimeout = setTimeout(() => {
        const rows = document.querySelectorAll('.table-row');
        
        rows.forEach(row => {
            const code = row.querySelector('.code-badge').textContent.toLowerCase();
            const name = row.querySelector('.unit-name').textContent.toLowerCase();
            const description = row.querySelector('.description-text').textContent.toLowerCase();
            
            if (code.includes(searchTerm) || name.includes(searchTerm) || description.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
        
        // Hide loading overlay
        loadingOverlay.classList.remove('active');
    }, 300);
});

// Sort functionality
document.querySelectorAll('.th-content').forEach(header => {
    header.addEventListener('click', function() {
        const column = this.querySelector('span').textContent.toLowerCase();
        const table = this.closest('table');
        const rows = Array.from(table.querySelectorAll('tbody tr'));
        const isAscending = this.classList.contains('asc');
        
        // Show loading overlay
        loadingOverlay.classList.add('active');
        
        setTimeout(() => {
            // Remove sort classes from all headers
            document.querySelectorAll('.th-content').forEach(h => {
                h.classList.remove('asc', 'desc');
            });
            
            // Add sort class to clicked header
            this.classList.add(isAscending ? 'desc' : 'asc');
            
            // Sort rows
            rows.sort((a, b) => {
                let aValue, bValue;
                
                switch(column) {
                    case 'kode':
                        aValue = a.querySelector('.code-badge').textContent;
                        bValue = b.querySelector('.code-badge').textContent;
                        break;
                    case 'nama unit':
                        aValue = a.querySelector('.unit-name').textContent;
                        bValue = b.querySelector('.unit-name').textContent;
                        break;
                    default:
                        return 0;
                }
                
                return isAscending ? 
                    bValue.localeCompare(aValue) : 
                    aValue.localeCompare(bValue);
            });
            
            // Reorder rows in the table
            const tbody = table.querySelector('tbody');
            rows.forEach(row => tbody.appendChild(row));
            
            // Hide loading overlay
            loadingOverlay.classList.remove('active');
        }, 200);
    });
});

// Delete confirmation
function confirmDelete(unitId) {
    if (confirm('Apakah Anda yakin ingin menghapus unit ini?')) {
        document.getElementById(`delete-form-${unitId}`).submit();
    }
}

// Items per page
function changeItemsPerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', value);
    window.location.href = url.toString();
}

// Set selected items per page
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const perPage = urlParams.get('per_page');
    if (perPage) {
        document.getElementById('itemsPerPage').value = perPage;
    }
});
</script>
@endsection 