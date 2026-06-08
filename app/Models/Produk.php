<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PermintaanBarang;

class Produk extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'varian',
        'satuan'
    ];

    public function permintaanBarangs()
    {
        return $this->hasMany(
            PermintaanBarang::class
        );
    }

public function komponen()
{
    return $this->hasMany(
        KomponenProduk::class
    );
}

}