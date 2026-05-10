<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    protected $fillable = [

        'barang_id',

        'jumlah',

        'jumlah_roll',

        'tanggal_keluar',

        'tujuan'

    ];

    // =========================
    // RELASI BARANG
    // =========================

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}