@extends('layouts.app')

@section('title', 'Edit Indikator')
@section('page-title', 'Edit Indikator')

@section('content')
<x-sweet-alert />

<div class="dashboard-section">
    <div class="section-header">
        <div class="header-title">
            <i class="ri-edit-line"></i>
            Edit Indikator
        </div>
    </div>
    
    <div class="section-body">
        <form action="{{ route('master-indikator.update', $indicator->id) }}" method="POST" class="space-y-4" onsubmit="confirmSubmit(event)">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="unit_id" class="form-label">Unit</label>
                <select name="unit_id" id="unit_id" class="form-select @error('unit_id') is-invalid @enderror" required>
                    <option value="">Pilih Unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id', $indicator->unit_id) == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
                @error('unit_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Nama Indikator</label>
                <input type="text" name="name" id="name" class="form-input @error('name') is-invalid @enderror"
                    value="{{ old('name', $indicator->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="target_percentage" class="form-label">Target Persentase</label>
                <div class="input-group">
                    <input type="number" name="target_percentage" id="target_percentage" 
                        class="form-input @error('target_percentage') is-invalid @enderror"
                        value="{{ old('target_percentage', $indicator->target_percentage) }}" 
                        min="0" max="100" step="0.01" required>
                    <span class="input-group-text">%</span>
                </div>
                @error('target_percentage')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="type" class="form-label">Tipe Indikator</label>
                <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                    <option value="">Pilih Tipe</option>
                    <option value="nasional" {{ old('type', $indicator->type) == 'nasional' ? 'selected' : '' }}>Nasional</option>
                    <option value="lokal" {{ old('type', $indicator->type) == 'lokal' ? 'selected' : '' }}>Lokal</option>
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="reporting_start_day" class="form-label">Tanggal Mulai Periode</label>
                <input type="number" name="reporting_start_day" id="reporting_start_day"
                       class="form-input @error('reporting_start_day') is-invalid @enderror"
                       value="{{ old('reporting_start_day', $indicator->reporting_start_day) }}" min="1" max="31" required>
                @error('reporting_start_day')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="reporting_end_day" class="form-label">Tanggal Selesai Periode</label>
                <input type="number" name="reporting_end_day" id="reporting_end_day"
                       class="form-input @error('reporting_end_day') is-invalid @enderror"
                       value="{{ old('reporting_end_day', $indicator->reporting_end_day) }}" min="1" max="31" required>
                @error('reporting_end_day')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_period_active"
                           name="is_period_active" {{ old('is_period_active', $indicator->is_period_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_period_active">Aktifkan Periode</label>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="is_active"
                           name="is_active" {{ old('is_active', $indicator->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Status Aktif</label>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('master-indikator.index') }}" class="btn btn-outline">
                    <i class="ri-arrow-left-line"></i>
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

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
}

.section-body {
    padding: 1.5rem;
}

.header-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary-color);
    font-weight: 600;
}

.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #1a202c;
}

.form-input,
.form-select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px var(--primary-color);
}

.input-group {
    display: flex;
    align-items: center;
}

.input-group .form-input {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group-text {
    padding: 0.5rem 1rem;
    background: #f7fafc;
    border: 1px solid #e2e8f0;
    border-left: none;
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
    color: #4a5568;
}

.is-invalid {
    border-color: #e53e3e;
}

.invalid-feedback {
    color: #e53e3e;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.form-check {
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

.space-y-4 > * + * {
    margin-top: 1rem;
}

.space-x-2 > * + * {
    margin-left: 0.5rem;
}

.flex {
    display: flex;
}

.justify-end {
    justify-content: flex-end;
}
@endsection
@endsection
