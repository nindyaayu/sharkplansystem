<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    // ===== FIELD YANG BOLEH DISIMPAN =====
    protected $fillable = [
        'produk_id',

        // TAMBAHAN BARU
        'nama_komponen',

        'tanggal'
    ];

    // ===== RELASI DETAIL BOM =====
    public function details()
    {
        return $this->hasMany(BomDetail::class);
    }

    // ===== RELASI PRODUK =====
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}