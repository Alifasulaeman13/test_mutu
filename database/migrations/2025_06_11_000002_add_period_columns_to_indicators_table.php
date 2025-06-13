<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->integer('reporting_start_day')->default(1)->comment('Tanggal mulai pelaporan (1-31)');
            $table->integer('reporting_end_day')->default(10)->comment('Tanggal selesai pelaporan (1-31)');
            $table->boolean('is_period_active')->default(true)->comment('Status aktif periode pengisian');
        });
    }

    public function down()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->dropColumn(['reporting_start_day', 'reporting_end_day', 'is_period_active']);
        });
    }
}; 