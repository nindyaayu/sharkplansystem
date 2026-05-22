<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilCutting extends Model
{
    protected $fillable = [

        'tanggal',

        'produk',

        'komponen',

        'hasil_pot',

        'keterangan'

    ];
}