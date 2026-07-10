<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_outs', function (Blueprint $table) {

            $table->string('cabang')
                ->nullable()
                ->after('catatan');

        });
    }

    public function down(): void
    {
        Schema::table('job_out', function (Blueprint $table) {

            $table->dropColumn('cabang');

        });
    }
};