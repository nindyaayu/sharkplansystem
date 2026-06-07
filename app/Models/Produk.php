<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PermintaanBarang;

class Produk extends Model
{
    protected $fillable = [

        'kode',

        'nama',

        'satuan',

        'client',

        'no_po',

        'qty_order',

        'qty_kirim',

        'tahap',

        'status'

    ];

    public function permintaanBarangs()
    {
        return $this->hasMany(
            PermintaanBarang::class
        );
    }
}