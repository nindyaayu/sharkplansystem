<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [

        'kode',

        'nama',

        'kategori',

        'cabang',

        'warna',

        'satuan',

        'stok',

        'tanggal',

        'isi_per_satuan',

        'satuan_konversi',

        // =========================
        // MATERIAL UTAMA
        // =========================

        'jumlah_roll',

        'jumlah_meter'

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