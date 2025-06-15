<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('dimensi_mutu', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('metodologi_pengumpulan_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('cakupan_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('frekuensi_pengumpulan_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('frekuensi_analisa_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('metodologi_analisa_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('interpretasi_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('publikasi_data', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->timestamps();
        });
        Schema::create('kamus_indikator_mutu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('indikator_id');
            $table->text('definisi_operasional');
            $table->text('tujuan');
            $table->unsignedBigInteger('dimensi_mutu_id');
            $table->text('dasar_pemikiran');
            $table->text('formula_pengukuran');
            $table->text('metodologi_pengumpulan_data');
            $table->unsignedBigInteger('metodologi_pengumpulan_data_id');
            $table->unsignedBigInteger('cakupan_data_id');
            $table->text('pengumpulan_data');
            $table->unsignedBigInteger('frekuensi_pengumpulan_data_id');
            $table->unsignedBigInteger('frekuensi_analisa_data_id');
            $table->unsignedBigInteger('metodologi_analisa_data_id');
            $table->unsignedBigInteger('interpretasi_data_id');
            $table->text('sumber_data');
            $table->string('penanggung_jawab_pengumpul_data');
            $table->unsignedBigInteger('publikasi_data_id');
            $table->timestamps();

            $table->foreign('indikator_id')->references('id')->on('indicators')->onDelete('cascade');
            $table->foreign('dimensi_mutu_id')->references('id')->on('dimensi_mutu');
            $table->foreign('metodologi_pengumpulan_data_id')->references('id')->on('metodologi_pengumpulan_data');
            $table->foreign('cakupan_data_id')->references('id')->on('cakupan_data');
            $table->foreign('frekuensi_pengumpulan_data_id')->references('id')->on('frekuensi_pengumpulan_data');
            $table->foreign('frekuensi_analisa_data_id')->references('id')->on('frekuensi_analisa_data');
            $table->foreign('metodologi_analisa_data_id')->references('id')->on('metodologi_analisa_data');
            $table->foreign('interpretasi_data_id')->references('id')->on('interpretasi_data');
            $table->foreign('publikasi_data_id')->references('id')->on('publikasi_data');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamus_indikator_mutu');
        Schema::dropIfExists('dimensi_mutu');
        Schema::dropIfExists('metodologi_pengumpulan_data');
        Schema::dropIfExists('cakupan_data');
        Schema::dropIfExists('frekuensi_pengumpulan_data');
        Schema::dropIfExists('frekuensi_analisa_data');
        Schema::dropIfExists('metodologi_analisa_data');
        Schema::dropIfExists('interpretasi_data');
        Schema::dropIfExists('publikasi_data');
    }
}; 