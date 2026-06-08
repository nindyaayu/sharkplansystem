<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelacakanBarangController extends Controller
{
    public function index(Request $request)
    {
    $barangs = Barang::orderBy('nama')->get();

    $barangDipilih = null;

    $riwayatKeluar = collect();

    $rekapProduk = collect();

    $rekapPeminta = collect();

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
        );

        // FILTER TANGGAL AWAL
        if ($request->filled('tgl_awal')) {

            $riwayatKeluar->whereDate(
                'tanggal_keluar',
                '>=',
                $request->tgl_awal
            );

        }

        // FILTER TANGGAL AKHIR
        if ($request->filled('tgl_akhir')) {

            $riwayatKeluar->whereDate(
                'tanggal_keluar',
                '<=',
                $request->tgl_akhir
            );

        }

        $riwayatKeluar = $riwayatKeluar
            ->latest('tanggal_keluar')
            ->get();

            $rekapProduk = BarangKeluar::query()

            ->select(
                'produk_id',
                DB::raw('SUM(jumlah) as total')
            )

            ->with('produk')

            ->where(
                'barang_id',
                $request->barang_id
            );

        if ($request->filled('tgl_awal')) {

            $rekapProduk->whereDate(
                'tanggal_keluar',
                '>=',
                $request->tgl_awal
            );

        }

        if ($request->filled('tgl_akhir')) {

            $rekapProduk->whereDate(
                'tanggal_keluar',
                '<=',
                $request->tgl_akhir
            );

        }

        $rekapProduk = $rekapProduk

            ->groupBy('produk_id')

            ->orderByDesc('total')

            ->get();

            $rekapPeminta = $riwayatKeluar
                ->groupBy('tujuan')
                ->map(function ($items) {

                    return (object)[

                        'nama_peminta' =>
                            str_replace(
                                'INTERNAL - ',
                                '',
                                $items->first()->tujuan
                            ),

                        'total' =>
                            $items->sum('jumlah')
                    ];

                })
                ->sortByDesc('total');
    }

            return view(
            'pelacakan.index',
            compact(
                'barangs',
                'barangDipilih',
                'riwayatKeluar',
                'rekapProduk',
                'rekapPeminta'
            )
        );
    }

}