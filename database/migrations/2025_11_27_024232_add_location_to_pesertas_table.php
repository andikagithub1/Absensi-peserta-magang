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
        Schema::table('pesertas', function (Blueprint $table) {
            $table->decimal('latitude_tempat_kerja', 10, 8)->nullable()->comment('Latitude tempat kerja/sekolah');
            $table->decimal('longitude_tempat_kerja', 11, 8)->nullable()->comment('Longitude tempat kerja/sekolah');
            $table->integer('radius_toleransi')->default(500)->comment('Radius toleransi dalam meter');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropColumn(['latitude_tempat_kerja', 'longitude_tempat_kerja', 'radius_toleransi']);
        });
    }
};
