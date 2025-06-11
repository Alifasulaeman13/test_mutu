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
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units')->comment('Unit terkait');
            $table->text('name')->comment('Nama indikator mutu');
            $table->decimal('target_percentage', 5, 2)->comment('Target pencapaian dalam persentase');
            $table->enum('type', ['nasional', 'lokal'])->default('lokal')->comment('Tipe indikator');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
