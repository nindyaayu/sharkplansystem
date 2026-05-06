<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [

        'kode',

        'nama',

        'warna',

        'satuan',

        'stok',

        // TAMBAHAN BARU
        'isi_per_satuan',

        'satuan_konversi'

    ];

    // =========================
    // RELASI BARANG MASUK
    // =========================
    public function barangMasuk()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    // =========================
    // RELASI BARANG KELUAR
    // =========================
    public function barangKeluar()
    {
        return $this->hasMany(BarangKeluar::class);
    }
}