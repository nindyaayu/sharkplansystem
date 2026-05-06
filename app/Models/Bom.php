<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    protected $fillable = [
        'produk_id',
        'tanggal'
    ];

    // detail bom
    public function details()
    {
        return $this->hasMany(BomDetail::class);
    }

    // relasi produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}