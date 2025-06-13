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
        Schema::create('monthly_indicator_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id')->constrained('indicators')->comment('Indikator yang diukur');
            $table->date('date')->comment('Tanggal pengukuran');
            $table->integer('numerator')->default(0)->comment('Pembilang');
            $table->integer('denominator')->default(0)->comment('Penyebut');
            $table->decimal('achievement_percentage', 5, 2)->nullable()->comment('Persentase pencapaian');
            $table->timestamps();
            
            // Generated columns for easy querying
            $table->integer('month')->storedAs('MONTH(date)');
            $table->integer('year')->storedAs('YEAR(date)');
            
            // Unique constraint to prevent duplicate entries
            $table->unique(['indicator_id', 'date'], 'unique_daily_measurement');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_indicator_data');
    }
};
