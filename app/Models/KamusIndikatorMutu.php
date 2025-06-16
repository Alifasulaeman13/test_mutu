<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KamusIndikatorMutu extends Model
{
    use HasFactory;
    protected $table = 'kamus_indikator_mutu';
    protected $fillable = [
        'indikator_id',
        'definisi_operasional',
        'tujuan',
        'dimensi_mutu_id',
        'dasar_pemikiran',
        'formula_pengukuran',
        'metodologi_pengumpulan_data',
        'metodologi_pengumpulan_data_id',
        'cakupan_data_id',
        'pengumpulan_data',
        'frekuensi_pengumpulan_data_id',
        'frekuensi_analisa_data_id',
        'metodologi_analisa_data_id',
        'interpretasi_data_id',
        'sumber_data',
        'penanggung_jawab_pengumpul_data',
        'publikasi_data_id',
    ];

    // Relasi dengan model Indicator
    public function indicator()
    {
        return $this->belongsTo(Indicator::class, 'indikator_id');
    }

    public function dimensiMutu() { return $this->belongsTo(DimensiMutu::class, 'dimensi_mutu_id'); }
    public function metodologiPengumpulan() { return $this->belongsTo(MetodologiPengumpulanData::class, 'metodologi_pengumpulan_data_id'); }
    public function cakupanData() { return $this->belongsTo(CakupanData::class, 'cakupan_data_id'); }
    public function frekuensiPengumpulan() { return $this->belongsTo(FrekuensiPengumpulanData::class, 'frekuensi_pengumpulan_data_id'); }
    public function frekuensiAnalisa() { return $this->belongsTo(FrekuensiAnalisaData::class, 'frekuensi_analisa_data_id'); }
    public function metodologiAnalisa() { return $this->belongsTo(MetodologiAnalisaData::class, 'metodologi_analisa_data_id'); }
    public function interpretasiData() { return $this->belongsTo(InterpretasiData::class, 'interpretasi_data_id'); }
    public function publikasiData() { return $this->belongsTo(PublikasiData::class, 'publikasi_data_id'); }
}
