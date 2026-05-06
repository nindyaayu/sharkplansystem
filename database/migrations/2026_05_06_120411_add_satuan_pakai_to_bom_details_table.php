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
        Schema::table('bom_details', function (Blueprint $table) {

            // satuan pemakaian produksi
            // contoh:
            // CM / METER / PCS
            $table->string('satuan_pakai')
                ->nullable()
                ->after('qty');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bom_details', function (Blueprint $table) {

            $table->dropColumn('satuan_pakai');

        });
    }
};