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
    color: #1e293b;
    background-color: white;
}

.form-input:focus,
.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px var(--primary-color);
}

.form-select option {
    color: #1e293b;
    background-color: white;
    padding: 0.5rem;
}

.form-select option:first-child {
    color: #64748b;
}

.form-select optgroup {
    font-weight: 600;
    color: #1e293b;
    background-color: #f8fafc;
}

.form-select optgroup option {
    color: #1e293b;
    background-color: white;
    padding: 0.5rem;
}

/* Style untuk memastikan warna teks tetap hitam saat dropdown dibuka */
.form-select:focus option,
.form-select:focus optgroup,
.form-select:focus optgroup option {
    color: #1e293b;
    background-color: white;
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
        <form action="{{ route('kamus-indikator.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="indikator_id" class="form-label">Indikator</label>
                <select name="indikator_id" id="indikator_id" class="form-select @error('indikator_id') is-invalid @enderror" required>
                    <option value="">Pilih Indikator</option>
                    @foreach($indicators as $indicator)
                        <option value="{{ $indicator->id }}" {{ old('indikator_id') == $indicator->id ? 'selected' : '' }}>
                            {{ $indicator->name }}
                        </option>
                    @endforeach
                </select>
                @error('indikator_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="definisi_operasional" class="form-label">Definisi Operasional</label>
                <textarea name="definisi_operasional" id="definisi_operasional" class="form-input @error('definisi_operasional') is-invalid @enderror"
                    rows="4" required>{{ old('definisi_operasional') }}</textarea>
                @error('definisi_operasional')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="tujuan" class="form-label">Tujuan</label>
                <textarea name="tujuan" id="tujuan" class="form-input @error('tujuan') is-invalid @enderror"
                    rows="4" required>{{ old('tujuan') }}</textarea>
                @error('tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dimensi_mutu_id" class="form-label">Dimensi Mutu</label>
                <select name="dimensi_mutu_id" id="dimensi_mutu_id" class="form-select @error('dimensi_mutu_id') is-invalid @enderror" required>
                    <option value="">Pilih Dimensi Mutu</option>
                    @foreach($dimensiMutu as $dimensi)
                        <option value="{{ $dimensi->id }}" {{ old('dimensi_mutu_id') == $dimensi->id ? 'selected' : '' }}>
                            {{ $dimensi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('dimensi_mutu_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dasar_pemikiran" class="form-label">Dasar Pemikiran</label>
                <textarea name="dasar_pemikiran" id="dasar_pemikiran" class="form-input @error('dasar_pemikiran') is-invalid @enderror"
                    rows="4" required>{{ old('dasar_pemikiran') }}</textarea>
                @error('dasar_pemikiran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="formula_pengukuran" class="form-label">Formula Pengukuran</label>
                <textarea name="formula_pengukuran" id="formula_pengukuran" class="form-input @error('formula_pengukuran') is-invalid @enderror"
                    rows="4" required>{{ old('formula_pengukuran') }}</textarea>
                @error('formula_pengukuran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="metodologi_pengumpulan_data" class="form-label">Metodologi Pengumpulan Data</label>
                <textarea name="metodologi_pengumpulan_data" id="metodologi_pengumpulan_data" class="form-input @error('metodologi_pengumpulan_data') is-invalid @enderror"
                    rows="4" required>{{ old('metodologi_pengumpulan_data') }}</textarea>
                @error('metodologi_pengumpulan_data')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="metodologi_pengumpulan_data_id" class="form-label">Jenis Metodologi Pengumpulan Data</label>
                <select name="metodologi_pengumpulan_data_id" id="metodologi_pengumpulan_data_id" class="form-select @error('metodologi_pengumpulan_data_id') is-invalid @enderror" required>
                    <option value="">Pilih Metodologi Pengumpulan Data</option>
                    @foreach($metodologiPengumpulan as $metodologi)
                        <option value="{{ $metodologi->id }}" {{ old('metodologi_pengumpulan_data_id') == $metodologi->id ? 'selected' : '' }}>
                            {{ $metodologi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('metodologi_pengumpulan_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cakupan_data_id" class="form-label">Cakupan Data</label>
                <select name="cakupan_data_id" id="cakupan_data_id" class="form-select @error('cakupan_data_id') is-invalid @enderror" required>
                    <option value="">Pilih Cakupan Data</option>
                    @foreach($cakupanData as $cakupan)
                        <option value="{{ $cakupan->id }}" {{ old('cakupan_data_id') == $cakupan->id ? 'selected' : '' }}>
                            {{ $cakupan->nama }}
                        </option>
                    @endforeach
                </select>
                @error('cakupan_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="pengumpulan_data" class="form-label">Pengumpulan Data</label>
                <textarea name="pengumpulan_data" id="pengumpulan_data" class="form-input @error('pengumpulan_data') is-invalid @enderror"
                    rows="4" required>{{ old('pengumpulan_data') }}</textarea>
                @error('pengumpulan_data')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="frekuensi_pengumpulan_data_id" class="form-label">Frekuensi Pengumpulan Data</label>
                <select name="frekuensi_pengumpulan_data_id" id="frekuensi_pengumpulan_data_id" class="form-select @error('frekuensi_pengumpulan_data_id') is-invalid @enderror" required>
                    <option value="">Pilih Frekuensi Pengumpulan Data</option>
                    @foreach($frekuensiPengumpulan as $frekuensi)
                        <option value="{{ $frekuensi->id }}" {{ old('frekuensi_pengumpulan_data_id') == $frekuensi->id ? 'selected' : '' }}>
                            {{ $frekuensi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('frekuensi_pengumpulan_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="frekuensi_analisa_data_id" class="form-label">Frekuensi Analisa Data</label>
                <select name="frekuensi_analisa_data_id" id="frekuensi_analisa_data_id" class="form-select @error('frekuensi_analisa_data_id') is-invalid @enderror" required>
                    <option value="">Pilih Frekuensi Analisa Data</option>
                    @foreach($frekuensiAnalisa as $frekuensi)
                        <option value="{{ $frekuensi->id }}" {{ old('frekuensi_analisa_data_id') == $frekuensi->id ? 'selected' : '' }}>
                            {{ $frekuensi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('frekuensi_analisa_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="metodologi_analisa_data_id" class="form-label">Metodologi Analisa Data</label>
                <select name="metodologi_analisa_data_id" id="metodologi_analisa_data_id" class="form-select @error('metodologi_analisa_data_id') is-invalid @enderror" required>
                    <option value="">Pilih Metodologi Analisa Data</option>
                    @foreach($metodologiAnalisa as $metodologi)
                        <option value="{{ $metodologi->id }}" {{ old('metodologi_analisa_data_id') == $metodologi->id ? 'selected' : '' }}>
                            {{ $metodologi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('metodologi_analisa_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="interpretasi_data_id" class="form-label">Interpretasi Data</label>
                <select name="interpretasi_data_id" id="interpretasi_data_id" class="form-select @error('interpretasi_data_id') is-invalid @enderror" required>
                    <option value="">Pilih Interpretasi Data</option>
                    @foreach($interpretasiData as $interpretasi)
                        <option value="{{ $interpretasi->id }}" {{ old('interpretasi_data_id') == $interpretasi->id ? 'selected' : '' }}>
                            {{ $interpretasi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('interpretasi_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="sumber_data" class="form-label">Sumber Data</label>
                <textarea name="sumber_data" id="sumber_data" class="form-input @error('sumber_data') is-invalid @enderror"
                    rows="4" required>{{ old('sumber_data') }}</textarea>
                @error('sumber_data')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="penanggung_jawab_pengumpul_data" class="form-label">Penanggung Jawab Pengumpul Data</label>
                <textarea name="penanggung_jawab_pengumpul_data" id="penanggung_jawab_pengumpul_data" class="form-input @error('penanggung_jawab_pengumpul_data') is-invalid @enderror"
                    rows="4" required>{{ old('penanggung_jawab_pengumpul_data') }}</textarea>
                @error('penanggung_jawab_pengumpul_data')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="publikasi_data_id" class="form-label">Publikasi Data</label>
                <select name="publikasi_data_id" id="publikasi_data_id" class="form-select @error('publikasi_data_id') is-invalid @enderror" required>
                    <option value="">Pilih Publikasi Data</option>
                    @foreach($publikasiData as $publikasi)
                        <option value="{{ $publikasi->id }}" {{ old('publikasi_data_id') == $publikasi->id ? 'selected' : '' }}>
                            {{ $publikasi->nama }}
                        </option>
                    @endforeach
                </select>
                @error('publikasi_data_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('kamus-indikator.index') }}" class="btn btn-outline">
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

<style>
.form-select {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s;
    color: #1e293b;
    background-color: white;
}

.form-select:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px var(--primary-color);
}

.form-input {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid #e2e8f0;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    transition: all 0.2s;
    color: #1e293b;
    background-color: white;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 1px var(--primary-color);
}
</style>
@endsection
