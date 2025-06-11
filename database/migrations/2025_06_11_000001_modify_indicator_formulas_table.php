<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('indicator_formulas', function (Blueprint $table) {
            // Hapus kolom lama
            $table->dropColumn([
                'numerator_description',
                'denominator_description',
                'formula_expression'
            ]);

            // Tambah kolom baru
            $table->string('numerator_label')->after('name')
                  ->comment('Label untuk input pembilang');
            $table->enum('numerator_type', ['count', 'sum', 'boolean'])
                  ->default('count')
                  ->after('numerator_label')
                  ->comment('Tipe perhitungan pembilang');
            
            $table->string('denominator_label')->after('numerator_type')
                  ->comment('Label untuk input penyebut');
            $table->enum('denominator_type', ['count', 'sum', 'boolean'])
                  ->default('count')
                  ->after('denominator_label')
                  ->comment('Tipe perhitungan penyebut');
            
            $table->enum('calculation_type', ['percentage', 'ratio', 'average'])
                  ->default('percentage')
                  ->after('denominator_type')
                  ->comment('Tipe perhitungan akhir');
            $table->decimal('multiplier', 5, 2)
                  ->default(100)
                  ->after('calculation_type')
                  ->comment('Pengali hasil (default 100 untuk persentase)');
        });
    }

    public function down(): void
    {
        Schema::table('indicator_formulas', function (Blueprint $table) {
            // Kembalikan kolom lama
            $table->text('numerator_description')->comment('Deskripsi pembilang');
            $table->text('denominator_description')->comment('Deskripsi penyebut');
            $table->text('formula_expression')->comment('Ekspresi rumus');

            // Hapus kolom baru
            $table->dropColumn([
                'numerator_label',
                'numerator_type',
                'denominator_label',
                'denominator_type',
                'calculation_type',
                'multiplier'
            ]);
        });
    }
}; 