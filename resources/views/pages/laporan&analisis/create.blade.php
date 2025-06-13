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

.form-select optgroup {
    font-weight: 600;
    color: #1e293b;
    background-color: #f8fafc;
}

.form-select option {
    font-weight: normal;
    color: #475569;
    background-color: white;
    padding: 0.5rem;
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
                @if($isAdmin && $groupedIndicators)
                    <select name="indicator_id" id="indicator_id" class="form-select @error('indicator_id') is-invalid @enderror" required>
                        <option value="">Pilih Indikator</option>
                        @foreach($groupedIndicators as $unitName => $unitIndicators)
                            <optgroup label="{{ $unitName }}">
                                @foreach($unitIndicators as $indicator)
                                    <option value="{{ $indicator->id }}" {{ (old('indicator_id', $selectedIndicatorId) == $indicator->id) ? 'selected' : '' }}>
                                        {{ $indicator->name }}
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                @else
                    <select name="indicator_id" id="indicator_id" class="form-select @error('indicator_id') is-invalid @enderror" required>
                        <option value="">Pilih Indikator</option>
                        @foreach($indicators as $indicator)
                            <option value="{{ $indicator->id }}" {{ (old('indicator_id', $selectedIndicatorId) == $indicator->id) ? 'selected' : '' }}>
                                {{ $indicator->name }}
                            </option>
                        @endforeach
                    </select>
                @endif
                @error('indicator_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="month" class="form-label">Bulan</label>
                <select name="month" id="month" class="form-select @error('month') is-invalid @enderror" required readonly>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{ date('n') == $month ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                        </option>
                    @endforeach
                </select>
                @error('month')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="year" class="form-label">Tahun</label>
                <select name="year" id="year" class="form-select @error('year') is-invalid @enderror" required readonly>
                    @foreach(range(date('Y')-5, date('Y')+5) as $year)
                        <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                @error('year')
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Disable bulan dan tahun secara visual tapi tetap mengirim value
    const monthSelect = document.getElementById('month');
    const yearSelect = document.getElementById('year');
    
    monthSelect.style.backgroundColor = '#f1f5f9';
    yearSelect.style.backgroundColor = '#f1f5f9';
    
    monthSelect.style.cursor = 'not-allowed';
    yearSelect.style.cursor = 'not-allowed';
    
    // Prevent manual changes
    monthSelect.addEventListener('mousedown', function(e) {
        e.preventDefault();
    });
    
    yearSelect.addEventListener('mousedown', function(e) {
        e.preventDefault();
    });
});
</script>
@endsection 