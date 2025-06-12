@extends('layouts.app')

@section('title', 'Tambah Data Indikator')
@section('page-title', 'Tambah Data Indikator')

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

.section-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #1e293b;
}

.form-input,
.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
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

.is-invalid {
    border-color: #dc2626;
}

.invalid-feedback {
    color: #dc2626;
    font-size: 0.75rem;
    margin-top: 0.25rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
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

.flex {
    display: flex;
}

.justify-end {
    justify-content: flex-end;
}

.space-x-2 > * + * {
    margin-left: 0.5rem;
}
@endsection

@section('content')
<div class="dashboard-section">
    <div class="section-header">
        <div class="header-title">
            <i class="ri-add-line"></i>
            Tambah Data Indikator
        </div>
    </div>
    
    <div class="section-body">
        <form action="{{ route('laporan-analisis.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="indicator_id" class="form-label">Indikator</label>
                <select name="indicator_id" id="indicator_id" class="form-select @error('indicator_id') is-invalid @enderror" required>
                    <option value="">Pilih Indikator</option>
                    @foreach($indicators as $indicator)
                        <option value="{{ $indicator->id }}" {{ old('indicator_id') == $indicator->id ? 'selected' : '' }}>
                            {{ $indicator->name }} ({{ $indicator->unit->name }})
                        </option>
                    @endforeach
                </select>
                @error('indicator_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" id="date" class="form-input @error('date') is-invalid @enderror"
                    value="{{ old('date', date('Y-m-d')) }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="numerator" class="form-label">Numerator</label>
                <input type="number" name="numerator" id="numerator" class="form-input @error('numerator') is-invalid @enderror"
                    value="{{ old('numerator') }}" min="0" required>
                @error('numerator')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="denominator" class="form-label">Denominator</label>
                <input type="number" name="denominator" id="denominator" class="form-input @error('denominator') is-invalid @enderror"
                    value="{{ old('denominator') }}" min="1" required>
                @error('denominator')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('laporan-analisis.index') }}" class="btn btn-outline">
                    <i class="ri-arrow-left-line"></i>
                    Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="ri-save-line"></i>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 