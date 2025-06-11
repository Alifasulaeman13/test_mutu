@extends('layouts.app')

@section('title', 'Edit Formula')
@section('page-title', 'Edit Formula')

@section('content')
<x-sweet-alert />

<div class="dashboard-section">
    <div class="section-header">
        <div class="header-title">
            <i class="ri-edit-line"></i>
            Edit Formula
        </div>
    </div>
    
    <div class="section-body">
        <form action="{{ route('master-indikator.formula.update', $formula->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="indicator_id" class="form-label">Indikator</label>
                <select name="indicator_id" class="form-select @error('indicator_id') is-invalid @enderror" required>
                    <option value="">Pilih Indikator</option>
                    @foreach($indicators as $indicator)
                        <option value="{{ $indicator->id }}" {{ old('indicator_id', $formula->indicator_id) == $indicator->id ? 'selected' : '' }}>
                            {{ $indicator->name }}
                        </option>
                    @endforeach
                </select>
                @error('indicator_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="name" class="form-label">Nama Formula</label>
                <input type="text" name="name" class="form-input @error('name') is-invalid @enderror" 
                       value="{{ old('name', $formula->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Numerator Section -->
            <div class="form-group">
                <label class="form-label">Numerator (Pembilang)</label>
                <div class="input-help">
                    <i class="ri-information-line"></i>
                    <span>Pembilang adalah nilai yang akan dibagi (angka atas dalam pecahan)</span>
                </div>
                <input type="text" name="numerator_label" class="form-input @error('numerator_label') is-invalid @enderror" 
                       value="{{ old('numerator_label', $formula->numerator_label) }}"
                       placeholder="Contoh: Jumlah pasien yang sesuai standar" required>
                @error('numerator_label')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <label class="form-sublabel mt-3">Tipe Input Pembilang</label>
                <div class="input-help mb-2">
                    <i class="ri-information-line"></i>
                    <span>Pilih bagaimana cara menghitung pembilang</span>
                </div>
                <select name="numerator_type" class="form-select @error('numerator_type') is-invalid @enderror">
                    <option value="count" {{ old('numerator_type', $formula->numerator_type) == 'count' ? 'selected' : '' }}>
                        Hitung Jumlah (1, 2, 3, dst)
                    </option>
                    <option value="sum" {{ old('numerator_type', $formula->numerator_type) == 'sum' ? 'selected' : '' }}>
                        Total Nilai (bisa menggunakan desimal)
                    </option>
                    <option value="boolean" {{ old('numerator_type', $formula->numerator_type) == 'boolean' ? 'selected' : '' }}>
                        Ya/Tidak (untuk checklist)
                    </option>
                </select>
                <div class="input-help type-help mt-2">
                    <i class="ri-information-line"></i>
                    <span class="help-text count-help">Menghitung jumlah kejadian/item secara manual satu per satu</span>
                    <span class="help-text sum-help">Menjumlahkan nilai-nilai yang diinput (misal: total waktu dalam menit)</span>
                    <span class="help-text boolean-help">Untuk penilaian checklist dimana "Ya"=1 dan "Tidak"=0, sistem akan menjumlahkan total "Ya"</span>
                </div>
                @error('numerator_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Denominator Section -->
            <div class="form-group">
                <label class="form-label">Denominator (Penyebut)</label>
                <div class="input-help">
                    <i class="ri-information-line"></i>
                    <span>Penyebut adalah nilai pembagi (angka bawah dalam pecahan)</span>
                </div>
                <input type="text" name="denominator_label" class="form-input @error('denominator_label') is-invalid @enderror" 
                       value="{{ old('denominator_label', $formula->denominator_label) }}"
                       placeholder="Contoh: Total semua pasien" required>
                @error('denominator_label')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                <label class="form-sublabel mt-3">Tipe Input Penyebut</label>
                <div class="input-help mb-2">
                    <i class="ri-information-line"></i>
                    <span>Pilih bagaimana cara menghitung penyebut</span>
                </div>
                <select name="denominator_type" class="form-select @error('denominator_type') is-invalid @enderror">
                    <option value="count" {{ old('denominator_type', $formula->denominator_type) == 'count' ? 'selected' : '' }}>
                        Hitung Jumlah (1, 2, 3, dst)
                    </option>
                    <option value="sum" {{ old('denominator_type', $formula->denominator_type) == 'sum' ? 'selected' : '' }}>
                        Total Nilai (bisa menggunakan desimal)
                    </option>
                    <option value="boolean" {{ old('denominator_type', $formula->denominator_type) == 'boolean' ? 'selected' : '' }}>
                        Ya/Tidak (untuk checklist)
                    </option>
                </select>
                @error('denominator_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Calculation Settings -->
            <div class="form-group">
                <label class="form-label">Cara Hitung</label>
                <div class="input-help">
                    <i class="ri-information-line"></i>
                    <span>Pilih bagaimana hasil akhir akan dihitung</span>
                </div>
                <select name="calculation_type" class="form-select @error('calculation_type') is-invalid @enderror">
                    <option value="percentage" {{ old('calculation_type', $formula->calculation_type) == 'percentage' ? 'selected' : '' }}>
                        Persentase (hasil dalam bentuk %)
                    </option>
                    <option value="ratio" {{ old('calculation_type', $formula->calculation_type) == 'ratio' ? 'selected' : '' }}>
                        Rasio (pembilang dibagi penyebut)
                    </option>
                    <option value="average" {{ old('calculation_type', $formula->calculation_type) == 'average' ? 'selected' : '' }}>
                        Rata-rata (total dibagi jumlah)
                    </option>
                </select>
                @error('calculation_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror

                <x-formula-preview 
                    :initialType="old('calculation_type', $formula->calculation_type)"
                    :initialNumerator="old('numerator_label', $formula->numerator_label)"
                    :initialDenominator="old('denominator_label', $formula->denominator_label)"
                />
            </div>

            <div class="form-group calculation-multiplier">
                <label class="form-label">Pengali</label>
                <div class="input-help">
                    <i class="ri-information-line"></i>
                    <span>Nilai untuk mengalikan hasil akhir (biasanya 100 untuk persentase)</span>
                </div>
                <input type="number" name="multiplier" class="form-input @error('multiplier') is-invalid @enderror" 
                       value="{{ old('multiplier', $formula->multiplier) }}" min="0" max="100" step="0.01">
                @error('multiplier')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" name="is_active" class="form-check-input" value="1" 
                           {{ old('is_active', $formula->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label">Aktif</label>
                </div>
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('master-indikator.formula.index') }}" class="btn btn-outline">
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

.mt-2 {
    margin-top: 0.5rem;
}

.input-help {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.input-help i {
    color: #3b82f6;
    font-size: 1rem;
}

.form-sublabel {
    display: block;
    font-weight: 500;
    color: #1a202c;
    font-size: 0.875rem;
}

.mb-2 {
    margin-bottom: 0.5rem;
}

.mt-3 {
    margin-top: 0.75rem;
}

.calculation-multiplier {
    display: none;
}

[name="calculation_type"]:has(option[value="percentage"]:checked) ~ .calculation-multiplier {
    display: block;
}

.formula-preview {
    margin-top: 1rem;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
}

.formula-box {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 80px;
    padding: 1rem;
    background: #f8fafc;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    margin-top: 0.5rem;
}

.formula {
    display: none;
    align-items: center;
    gap: 0.5rem;
}

.formula.show {
    display: flex;
}

.fraction {
    display: inline-flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    margin: 0 0.25rem;
}

.numerator, .denominator {
    padding: 0.25rem 0.5rem;
}

.fraction-line {
    width: 100%;
    height: 2px;
    background: #000;
    min-width: 60px;
}

.operator {
    margin: 0 0.5rem;
    font-weight: bold;
}

.multiplier {
    font-weight: bold;
}

.sigma {
    font-size: 2rem;
    margin-right: 0.5rem;
}

.type-help {
    margin-top: 0.5rem;
}

.help-text {
    display: none;
    font-size: 0.875rem;
    color: #64748b;
}

select[name="numerator_type"] option[value="count"]:checked ~ .type-help .count-help,
select[name="denominator_type"] option[value="count"]:checked ~ .type-help .count-help {
    display: inline;
}

select[name="numerator_type"] option[value="sum"]:checked ~ .type-help .sum-help,
select[name="denominator_type"] option[value="sum"]:checked ~ .type-help .sum-help {
    display: inline;
}

select[name="numerator_type"] option[value="boolean"]:checked ~ .type-help .boolean-help,
select[name="denominator_type"] option[value="boolean"]:checked ~ .type-help .boolean-help {
    display: inline;
}
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const calculationType = document.querySelector('[name="calculation_type"]');
    const multiplierGroup = document.querySelector('.calculation-multiplier');
    const numeratorType = document.querySelector('[name="numerator_type"]');
    const denominatorType = document.querySelector('[name="denominator_type"]');

    // Toggle multiplier visibility based on calculation type
    function toggleMultiplier() {
        multiplierGroup.style.display = calculationType.value === 'percentage' ? 'block' : 'none';
    }

    calculationType.addEventListener('change', toggleMultiplier);

    // Fungsi untuk update help text
    function updateHelpText(selectElement) {
        const helpTexts = selectElement.closest('.form-group').querySelectorAll('.help-text');
        helpTexts.forEach(text => text.style.display = 'none');
        
        const selectedValue = selectElement.value;
        const selectedHelp = selectElement.closest('.form-group').querySelector(`.${selectedValue}-help`);
        if (selectedHelp) {
            selectedHelp.style.display = 'inline';
        }
    }

    // Event listeners untuk tipe input
    numeratorType.addEventListener('change', () => updateHelpText(numeratorType));
    denominatorType.addEventListener('change', () => updateHelpText(denominatorType));

    // Show initial states
    toggleMultiplier();
    updateHelpText(numeratorType);
    updateHelpText(denominatorType);
});
</script>
@endsection
