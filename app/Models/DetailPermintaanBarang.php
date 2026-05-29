<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPermintaanBarang extends Model
{
    protected $fillable = [
        'permintaan_barang_id',
        'barang_id',
        'jumlah'
    ];

    public function permintaan()
    {
        return $this->belongsTo(
            PermintaanBarang::class
        );
    }

    public function barang()
    {
        return $this->belongsTo(
            Barang::class
        );
    }
}