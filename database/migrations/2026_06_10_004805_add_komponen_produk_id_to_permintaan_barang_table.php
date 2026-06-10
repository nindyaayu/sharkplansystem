<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('permintaan_barangs', function ($table) {

        $table->unsignedBigInteger(
            'komponen_produk_id'
        )->nullable();

    });
}

public function down(): void
{
    Schema::table('permintaan_barang', function ($table) {

        $table->dropColumn(
            'komponen_produk_id'
        );

    });
}
};
