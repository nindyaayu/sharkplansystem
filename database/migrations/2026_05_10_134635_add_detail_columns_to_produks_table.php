<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {

            $table->string('client')->nullable();

            $table->string('no_po')->nullable();

            $table->integer('qty_order')->default(0);

            $table->integer('qty_kirim')->default(0);

            $table->string('tahap')->nullable();

            $table->string('status')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {

            $table->dropColumn([
                'client',
                'no_po',
                'qty_order',
                'qty_kirim',
                'tahap',
                'status'
            ]);

        });
    }
};