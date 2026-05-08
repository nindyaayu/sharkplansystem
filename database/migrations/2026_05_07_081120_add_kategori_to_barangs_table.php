<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('barangs', 'kategori')) {

            Schema::table('barangs', function (Blueprint $table) {

                $table->enum(
                    'kategori',
                    ['Kain', 'Aksesoris']
                )->after('nama');

            });

        }
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {

            $table->dropColumn('kategori');

        });
    }
};