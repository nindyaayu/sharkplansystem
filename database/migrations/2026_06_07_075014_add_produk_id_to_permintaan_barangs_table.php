<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permintaan_barangs', function (Blueprint $table) {

            $table->unsignedBigInteger('produk_id')
                  ->nullable()
                  ->after('tanggal');

        });
    }

    public function down(): void
    {
        Schema::table('permintaan_barangs', function (Blueprint $table) {

            $table->dropColumn('produk_id');

        });
    }
};