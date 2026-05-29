<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanBarang extends Model
{
    protected $fillable = [
        'nomor_permintaan',
        'tanggal',
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
}