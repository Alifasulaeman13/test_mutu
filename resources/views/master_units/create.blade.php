@extends('layouts.app')

@section('title', 'Tambah Unit Baru')

@section('page-title', 'Tambah Unit Baru')

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
    box-shadow: 0 0 0 3px rgba(0, 119, 116, 0.1);
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

.btn-secondary {
    background-color: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
    background-color: #e2e8f0;
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

.grid {
    display: grid;
    gap: 1.5rem;
}

.grid-cols-1 {
    grid-template-columns: repeat(1, minmax(0, 1fr));
}

@media (min-width: 1024px) {
    .lg\:grid-cols-3 {
        grid-template-columns: repeat(3, minmax(0, 1fr));
    }
    
    .lg\:col-span-2 {
        grid-column: span 2 / span 2;
    }
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

.alert-list {
    margin: 0;
    padding-left: 1.25rem;
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

.form-section {
    background: white;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.form-section-header {
    padding: 1rem;
    border-bottom: 1px solid #e2e8f0;
}

.form-section-title {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    padding: 1.5rem;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
}

.form-footer {
    background: #f8fafc;
    padding: 1rem;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 1rem;
}

.required-field::after {
    content: "*";
    color: #dc2626;
    margin-left: 0.25rem;
}

.form-help {
    font-size: 0.75rem;
    color: #64748b;
    margin-top: 0.25rem;
}

.preview-section {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 4px;
    padding: 1rem;
    margin-top: 1rem;
}

.preview-title {
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    margin-bottom: 0.5rem;
}

.preview-content {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="ri-add-line"></i>
            Tambah Unit Baru
        </h1>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
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

    <!-- Form Section -->
    <form id="createUnitForm" action="{{ route('master.units.store') }}" method="POST">
        @csrf
        
        <div class="form-section">
            <div class="form-section-header">
                <h2 class="form-section-title">
                    <i class="ri-file-list-line"></i>
                    Informasi Unit
                </h2>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="code" class="form-label required-field">Kode Unit</label>
                    <div class="input-wrapper">
                        <i class="ri-barcode-line input-icon"></i>
                        <input type="text" name="code" id="code" value="{{ old('code', $nextCode) }}" 
                               class="form-input with-icon" readonly>
                    </div>
                    <div class="form-help">Kode unit akan digenerate secara otomatis</div>
                </div>

                <div class="form-group">
                    <label for="name" class="form-label required-field">Nama Unit</label>
                    <div class="input-wrapper">
                        <i class="ri-building-line input-icon"></i>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                               class="form-input with-icon" required
                               placeholder="Masukkan nama unit">
                    </div>
                </div>

                <div class="form-group" style="grid-column: span 2;">
                    <label for="description" class="form-label">Deskripsi</label>
                    <div class="input-wrapper">
                        <i class="ri-file-text-line input-icon"></i>
                        <textarea name="description" id="description" rows="3" 
                                  class="form-input with-icon"
                                  placeholder="Masukkan deskripsi unit">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="toggle-wrapper">
                        <label class="toggle">
                            <input type="checkbox" name="is_active" id="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                        <span class="toggle-label" id="statusText">Aktif</span>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <div class="preview-section">
                <div class="preview-title">Preview</div>
                <div class="preview-content">
                    <span class="code-badge" id="previewCode">{{ old('code', $nextCode) }}</span>
                    <span class="unit-name" id="previewName">{{ old('name', 'Nama Unit') }}</span>
                    <span class="status-badge active" id="previewStatus">
                        <span class="status-dot"></span>
                        <span id="previewStatusText">Aktif</span>
                    </span>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('master.units.index') }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-line"></i>
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i>
                    Simpan Unit
                </button>
            </div>
        </div>
    </form>
</div>

<script>
// Live preview
const nameInput = document.getElementById('name');
const previewName = document.getElementById('previewName');
const statusToggle = document.getElementById('is_active');
const statusText = document.getElementById('statusText');
const previewStatus = document.getElementById('previewStatus');
const previewStatusText = document.getElementById('previewStatusText');

nameInput.addEventListener('input', function(e) {
    previewName.textContent = e.target.value || 'Nama Unit';
});

statusToggle.addEventListener('change', function(e) {
    const isActive = this.checked;
    statusText.textContent = isActive ? 'Aktif' : 'Non-aktif';
    previewStatus.className = `status-badge ${isActive ? 'active' : 'inactive'}`;
    previewStatusText.textContent = isActive ? 'Aktif' : 'Non-aktif';
});

// Form validation
document.getElementById('createUnitForm').addEventListener('submit', function(e) {
    const name = nameInput.value.trim();
    
    if (!name) {
        e.preventDefault();
        alert('Nama unit harus diisi!');
        nameInput.focus();
    }
});
</script>
@endsection 