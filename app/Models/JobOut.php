<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\JobOutDetail;

class JobOut extends Model
{
    protected $fillable = [

        'no_surat',

        'produk_id',

        'vendor',

        'ekspedisi',

        'tanggal',

        'status',

        'catatan',
        
        'cabang'

    ];

    // =========================
    // RELASI PRODUK
    // =========================

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // =========================
    // RELASI DETAIL
    // =========================

    public function details()
    {
        return $this->hasMany(JobOutDetail::class);
    }
}