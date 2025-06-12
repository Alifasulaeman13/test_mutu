@extends('layouts.app')

@section('title', 'Manajemen User')

@section('page-title', 'Manajemen User')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="content-wrapper">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Tambah User -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="ri-user-add-line mr-2"></i>
                    Tambah User Baru
                    <div class="actions">
                        <i class="ri-refresh-line action-btn" title="Reset Form"></i>
                    </div>
                </h2>
            </div>
            <div class="p-6">
                <form action="{{ route('master-users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <i class="ri-user-line input-icon"></i>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                   class="form-input with-icon" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-wrapper">
                            <i class="ri-at-line input-icon"></i>
                            <input type="text" name="username" id="username" value="{{ old('username') }}" 
                                   class="form-input with-icon" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <i class="ri-mail-line input-icon"></i>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" 
                                   class="form-input with-icon" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="ri-lock-line input-icon"></i>
                            <input type="password" name="password" id="password" 
                                   class="form-input with-icon with-action" required>
                            <button type="button" class="input-action" onclick="togglePassword('password')" tabindex="-1">
                                <i class="ri-eye-line"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="role_id" class="form-label">Role</label>
                        <div class="input-wrapper">
                            <i class="ri-shield-user-line input-icon"></i>
                            <select name="role_id" id="role_id" class="form-input with-icon" required>
                                <option value="">Pilih Role</option>
                                @foreach(\App\Models\Role::all() as $role)
                                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="unit_id" class="form-label">Unit</label>
                        <div class="input-wrapper">
                            <i class="ri-building-line input-icon"></i>
                            <select name="unit_id" id="unit_id" class="form-input with-icon">
                                <option value="">Pilih Unit</option>
                                @foreach(\App\Models\Unit::where('is_active', true)->orderBy('name')->get() as $unit)
                                    <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }} ({{ $unit->code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="toggle-wrapper">
                            <label class="toggle">
                                <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                                <span class="toggle-slider"></span>
                            </label>
                            <span class="toggle-label" id="statusText">Aktif</span>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-save-line"></i>
                            Simpan User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar User -->
        <div class="lg:col-span-2 dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="ri-team-line mr-2"></i>
                    Daftar User
                    <div class="actions">
                        <div class="search-wrapper">
                            <i class="ri-search-line"></i>
                            <input type="text" id="searchTable" placeholder="Cari user..." class="search-input">
                        </div>
                        <div class="table-actions">
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
                </h2>
            </div>
            <div class="p-4">
                <div class="table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th class="column-header">
                                    <div class="th-content">
                                        <span>Nama & Username</span>
                                        <i class="ri-arrow-up-down-line sort-icon"></i>
                                    </div>
                                </th>
                                <th class="column-header">
                                    <div class="th-content">
                                        <span>Email</span>
                                        <i class="ri-arrow-up-down-line sort-icon"></i>
                                    </div>
                                </th>
                                <th class="column-header">
                                    <div class="th-content">
                                        <span>Role</span>
                                        <i class="ri-arrow-up-down-line sort-icon"></i>
                                    </div>
                                </th>
                                <th class="column-header">
                                    <div class="th-content">
                                        <span>Unit</span>
                                        <i class="ri-arrow-up-down-line sort-icon"></i>
                                    </div>
                                </th>
                                <th class="column-header">Status</th>
                                <th class="column-header text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(\App\Models\User::with(['role', 'unit'])->get() as $user)
                                <tr class="table-row">
                                    <td class="column-cell">
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                            <div class="user-details">
                                                <div class="user-name">{{ $user->name }}</div>
                                                <div class="user-username">{{ $user->username }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-cell">{{ $user->email }}</td>
                                    <td class="column-cell">
                                        <span class="role-badge">{{ $user->role->name }}</span>
                                    </td>
                                    <td class="column-cell">
                                        @if($user->unit)
                                            <span class="unit-badge" title="{{ $user->unit->description }}">
                                                {{ $user->unit->name }}
                                                <small>({{ $user->unit->code }})</small>
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="column-cell">
                                        <div class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                            <span class="status-dot"></span>
                                            {{ $user->is_active ? 'Aktif' : 'Non-aktif' }}
                                        </div>
                                    </td>
                                    <td class="column-cell text-right">
                                        <div class="action-buttons">
                                            <button type="button" class="action-btn edit" onclick="editUser({{ $user->id }})" title="Edit User">
                                                <i class="ri-edit-line"></i>
                                            </button>
                                            <button type="button" class="action-btn delete" onclick="deleteUser({{ $user->id }})" title="Hapus User">
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

<!-- Modal Edit User -->
<div id="editUserModal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">
                <i class="ri-edit-line mr-2"></i>
                Edit User
            </h3>
            <button class="modal-close" onclick="closeEditModal()">
                <i class="ri-close-line"></i>
            </button>
        </div>
        <div class="modal-body">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_user_id" name="user_id">
                
                <div class="form-group">
                    <label for="edit_name" class="form-label">Nama Lengkap</label>
                    <div class="input-wrapper">
                        <i class="ri-user-line input-icon"></i>
                        <input type="text" name="name" id="edit_name" class="form-input with-icon" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_username" class="form-label">Username</label>
                    <div class="input-wrapper">
                        <i class="ri-at-line input-icon"></i>
                        <input type="text" name="username" id="edit_username" class="form-input with-icon" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <i class="ri-mail-line input-icon"></i>
                        <input type="email" name="email" id="edit_email" class="form-input with-icon" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_password" class="form-label">Password (Kosongkan jika tidak diubah)</label>
                    <div class="input-wrapper">
                        <i class="ri-lock-line input-icon"></i>
                        <input type="password" name="password" id="edit_password" class="form-input with-icon with-action">
                        <button type="button" class="input-action" onclick="togglePassword('edit_password')" tabindex="-1">
                            <i class="ri-eye-line"></i>
                        </button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_role_id" class="form-label">Role</label>
                    <div class="input-wrapper">
                        <i class="ri-shield-user-line input-icon"></i>
                        <select name="role_id" id="edit_role_id" class="form-input with-icon" required>
                            <option value="">Pilih Role</option>
                            @foreach(\App\Models\Role::all() as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="edit_unit_id" class="form-label">Unit</label>
                    <div class="input-wrapper">
                        <i class="ri-building-line input-icon"></i>
                        <select name="unit_id" id="edit_unit_id" class="form-input with-icon">
                            <option value="">Pilih Unit</option>
                            @foreach(\App\Models\Unit::where('is_active', true)->orderBy('name')->get() as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }} ({{ $unit->code }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="toggle-wrapper">
                        <label class="toggle">
                            <input type="checkbox" name="is_active" id="edit_is_active">
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label" id="statusText">Aktif</span>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" onclick="closeEditModal()">
                <i class="ri-close-line"></i>
                Batal
            </button>
            <button type="button" class="btn btn-primary" onclick="updateUser()">
                <i class="ri-save-line"></i>
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>

<style>
.content-wrapper {
    padding: 1.5rem;
}

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

.alert {
    padding: 1rem;
    border-radius: 0.5rem;
    margin-bottom: 1rem;
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

.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.input-icon {
    position: absolute;
    left: 1rem;
    color: #64748b;
    font-size: 1rem;
    pointer-events: none;
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    border: 1px solid #e2e8f0;
    background-color: #f8fafc;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    color: #1e293b;
    transition: all 0.2s;
}

.form-input:hover {
    background-color: #f1f5f9;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    background-color: white;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-input.with-action {
    padding-right: 2.5rem;
}

.input-action {
    position: absolute;
    right: 1rem;
    color: #64748b;
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    font-size: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.input-action:hover {
    color: var(--primary-color);
}

/* Select Styling */
select.form-input {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 1rem center;
    background-size: 1rem;
    padding-right: 2.5rem;
}

select.form-input:focus {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%232563eb'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
}

/* Error State */
.form-input.error {
    border-color: #dc2626;
    background-color: #fef2f2;
}

.form-input.error:focus {
    box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1);
}

/* Success State */
.form-input.success {
    border-color: #059669;
    background-color: #f0fdf4;
}

.form-input.success:focus {
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

.btn {
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-weight: 500;
    font-size: 0.875rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: var(--primary-dark);
}

/* Table Styles */
thead tr {
    background-color: #f8fafc;
}

tbody tr:hover {
    background-color: #f8fafc;
}

th {
    font-weight: 600;
    color: #64748b;
}

/* Enhanced Table Styles */
.table-container {
    overflow-x: auto;
    border-radius: 8px;
    background: white;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.th-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.sort-icon {
    font-size: 1rem;
    opacity: 0.5;
    transition: all 0.2s;
    cursor: pointer;
}

.sort-icon:hover {
    opacity: 1;
    color: var(--primary-color);
}

.modern-table th {
    padding: 1rem;
    background: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    text-align: left;
}

.table-row {
    transition: all 0.2s;
}

.table-row:hover {
    background-color: #f8fafc;
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.04);
}

.modern-table td {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
}

/* User Info Styles */
.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.user-name {
    font-weight: 600;
    color: #1e293b;
}

.user-meta {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.75rem;
    color: #64748b;
}

.separator {
    color: #cbd5e1;
}

/* Role Badge */
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
}

.role-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
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

/* Action Buttons */
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
}

.action-btn {
    padding: 0.5rem;
    border-radius: 6px;
    transition: all 0.2s;
    cursor: pointer;
}

.action-btn.edit {
    color: #2563eb;
    background-color: #eff6ff;
}

.action-btn.edit:hover {
    background-color: #dbeafe;
}

.action-btn.delete {
    color: #dc2626;
    background-color: #fee2e2;
}

.action-btn.delete:hover {
    background-color: #fecaca;
}

/* Search Input */
.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-wrapper i {
    position: absolute;
    left: 0.75rem;
    color: #64748b;
    font-size: 0.875rem;
}

.search-input {
    padding: 0.5rem 0.75rem 0.5rem 2.25rem;
    border: 1px solid #e2e8f0;
    border-radius: 6px;
    font-size: 0.875rem;
    width: 200px;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    width: 250px;
}

.unit-text {
    color: #64748b;
    font-size: 0.875rem;
}

/* Enhanced Table Styles */
.column-header {
    background-color: #f1f5f9 !important;
    border-bottom: 2px solid #e2e8f0 !important;
    padding: 1rem !important;
    font-weight: 600 !important;
    color: #475569 !important;
    text-transform: uppercase;
    font-size: 0.75rem;
    letter-spacing: 0.05em;
}

.column-cell {
    background-color: #ffffff;
    padding: 1rem !important;
    border-bottom: 1px solid #e2e8f0;
}

.table-row:hover .column-cell {
    background-color: #f8fafc;
}

/* Email Styles */
.email-wrapper {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
}

.email-icon {
    font-size: 1rem;
    color: #94a3b8;
}

.email-text {
    font-size: 0.875rem;
}

/* Zebra Striping for Better Readability */
.table-row:nth-child(even) .column-cell {
    background-color: #f8fafc;
}

.table-row:nth-child(even):hover .column-cell {
    background-color: #f1f5f9;
}

/* Enhanced User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.user-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.user-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.user-name {
    font-weight: 600;
    color: #1e293b;
}

.user-meta {
    font-size: 0.75rem;
    color: #64748b;
}

/* Enhanced Role Badge */
.role-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

/* Enhanced Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    box-shadow: 0 1px 2px rgba(0,0,0,0.05);
}

/* Enhanced Action Buttons */
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    opacity: 0.7;
    transition: opacity 0.2s;
}

.table-row:hover .action-buttons {
    opacity: 1;
}

.modern-table {
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
}

/* Add subtle animation to row hover */
.table-row {
    transition: transform 0.2s, box-shadow 0.2s;
}

.table-row:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Enhanced Alert Styles */
.alert {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    border-radius: 0.75rem;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.alert-icon {
    flex-shrink: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    font-size: 1rem;
}

.alert-danger .alert-icon {
    background-color: #fee2e2;
}

.alert-success .alert-icon {
    background-color: #dcfce7;
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.alert-list {
    margin: 0;
    padding-left: 1.25rem;
    font-size: 0.875rem;
}

/* Enhanced Section Header */
.section-header {
    background: linear-gradient(to right, #f1f5f9, #f8fafc);
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}

.section-title {
    display: flex;
    align-items: center;
    justify-content: space-between;
    color: #1e293b;
    font-size: 1rem;
    font-weight: 600;
}

.section-title i {
    font-size: 1.25rem;
    color: var(--primary-color);
}

/* Enhanced Table Actions */
.table-actions {
    display: flex;
    gap: 0.5rem;
}

.table-actions .action-btn {
    padding: 0.5rem;
    border-radius: 0.375rem;
    color: #64748b;
    transition: all 0.2s;
    background-color: white;
    border: 1px solid #e2e8f0;
}

.table-actions .action-btn:hover {
    color: var(--primary-color);
    background-color: #f8fafc;
    border-color: var(--primary-color);
}

.table-actions .action-btn.refresh {
    color: var(--primary-color);
    background-color: #eff6ff;
    border-color: #bfdbfe;
}

.table-actions .action-btn.refresh:hover {
    background-color: #dbeafe;
}

/* Enhanced Search Input */
.search-wrapper {
    position: relative;
    margin-right: 1rem;
}

.search-input {
    width: 250px;
    padding: 0.5rem 0.75rem 0.5rem 2.25rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.5rem;
    font-size: 0.875rem;
    background-color: white;
    transition: all 0.2s;
}

.search-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    width: 300px;
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

/* Enhanced Dashboard Section */
.dashboard-section {
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 1px 2px rgba(0,0,0,0.06);
    border: 1px solid #e2e8f0;
    transition: all 0.2s;
}

.dashboard-section:hover {
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
}

/* Modern Scrollbar */
.table-container {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f5f9;
}

.table-container::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Loading State */
.table-loading {
    position: relative;
}

.table-loading::after {
    content: '';
    position: absolute;
    inset: 0;
    background: rgba(255,255,255,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Empty State */
.table-empty {
    padding: 3rem;
    text-align: center;
    color: #64748b;
}

.table-empty i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #94a3b8;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 1050;
}

.modal.show {
    display: block;
}

.modal-overlay {
    position: fixed;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.4);
    backdrop-filter: blur(4px);
}

.modal-container {
    position: relative;
    width: 90%;
    max-width: 600px;
    margin: 2rem auto;
    background: white;
    border-radius: 0.5rem;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    transform: translateY(-30px);
    opacity: 0;
    transition: all 0.3s ease-out;
}

.modal.show .modal-container {
    transform: translateY(0);
    opacity: 1;
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.25rem;
    border-bottom: 1px solid #e2e8f0;
}

.modal-title {
    display: flex;
    align-items: center;
    font-size: 1.25rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    color: #64748b;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.modal-close:hover {
    background-color: #f1f5f9;
    color: #ef4444;
}

.modal-body {
    padding: 1.25rem;
    max-height: calc(100vh - 200px);
    overflow-y: auto;
}

.modal-footer {
    padding: 1.25rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.75rem;
}

.btn-secondary {
    background-color: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background-color: #e2e8f0;
}

/* Toggle Switch */
.toggle-wrapper {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.toggle {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.toggle input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background-color: #e2e8f0;
    border-radius: 34px;
    transition: 0.4s;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 20px;
    width: 20px;
    left: 2px;
    bottom: 2px;
    background-color: white;
    border-radius: 50%;
    transition: 0.4s;
}

.toggle input:checked + .toggle-slider {
    background-color: var(--primary-color);
}

.toggle input:checked + .toggle-slider:before {
    transform: translateX(26px);
}

.toggle-label {
    font-size: 0.875rem;
    color: #475569;
}

/* Scrollbar for Modal */
.modal-body {
    scrollbar-width: thin;
    scrollbar-color: #cbd5e1 #f1f5f9;
}

.modal-body::-webkit-scrollbar {
    width: 6px;
}

.modal-body::-webkit-scrollbar-track {
    background: #f1f5f9;
}

.modal-body::-webkit-scrollbar-thumb {
    background-color: #cbd5e1;
    border-radius: 3px;
}

.modal-body::-webkit-scrollbar-thumb:hover {
    background-color: #94a3b8;
}
</style>

<script>
// Toggle status text
document.getElementById('is_active').addEventListener('change', function(e) {
    document.getElementById('statusText').textContent = this.checked ? 'Aktif' : 'Non-aktif';
});

// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const icon = input.parentElement.querySelector('.input-action i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('ri-eye-line', 'ri-eye-off-line');
    } else {
        input.type = 'password';
        icon.classList.replace('ri-eye-off-line', 'ri-eye-line');
    }
}

function editUser(userId) {
    // Show loading state
    showLoading();
    
    console.log('Fetching user data for ID:', userId);
    
    // Fetch user data
    fetch(`/api/users/${userId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(user => {
            console.log('User data received:', user);
            
            // Fill form with user data
            document.getElementById('edit_user_id').value = user.id;
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role_id').value = user.role_id;
            document.getElementById('edit_unit_id').value = user.unit_id;
            document.getElementById('edit_is_active').checked = user.is_active;
            document.getElementById('statusText').textContent = user.is_active ? 'Aktif' : 'Non-aktif';
            
            // Show modal
            const modal = document.getElementById('editUserModal');
            modal.classList.add('show');
            
            // Hide loading
            hideLoading();
        })
        .catch(error => {
            console.error('Error fetching user:', error);
            hideLoading();
            // Show error message
            alert('Terjadi kesalahan saat mengambil data user');
        });
}

function closeEditModal() {
    const modal = document.getElementById('editUserModal');
    modal.classList.remove('show');
    // Reset form
    document.getElementById('editUserForm').reset();
}

function updateUser() {
    const userId = document.getElementById('edit_user_id').value;
    
    // Get form data
    const formData = {
        name: document.getElementById('edit_name').value,
        username: document.getElementById('edit_username').value,
        email: document.getElementById('edit_email').value,
        password: document.getElementById('edit_password').value,
        role_id: document.getElementById('edit_role_id').value,
        unit_id: document.getElementById('edit_unit_id').value,
        is_active: document.getElementById('edit_is_active').checked
    };
    
    console.log('Updating user with data:', formData);
    
    // Show loading state
    Swal.fire({
        title: 'Memperbarui Data',
        text: 'Mohon tunggu...',
        allowOutsideClick: false,
        showConfirmButton: false,
        willOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Get CSRF token
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Send update request
    fetch(`/api/users/${userId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        },
        body: JSON.stringify(formData)
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(err => Promise.reject(err));
        }
        return response.json();
    })
    .then(data => {
        console.log('Update response:', data);
        
        if (data.success) {
            // Close modal
            closeEditModal();
            // Show success sweet alert
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Data user berhasil diperbarui',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                customClass: {
                    popup: 'animated fadeInDown'
                }
            }).then(() => {
                // Refresh page after alert closed
                location.reload();
            });
        } else {
            console.error('Update failed:', data);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: data.message || 'Terjadi kesalahan saat mengupdate user'
            });
        }
    })
    .catch(error => {
        console.error('Error updating user:', error);
        if (error.errors) {
            // Show validation errors with sweet alert
            const errorMessages = Object.values(error.errors).flat().join('\n');
            console.error('Validation errors:', errorMessages);
            Swal.fire({
                icon: 'error',
                title: 'Error Validasi',
                text: errorMessages
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Terjadi kesalahan saat mengupdate user'
            });
        }
    });
}

// Close modal when clicking overlay
document.querySelector('.modal-overlay').addEventListener('click', closeEditModal);

// Prevent modal close when clicking modal content
document.querySelector('.modal-container').addEventListener('click', function(e) {
    e.stopPropagation();
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEditModal();
    }
});

// Search functionality
document.getElementById('searchTable').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const rows = document.querySelectorAll('.table-row');
    
    rows.forEach(row => {
        const name = row.querySelector('.user-name').textContent.toLowerCase();
        const username = row.querySelector('.user-username').textContent.toLowerCase();
        const email = row.querySelector('.email').textContent.toLowerCase();
        
        if (name.includes(searchTerm) || username.includes(searchTerm) || email.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Add loading state
function showLoading() {
    document.querySelector('.table-container').classList.add('table-loading');
}

function hideLoading() {
    document.querySelector('.table-container').classList.remove('table-loading');
}

// Add empty state if no data
function checkEmptyState() {
    const tbody = document.querySelector('.modern-table tbody');
    if (!tbody.hasChildNodes()) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="table-empty">
                    <i class="ri-inbox-line"></i>
                    <p>Tidak ada data user yang ditemukan</p>
                </td>
            </tr>
        `;
    }
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    checkEmptyState();
});

function deleteUser(userId) {
    // Show confirmation dialog
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data user yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading state
            Swal.fire({
                title: 'Menghapus Data',
                text: 'Mohon tunggu...',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Send delete request
            fetch(`/api/users/${userId}`, {
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
                        text: 'Data user berhasil dihapus',
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
                        text: data.message || 'Terjadi kesalahan saat menghapus user'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Terjadi kesalahan saat menghapus user'
                });
            });
        }
    });
}
</script>
@endsection
