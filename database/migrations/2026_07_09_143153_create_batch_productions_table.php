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
        Schema::create('batch_productions', function (Blueprint $table) {

            $table->id();

            // =========================
            // KODE BATCH
            // =========================
            $table->string('kode_batch')->unique();

            // =========================
            // PRODUK
            // =========================
            $table->foreignId('produk_id')
                ->constrained('produks')
                ->cascadeOnDelete();

            // =========================
            // QTY ORDER
            // =========================
            $table->integer('qty_order');

            // =========================
            // TANGGAL PRODUKSI
            // =========================
            $table->date('tanggal');

            // =========================
            // KETERANGAN
            // =========================
            $table->text('keterangan')
                ->nullable();

            // =========================
            // STATUS
            // =========================
            $table->enum('status', [

                'Draft',
                'Cutting',
                'Penjahitan',
                'Assembling',
                'Finishing',
                'Selesai'

            ])->default('Draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('batch_productions');
    }
};