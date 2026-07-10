<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_barangs', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('barang_keluars', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });

        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->string('cabang')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('permintaan_barangs', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });

        Schema::table('barang_keluars', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });

        Schema::table('barang_masuks', function (Blueprint $table) {
            $table->dropColumn('cabang');
        });
    }
};