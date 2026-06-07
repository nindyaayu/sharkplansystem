<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produk;

class BarangKeluar extends Model
{
    protected $fillable = [

    'barang_id',

    'permintaan_barang_id',

    'produk_id',

    'nama_peminta',

    'nama_penjahit',

    'jumlah',

    'jumlah_roll',

    'tanggal_keluar',

    'tujuan'

];

    // =========================
    // RELASI BARANG
    // =========================

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function produk()
    {
        return $this->belongsTo(
            Produk::class
        );
    }
}