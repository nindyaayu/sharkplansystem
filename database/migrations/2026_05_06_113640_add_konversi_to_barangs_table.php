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
        Schema::table('barangs', function (Blueprint $table) {

            // isi per satuan
            // contoh:
            // 1 roll = 25 meter
            $table->double('isi_per_satuan')
                ->nullable()
                ->after('satuan');

            // satuan konversi
            // contoh:
            // meter / cm
            $table->string('satuan_konversi')
                ->nullable()
                ->after('isi_per_satuan');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->dropColumn([
                'isi_per_satuan',
                'satuan_konversi'
            ]);

        });
    }
};