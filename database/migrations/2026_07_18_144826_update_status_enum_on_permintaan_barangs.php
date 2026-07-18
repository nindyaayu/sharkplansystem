<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE permintaan_barangs
            MODIFY status ENUM(
                'Menunggu',
                'Disetujui',
                'Disetujui Sebagian',
                'Kosong',
                'Ditolak',
                'Sudah Diambil'
            ) NOT NULL DEFAULT 'Menunggu'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE permintaan_barangs
            MODIFY status ENUM(
                'Menunggu',
                'Disetujui',
                'Ditolak',
                'Sudah Diambil'
            ) NOT NULL DEFAULT 'Menunggu'
        ");
    }
};