<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomponenProduk extends Model
{
    protected $fillable = [

        'produk_id',

        'parent_id',

        'nama_komponen'

    ];

    public function produk()
    {
        return $this->belongsTo(
            Produk::class
        );
    }

    public function parent()
    {
        return $this->belongsTo(
            KomponenProduk::class,
            'parent_id'
        );
    }

    public function children()
    {
        return $this->hasMany(
            KomponenProduk::class,
            'parent_id'
        );
    }
}