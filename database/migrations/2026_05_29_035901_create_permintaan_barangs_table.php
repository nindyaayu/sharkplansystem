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
        Schema::create('permintaan_barangs', function (Blueprint $table) {

            $table->id();

            $table->string('nomor_permintaan')->unique();

            $table->date('tanggal');

            $table->string('nama_peminta');

            $table->string('nama_penjahit');

            $table->enum(
                'status',
                [
                    'Menunggu',
                    'Disetujui',
                    'Ditolak',
                    'Sudah Diambil'
                ]
            )->default('Menunggu');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_barangs');
    }
};
