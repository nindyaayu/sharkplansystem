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
        Schema::create('detail_hasil_cuttings', function (Blueprint $table) {

            $table->id();

            // =========================
            // HASIL CUTTING
            // =========================
            $table->foreignId('hasil_cutting_id')
                ->constrained('hasil_cuttings')
                ->cascadeOnDelete();

            // =========================
            // KOMPONEN
            // =========================
            $table->foreignId('komponen_produk_id')
                ->constrained('komponen_produks')
                ->cascadeOnDelete();

            // =========================
            // HASIL POTONG
            // =========================
            $table->integer('qty_hasil');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_hasil_cuttings');
    }
};