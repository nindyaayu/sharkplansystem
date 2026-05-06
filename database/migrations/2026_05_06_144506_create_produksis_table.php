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
        Schema::create('produksis', function (Blueprint $table) {

            $table->id();

            $table->foreignId('produk_id')
                ->constrained('produks')
                ->onDelete('cascade');

            $table->integer('qty_produksi');

            $table->date('tanggal');

            $table->string('jenis_produksi');

            $table->string('pelaksana');

            $table->string('status')
                ->default('Draft');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksis');
    }
};