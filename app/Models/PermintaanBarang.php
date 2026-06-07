<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class PermintaanBarang extends Model
{
    protected $fillable = [
    'nomor_permintaan',
    'tanggal',
    'produk_id',
    'nama_peminta',
    'nama_penjahit',
    'status'
];

    public function details()
    {
        return $this->hasMany(
            DetailPermintaanBarang::class
        );
    }

    public function produk()
{
    return $this->belongsTo(
        Produk::class
    );
}

}