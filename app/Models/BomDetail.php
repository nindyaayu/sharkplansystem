<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomDetail extends Model
{
    protected $fillable = [

        'bom_id',

        'barang_id',

        'qty',

        // TAMBAHAN BARU
        'satuan_pakai'

    ];

    // =========================
    // RELASI KE BOM
    // =========================
    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    // =========================
    // RELASI KE BARANG
    // =========================
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}