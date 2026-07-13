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
        Schema::create('hasil_cuttings', function (Blueprint $table) {

            $table->id();

            // =========================
            // NOMOR CUTTING
            // =========================
            $table->string('nomor_cutting')->unique();

            // =========================
            // BATCH PRODUKSI
            // =========================
            $table->foreignId('batch_production_id')
                ->constrained('batch_productions')
                ->cascadeOnDelete();

            // =========================
            // TANGGAL
            // =========================
            $table->date('tanggal');

            // =========================
            // OPERATOR CUTTING
            // =========================
            $table->string('operator');

            // =========================
            // KETERANGAN
            // =========================
            $table->text('keterangan')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_cuttings');
    }
};