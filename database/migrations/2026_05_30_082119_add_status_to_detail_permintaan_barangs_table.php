<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table(
            'detail_permintaan_barangs',
            function (Blueprint $table) {

                $table->enum(
                    'status',
                    [
                        'Kosong',
                        'ACC',
                        'Ditolak'
                    ]
                )
                ->default('Kosong')
                ->after('jumlah');

            }
        );
    }

    public function down(): void
    {
        Schema::table(
            'detail_permintaan_barangs',
            function (Blueprint $table) {

                $table->dropColumn('status');

            }
        );
    }
};