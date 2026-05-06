<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'kode',
        'nama',
        'satuan',
        'stok'
    ];

    // relasi ke barang masuk
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    // relasi ke barang keluar
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}