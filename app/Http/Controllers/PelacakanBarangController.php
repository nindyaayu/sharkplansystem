<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class PelacakanBarangController extends Controller
{
    public function index(Request $request)
    {
        $barangs = Barang::orderBy('nama')->get();

        $barangDipilih = null;
        $riwayatKeluar = collect();

        if ($request->barang_id) {

            $barangDipilih = Barang::find(
                $request->barang_id
            );

            $riwayatKeluar = BarangKeluar::with([
                'barang',
                'produk'
            ])
            ->where(
                'barang_id',
                $request->barang_id
            )
            ->latest()
            ->get();
        }

        return view(
            'pelacakan.index',
            compact(
                'barangs',
                'barangDipilih',
                'riwayatKeluar'
            )
        );
    }
}