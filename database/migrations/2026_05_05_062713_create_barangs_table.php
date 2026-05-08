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

            // TAMBAHAN
            $table->enum('kategori', ['Kain', 'Aksesoris']);

            $table->string('satuan');

            $table->integer('stok')->default(0);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('barangs');
    }
};