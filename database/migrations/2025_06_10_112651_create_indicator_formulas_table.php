<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('indicator_formulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id')->constrained('indicators')->comment('Indikator terkait');
            $table->string('name')->comment('Nama rumus perhitungan');
            $table->text('numerator_description')->comment('Deskripsi pembilang');
            $table->text('denominator_description')->comment('Deskripsi penyebut');
            $table->text('formula_expression')->comment('Ekspresi rumus (contoh: numerator / denominator * 100)');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicator_formulas');
    }
};
