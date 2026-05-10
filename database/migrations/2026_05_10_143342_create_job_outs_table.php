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
        Schema::create('job_outs', function (Blueprint $table) {

            $table->id();

            // =========================
            // SURAT JALAN
            // =========================

            $table->string('no_surat')->unique();

            // =========================
            // RELASI PRODUK
            // =========================

            $table->foreignId('produk_id')
                ->constrained('produks')
                ->onDelete('cascade');

            // =========================
            // INFO JOB OUT
            // =========================

            $table->string('vendor');

            $table->string('ekspedisi')
                ->nullable();

            $table->date('tanggal');

            $table->string('status')
                ->default('Dikirim');

            $table->text('catatan')
                ->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_outs');
    }
};