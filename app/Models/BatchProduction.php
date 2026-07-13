<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchProduction extends Model
{
    protected $fillable = [

        'kode_batch',

        'produk_id',

        'qty_order',

        'tanggal',

        'keterangan',

        'status'

    ];

    // =========================
    // RELASI PRODUK
    // =========================
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // =========================
    // RELASI HASIL CUTTING
    // =========================
    public function hasilCuttings()
    {
        return $this->hasMany(
            HasilCutting::class,
            'batch_production_id'
        );
    }

    // =========================
    // RELASI PENGAMBILAN POTONGAN
    // =========================
    public function pengambilanPotongans()
    {
        return $this->hasMany(
            PengambilanPotongan::class,
            'batch_production_id'
        );
    }

    // =========================
    // RELASI PENJAHITAN
    // =========================
    public function penjahitans()
    {
        return $this->hasMany(
            Penjahitan::class,
            'batch_production_id'
        );
    }

    // =========================
    // RELASI ASSEMBLING
    // =========================
    public function assemblings()
    {
        return $this->hasMany(
            Assembling::class,
            'batch_production_id'
        );
    }

    // =========================
    // RELASI FINISHING
    // =========================
    public function finishings()
    {
        return $this->hasMany(
            Finishing::class,
            'batch_production_id'
        );
    }
}