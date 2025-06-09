@extends('layouts.app')

@section('title', 'Manage Role')

@section('page-title', 'Manage Role')

@section('styles')
.content-wrapper {
    max-width: 100%;
    margin: 0 auto;
}

.dashboard-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.section-header {
    background: #f8fafc;
    padding: 1rem;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
}

/* Stats Cards */
.stats-card {
    padding: 1.25rem;
    border-radius: 8px;
    color: white;
    position: relative;
    overflow: hidden;
    transition: all 0.3s;
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.stats-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    opacity: 0.9;
}

.stats-info h3 {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    opacity: 0.9;
}

.stats-value {
    font-size: 1.5rem;
    font-weight: 600;
}

/* Form Styling */
.modern-form .form-group {
    margin-bottom: 1rem;
}

.modern-form .form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #475569;
    margin-bottom: 0.5rem;
}

.modern-form .input-wrapper {
    position: relative;
}

.modern-form .form-input {
    width: 100%;
    padding: 0.625rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.modern-form .form-input:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 2px rgba(37,99,235,0.1);
}

.modern-form .input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

.modern-form .form-input.with-icon {
    padding-left: 2.5rem;
}

/* Table Styling */
.table-container {
    overflow-x: auto;
    margin: 0 -1rem;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table th {
    background: #f8fafc;
    padding: 0.75rem 1rem;
    font-size: 0.75rem;
    font-weight: 500;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    border-bottom: 1px solid #e2e8f0;
}

.modern-table td {
    padding: 0.75rem 1rem;
    font-size: 0.875rem;
    color: #475569;
    border-bottom: 1px solid #e2e8f0;
}

.role-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.875rem;
    font-weight: 500;
}

.role-dot {
    width: 0.5rem;
    height: 0.5rem;
    border-radius: 9999px;
    margin-right: 0.5rem;
}

.user-count-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 1.5rem;
    height: 1.5rem;
    padding: 0 0.5rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    background: #dbeafe;
    color: #2563eb;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.action-btn {
    padding: 0.375rem;
    border-radius: 6px;
    color: #64748b;
    transition: all 0.2s;
}

.action-btn:hover {
    background: #f1f5f9;
}

.action-btn.view:hover {
    color: #2563eb;
    background: #dbeafe;
}

.action-btn.edit:hover {
    color: #d97706;
    background: #fef3c7;
}

.action-btn.delete:hover {
    color: #dc2626;
    background: #fee2e2;
}

/* Modal Styling */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 50;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease-in-out;
}

.modal.show {
    display: block;
    opacity: 1;
    visibility: visible;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    opacity: 0;
    transition: all 0.3s ease-in-out;
}

.modal.show .modal-overlay {
    opacity: 1;
}

.modal-container {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -60%);
    width: 90%;
    max-width: 500px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    opacity: 0;
    transition: all 0.3s ease-in-out;
}

.modal.show .modal-container {
    transform: translate(-50%, -50%);
    opacity: 1;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem;
    border-bottom: 1px solid #e5e7eb;
    background: #f8fafc;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.modal-title {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1.125rem;
    font-weight: 600;
    color: #1e293b;
}

.modal-title i {
    font-size: 1.25rem;
}

.modal-close {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    border-radius: 9999px;
    color: #64748b;
    transition: all 0.2s;
    background: transparent;
    border: none;
    cursor: pointer;
}

.modal-close:hover {
    background: #f1f5f9;
    color: #ef4444;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
    padding: 1.25rem;
    background: #f8fafc;
    border-top: 1px solid #e5e7eb;
    border-bottom-left-radius: 12px;
    border-bottom-right-radius: 12px;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary {
    background: #2563eb;
    color: white;
}

.btn-primary:hover {
    background: #1d4ed8;
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
}

.btn-secondary:hover {
    background: #e2e8f0;
}

/* Search */
.search-wrapper {
    position: relative;
}

.search-input {
    padding: 0.5rem 1rem 0.5rem 2.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.875rem;
    min-width: 200px;
}

.search-wrapper i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
}

/* Permissions */
.permissions-grid {
    display: grid;
    gap: 1rem;
}

.permission-group {
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    overflow: hidden;
}

.permission-group-header {
    background: #f8fafc;
    padding: 0.75rem 1rem;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.permission-group-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: #475569;
}

.permission-items {
    padding: 1rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
}

.permission-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.5rem;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.permission-item:hover {
    background: #f8fafc;
}

.permission-check {
    width: 1.25rem;
    height: 1.25rem;
    border: 2px solid #e2e8f0;
    border-radius: 0.25rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.permission-item input:checked + .permission-check {
    background: #2563eb;
    border-color: #2563eb;
}

.permission-item input:checked + .permission-check::after {
    content: '✓';
    color: white;
    font-size: 0.75rem;
}

.permission-label {
    font-size: 0.875rem;
    color: #475569;
}

/* Stats Row Layout */
.stats-row {
    display: flex;
    gap: 1rem;
    flex-wrap: nowrap;
    overflow-x: auto;
    padding: 0.5rem;
    margin: -0.5rem;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
}

.stats-row::-webkit-scrollbar {
    display: none; /* Chrome, Safari and Opera */
}

/* Stats Card */
.stats-card {
    flex: 1;
    min-width: 220px;
    padding: 1.5rem;
    border-radius: 12px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.stats-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.stats-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    z-index: 1;
}

.stats-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.stats-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    background: rgba(255, 255, 255, 0.15);
    border-radius: 12px;
    font-size: 1.75rem;
    color: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(4px);
}

.stats-info {
    flex: 1;
}

.stats-label {
    color: rgba(255, 255, 255, 0.95);
    font-size: 0.9375rem;
    font-weight: 500;
    margin-bottom: 0.375rem;
    letter-spacing: 0.01em;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

.stats-value {
    color: #ffffff;
    font-size: 1.75rem;
    font-weight: 600;
    line-height: 1.2;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stats-row {
        margin: 0 -1rem;
        padding: 0 1rem;
        scroll-padding: 1rem;
        -webkit-overflow-scrolling: touch;
    }
    
    .stats-card {
        min-width: 200px;
        padding: 1.25rem;
    }

    .stats-icon {
        width: 48px;
        height: 48px;
        font-size: 1.5rem;
    }

    .stats-label {
        font-size: 0.875rem;
    }

    .stats-value {
        font-size: 1.5rem;
    }
}
@endsection

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content-wrapper p-4">
    <!-- Stats Cards -->
    <div class="stats-row mb-6">
        <div class="stats-card" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="ri-shield-star-line"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-label">Total Role</div>
                    <div class="stats-value">{{ \App\Models\Role::count() }}</div>
                </div>
            </div>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%)">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="ri-user-star-line"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-label">Role Aktif</div>
                    <div class="stats-value">{{ \App\Models\Role::has('users')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%)">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="ri-shield-check-line"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-label">Role Terpakai</div>
                    <div class="stats-value">{{ \App\Models\Role::whereHas('users')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="stats-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%)">
            <div class="stats-content">
                <div class="stats-icon">
                    <i class="ri-shield-cross-line"></i>
                </div>
                <div class="stats-info">
                    <div class="stats-label">Role Tidak Aktif</div>
                    <div class="stats-value">{{ \App\Models\Role::doesntHave('users')->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <div class="alert-icon">
                <i class="ri-error-warning-line"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Error!</div>
                <ul class="alert-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success mb-4">
            <div class="alert-icon">
                <i class="ri-checkbox-circle-line"></i>
            </div>
            <div class="alert-content">
                <div class="alert-title">Berhasil!</div>
                <div>{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">
        <!-- Form Tambah Role -->
        <div class="lg:col-span-4 dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="ri-shield-star-line mr-2"></i>
                    Tambah Role Baru
                </h2>
            </div>
            <div class="p-4">
                <form action="{{ route('manage-role.store') }}" method="POST" class="modern-form">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="name" class="form-label">Nama Role</label>
                        <div class="input-wrapper">
                            <i class="ri-shield-user-line input-icon"></i>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="form-input with-icon" required
                                   placeholder="Masukkan nama role"
                                   onkeyup="createSlug(this.value)">
                            <input type="hidden" name="slug" id="slug">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label for="description" class="form-label">Deskripsi</label>
                        <div class="input-wrapper">
                            <i class="ri-file-text-line input-icon"></i>
                            <textarea name="description" id="description" 
                                      class="form-input with-icon" rows="3"
                                      placeholder="Deskripsikan role ini">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="reset" class="btn btn-secondary">
                            <i class="ri-restart-line"></i>
                            Reset
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i>
                            Simpan Role
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Role -->
        <div class="lg:col-span-8 dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="ri-shield-star-line mr-2"></i>
                    Daftar Role
                </h2>
                <div class="header-actions">
                    <div class="search-wrapper">
                        <i class="ri-search-line"></i>
                        <input type="text" id="searchTable" placeholder="Cari role..." class="search-input">
                    </div>
                    <div class="action-buttons">
                        <button class="action-btn" title="Export Excel">
                            <i class="ri-file-excel-line"></i>
                        </button>
                        <button class="action-btn" title="Export PDF">
                            <i class="ri-file-pdf-line"></i>
                        </button>
                        <button class="action-btn" title="Print">
                            <i class="ri-printer-line"></i>
                        </button>
                        <button class="action-btn refresh" title="Refresh">
                            <i class="ri-refresh-line"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Deskripsi</th>
                                <th class="text-center">Total User</th>
                                <th class="text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\Role::withCount('users')->get() as $role)
                                <tr>
                                    <td>
                                        <div class="role-info">
                                            <div class="role-badge" style="background-color: {{ '#' . substr(md5($role->name), 0, 6) }}20">
                                                <span class="role-dot" style="background-color: {{ '#' . substr(md5($role->name), 0, 6) }}"></span>
                                                {{ $role->name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="description-text">{{ $role->description ?: '-' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <div class="user-count-badge" data-count="{{ $role->users_count }}">
                                            {{ $role->users_count }}
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="action-buttons">
                                            <button type="button" class="action-btn view" onclick="viewRole({{ $role->id }})" title="Lihat Detail">
                                                <i class="ri-eye-line"></i>
                                            </button>
                                            <button type="button" class="action-btn edit" onclick="editRole({{ $role->id }})" title="Edit Role">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button type="button" class="action-btn delete" onclick="deleteRole({{ $role->id }})" title="Hapus Role">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Role -->
<div id="editRoleModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        <div class="modal-header">
            <div class="modal-title">
                <i class="ri-edit-line text-blue-500"></i>
                <span>Edit Role</span>
            </div>
            <button class="modal-close" onclick="closeEditModal()">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editRoleForm" method="POST" class="modern-form">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_role_id" name="role_id">
                <input type="hidden" id="edit_slug" name="slug">
                
                <div class="form-group">
                    <label for="edit_name" class="form-label">
                        <i class="ri-shield-user-line text-gray-400 mr-2"></i>
                        Nama Role
                    </label>
                    <div class="input-wrapper">
                        <input type="text" name="name" id="edit_name" 
                               class="form-input" required
                               onkeyup="createEditSlug(this.value)"
                               placeholder="Masukkan nama role">
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_description" class="form-label">
                        <i class="ri-file-text-line text-gray-400 mr-2"></i>
                        Deskripsi
                    </label>
                    <div class="input-wrapper">
                        <textarea name="description" id="edit_description" 
                                  class="form-input" rows="3"
                                  placeholder="Deskripsikan role ini"></textarea>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
                <i class="ri-close-line"></i>
                Batal
            </button>
            <button type="button" class="btn btn-primary" onclick="updateRole()">
                <i class="ri-save-line"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>

<style>
/* Modern Stats Cards */
.stats-card {
    @apply p-6 rounded-xl text-white shadow-lg relative overflow-hidden transition-transform duration-300 hover:transform hover:scale-105;
}

.stats-card::before {
    content: '';
    @apply absolute inset-0 bg-white opacity-10 transform -skew-x-12;
}

.stats-icon {
    @apply text-4xl mb-4 opacity-90;
}

.stats-info h3 {
    @apply text-sm font-medium opacity-90;
}

.stats-value {
    @apply text-2xl font-bold;
}

/* Modern Form Styling */
.modern-form .form-group {
    @apply mb-6;
}

.modern-form .form-label {
    @apply block text-sm font-medium text-gray-700 mb-2;
}

.modern-form .input-wrapper {
    @apply relative;
}

.modern-form .form-input {
    @apply w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200;
}

.modern-form .input-icon {
    @apply absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400;
}

.modern-form .form-input.with-icon {
    @apply pl-10;
}

/* Permission Groups */
.permission-group {
    @apply bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden mb-4;
}

.permission-group-header {
    @apply flex items-center justify-between p-4 bg-gray-50 border-b border-gray-200;
}

.permission-group-title {
    @apply font-medium text-gray-700;
}

.permission-items {
    @apply p-4 grid grid-cols-1 md:grid-cols-2 gap-3;
}

.permission-item {
    @apply flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 transition-colors duration-200 cursor-pointer;
}

.permission-check {
    @apply w-5 h-5 rounded border-2 border-gray-300 flex items-center justify-center transition-colors duration-200;
}

.permission-item input:checked + .permission-check {
    @apply bg-blue-500 border-blue-500;
}

.permission-item input:checked + .permission-check::after {
    content: '✓';
    @apply text-white text-sm;
}

/* Table Styling */
.modern-table {
    @apply w-full bg-white rounded-lg overflow-hidden;
}

.column-header {
    @apply bg-gray-50 px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider;
}

.column-cell {
    @apply px-6 py-4 whitespace-nowrap text-sm text-gray-900;
}

.role-badge {
    @apply inline-flex items-center px-3 py-1 rounded-full text-sm font-medium;
}

.role-dot {
    @apply w-2 h-2 rounded-full mr-2;
}

.user-count-badge {
    @apply inline-flex items-center justify-center min-w-[2rem] h-6 px-2 rounded-full text-xs font-medium;
}

.user-count-badge[data-count="0"] {
    @apply bg-gray-100 text-gray-600;
}

.user-count-badge[data-count]:not([data-count="0"]) {
    @apply bg-blue-100 text-blue-700;
}

/* Action Buttons */
.action-buttons {
    @apply flex items-center space-x-1;
}

.action-btn {
    @apply p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200;
}

.action-btn.view {
    @apply text-blue-500 hover:bg-blue-50;
}

.action-btn.edit {
    @apply text-amber-500 hover:bg-amber-50;
}

.action-btn.delete {
    @apply text-red-500 hover:bg-red-50;
}

/* Form Actions */
.form-actions {
    @apply flex justify-end space-x-3 mt-6;
}

.btn {
    @apply px-4 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition-all duration-200;
}

.btn-primary {
    @apply bg-blue-500 text-white hover:bg-blue-600 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2;
}

.btn-secondary {
    @apply bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2;
}

/* Search and Actions */
.header-actions {
    @apply flex items-center space-x-4;
}

.search-wrapper {
    @apply relative;
}

.search-input {
    @apply pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-64 transition-all duration-200;
}

.search-wrapper i {
    @apply absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.animated {
    animation: fadeIn 0.3s ease-out;
}
</style>

<script>
// Add necessary JavaScript functions similar to user management
function editRole(roleId) {
    // Show loading state
    Swal.fire({
        title: 'Memuat Data',
        text: 'Mohon tunggu...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Fetch role data
    fetch(`/api/roles/${roleId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(role => {
            document.getElementById('edit_role_id').value = role.id;
            document.getElementById('edit_name').value = role.name;
            document.getElementById('edit_description').value = role.description || '';
            document.getElementById('edit_slug').value = role.slug;
            
            // Show modal with animation
            const modal = document.getElementById('editRoleModal');
            modal.classList.add('show');
            
            Swal.close();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan saat mengambil data role'
            });
        });
}

function closeEditModal() {
    const modal = document.getElementById('editRoleModal');
    modal.classList.remove('show');
    document.getElementById('editRoleForm').reset();
}

function updateRole() {
    const roleId = document.getElementById('edit_role_id').value;
    
    Swal.fire({
        title: 'Memperbarui Data',
        text: 'Mohon tunggu...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch(`/api/roles/${roleId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify({
            name: document.getElementById('edit_name').value,
            description: document.getElementById('edit_description').value
        })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            closeEditModal();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data role berhasil diperbarui',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Terjadi kesalahan saat mengupdate role'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        if (error.errors) {
            const errorMessages = Object.values(error.errors).flat().join('\n');
            Swal.fire({
                icon: 'error',
                title: 'Error Validasi',
                text: errorMessages
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Terjadi kesalahan saat mengupdate role'
            });
        }
    });
}

function deleteRole(roleId) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data role yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus Data',
                text: 'Mohon tunggu...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            fetch(`/api/roles/${roleId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data role berhasil dihapus',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message || 'Terjadi kesalahan saat menghapus role'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Terjadi kesalahan saat menghapus role'
                });
            });
        }
    });
}

function createSlug(name) {
    // Convert to lowercase and replace spaces with dashes
    let slug = name.toLowerCase()
        .replace(/[^a-z0-9-]/g, '-') // Replace non-alphanumeric characters with dash
        .replace(/-+/g, '-')         // Replace multiple dashes with single dash
        .replace(/^-+|-+$/g, '');    // Remove dashes from start and end
    
    document.getElementById('slug').value = slug;
}

function createEditSlug(name) {
    let slug = name.toLowerCase()
        .replace(/[^a-z0-9-]/g, '-')
        .replace(/-+/g, '-')
        .replace(/^-+|-+$/g, '');
    
    document.getElementById('edit_slug').value = slug;
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('editRoleModal');
    if (event.target.classList.contains('modal-overlay')) {
        closeEditModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeEditModal();
    }
});

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Add any initialization code here
});
</script>
@endsection
