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

@endsection
