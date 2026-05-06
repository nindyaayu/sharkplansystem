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
    Schema::create('boms', function (Blueprint $table) {
        $table->id();

        // relasi ke produk
        $table->foreignId('produk_id')->constrained()->cascadeOnDelete();

        // tanggal BOM
        $table->date('tanggal');

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boms');
    }
};
