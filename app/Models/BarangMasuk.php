<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    protected $fillable = [

        'barang_id',

        'jumlah',

        'jumlah_roll',

        'tanggal_masuk',

        'supplier',

        // TAMBAHAN
        'asal',
        
        'cabang'

    ];

    // =========================
    // RELASI BARANG
    // =========================

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}