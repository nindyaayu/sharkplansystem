<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomDetail extends Model
{
    protected $fillable = [
        'bom_id',
        'barang_id',
        'qty'
    ];

    // relasi ke bom
    public function bom()
    {
        return $this->belongsTo(Bom::class);
    }

    // relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}