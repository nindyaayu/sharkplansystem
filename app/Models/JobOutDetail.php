<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobOutDetail extends Model
{
    protected $fillable = [

        'job_out_id',

        'barang_id',

        'qty',

        'satuan'

    ];

    // =========================
    // RELASI JOB OUT
    // =========================

    public function jobOut()
    {
        return $this->belongsTo(JobOut::class);
    }

    // =========================
    // RELASI BARANG
    // =========================

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}