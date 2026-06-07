<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {

            $table->unsignedBigInteger('permintaan_barang_id')
                  ->nullable()
                  ->after('barang_id');

            $table->unsignedBigInteger('produk_id')
                  ->nullable()
                  ->after('permintaan_barang_id');

            $table->string('nama_peminta')
                  ->nullable()
                  ->after('produk_id');

            $table->string('nama_penjahit')
                  ->nullable()
                  ->after('nama_peminta');

        });
    }

    public function down(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {

            $table->dropColumn([
                'permintaan_barang_id',
                'produk_id',
                'nama_peminta',
                'nama_penjahit'
            ]);

        });
    }
};