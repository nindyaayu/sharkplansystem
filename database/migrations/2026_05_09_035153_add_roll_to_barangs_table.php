<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->integer('jumlah_roll')
                  ->default(0)
                  ->after('satuan');

            $table->decimal('jumlah_meter', 10, 2)
                  ->default(0)
                  ->after('jumlah_roll');

        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->dropColumn([
                'jumlah_roll',
                'jumlah_meter'
            ]);

        });
    }
};