<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    protected $fillable = [

        'produk_id',

        // TAMBAHAN
        'mode_produksi',

        'nama_komponen',

        'qty_produksi',

        'tanggal',

        'jenis_produksi',

        'pelaksana',

        'status'

    ];

    // =========================
    // RELASI PRODUK
    // =========================
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}