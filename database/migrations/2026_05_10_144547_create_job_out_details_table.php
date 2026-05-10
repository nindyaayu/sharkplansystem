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
        Schema::create('job_out_details', function (Blueprint $table) {

            $table->id();

            // =========================
            // RELASI JOB OUT
            // =========================

            $table->foreignId('job_out_id')
                ->constrained('job_outs')
                ->onDelete('cascade');

            // =========================
            // RELASI BARANG
            // =========================

            $table->foreignId('barang_id')
                ->constrained('barangs')
                ->onDelete('cascade');

            // =========================
            // DETAIL KIRIM
            // =========================

            $table->double('qty');

            $table->string('satuan');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_out_details');
    }
};