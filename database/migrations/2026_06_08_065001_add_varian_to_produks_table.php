<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('produks', function ($table) {
        $table->string('varian')->nullable();
    });
}

public function down()
{
    Schema::table('produks', function ($table) {
        $table->dropColumn('varian');
    });
}
};
