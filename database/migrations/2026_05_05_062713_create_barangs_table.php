<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {

            $table->id();

            $table->string('kode');

            $table->string('nama');

            $table->enum('kategori', ['Kain', 'Aksesoris']);

            $table->string('warna')->nullable();

            $table->string('satuan');

            /*
            =========================
            MATERIAL UTAMA
            =========================
            */

            $table->integer('jumlah_roll')
                  ->default(0);

            $table->decimal('jumlah_meter', 10, 2)
                  ->default(0);

            /*
            =========================
            MATERIAL PENDUKUNG
            =========================
            */

            $table->integer('stok')
                  ->default(0);

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
};