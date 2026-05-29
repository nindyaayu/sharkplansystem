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
       Schema::create(
        'detail_permintaan_barangs',
        function (Blueprint $table) {

            $table->id();

            $table->foreignId(
                'permintaan_barang_id'
            );

            $table->foreignId(
                'barang_id'
            );

            $table->decimal(
                'jumlah',
                15,
                2
            );

            $table->timestamps();

        }
    );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_permintaan_barangs');
    }
};
