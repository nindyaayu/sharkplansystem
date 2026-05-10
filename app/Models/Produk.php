<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [

        'kode',

        'nama',

        'satuan',

        // =========================
        // TAMBAHAN PRODUK
        // =========================

        'client',

        'no_po',

        'qty_order',

        'qty_kirim',

        'tahap',

        'status'

    ];
}