<?php
namespace App\Http\Controllers;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;



class PelacakanBarangController extends Controller

{

    public function index(Request $request)

    {

        $barangs = Barang::orderBy('nama')->get();



        $barangDipilih = null;



        $riwayatKeluar = collect();



        $riwayatMasuk = collect();



        $rekapProduk = collect();



        $rekapPeminta = collect();



        $rekapPenjahit = collect();



        if ($request->barang_id) {



            $barangDipilih = Barang::find(

                $request->barang_id

            );



            // =========================

            // RIWAYAT KELUAR

            // =========================



            $queryKeluar = BarangKeluar::with([

                'barang',

                'produk'

            ])

            ->where(

                'barang_id',

                $request->barang_id

            );

            if (auth()->user()->cabang) {

                $queryKeluar->where(
                    'cabang',
                    auth()->user()->cabang
                );

            }



            if ($request->filled('tgl_awal')) {



                $queryKeluar->whereDate(

                    'tanggal_keluar',

                    '>=',

                    $request->tgl_awal

                );



            }



            if ($request->filled('tgl_akhir')) {



                $queryKeluar->whereDate(

                    'tanggal_keluar',

                    '<=',

                    $request->tgl_akhir

                );



            }



            $riwayatKeluar = $queryKeluar

                ->latest('tanggal_keluar')

                ->get();



            // =========================

            // RIWAYAT MASUK

            // =========================



            $queryMasuk = BarangMasuk::where(

                'barang_id',

                $request->barang_id

            );

            if (auth()->user()->cabang) {

                $queryMasuk->where(
                    'cabang',
                    auth()->user()->cabang
                );

            }



            if ($request->filled('tgl_awal')) {



                $queryMasuk->whereDate(

                    'tanggal_masuk',

                    '>=',

                    $request->tgl_awal

                );



            }



            if ($request->filled('tgl_akhir')) {



                $queryMasuk->whereDate(

                    'tanggal_masuk',

                    '<=',

                    $request->tgl_akhir

                );



            }



            $riwayatMasuk = $queryMasuk

                ->latest('tanggal_masuk')

                ->get();



            // =========================

            // REKAP PRODUK

            // =========================



            $rekapProduk = $riwayatKeluar

                ->groupBy('produk_id')

                ->map(function ($items) {



                    return (object)[



                        'produk' =>

                            $items->first()->produk,



                        'total' =>

                            $items->sum('jumlah')



                    ];



                })

                ->sortByDesc('total');



            // =========================

            // REKAP PEMINTA

            // =========================



            $rekapPeminta = $riwayatKeluar

                ->groupBy('nama_peminta')

                ->map(function ($items) {



                    return (object)[



                        'nama_peminta' =>

                            $items->first()->nama_peminta

                            ?: '-',



                        'total' =>

                            $items->sum('jumlah')



                    ];



                })

                ->sortByDesc('total');



            // =========================

            // REKAP PENJAHIT

            // =========================



            $rekapPenjahit = $riwayatKeluar

                ->groupBy('nama_penjahit')

                ->map(function ($items) {



                    return (object)[



                        'nama_penjahit' =>

                            $items->first()->nama_penjahit

                            ?: '-',



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
                'riwayatMasuk',
                'rekapProduk',
                'rekapPeminta',
                'rekapPenjahit'
            )
        );
    }
    public function exportPdf(Request $request)
{
    $barangDipilih = Barang::find(
        $request->barang_id
    );
    $queryKeluar = BarangKeluar::with([
        'barang',
        'produk'
    ])
    ->where(
        'barang_id',
        $request->barang_id
    );
    if (auth()->user()->cabang) {

        $queryKeluar->where(
            'cabang',
            auth()->user()->cabang
        );
    }

    if ($request->filled('tgl_awal')) {

        $queryKeluar->whereDate(
            'tanggal_keluar',
            '>=',
            $request->tgl_awal
        );

    }

    if ($request->filled('tgl_akhir')) {

        $queryKeluar->whereDate(
            'tanggal_keluar',
            '<=',
            $request->tgl_akhir
        );

    }

    $riwayatKeluar = $queryKeluar
        ->latest('tanggal_keluar')
        ->get();

    $queryMasuk = BarangMasuk::where(
        'barang_id',
        $request->barang_id
    );

    if (auth()->user()->cabang) {

        $queryMasuk->where(
            'cabang',
            auth()->user()->cabang
        );

    }

    if ($request->filled('tgl_awal')) {

        $queryMasuk->whereDate(
            'tanggal_masuk',
            '>=',
            $request->tgl_awal
        );

    }

    if ($request->filled('tgl_akhir')) {

        $queryMasuk->whereDate(
            'tanggal_masuk',
            '<=',
            $request->tgl_akhir
        );

    }

    $riwayatMasuk = $queryMasuk
        ->latest('tanggal_masuk')
        ->get();

    $rekapProduk = $riwayatKeluar
        ->groupBy('produk_id')
        ->map(function ($items) {

            return (object)[

                'produk' =>
                    $items->first()->produk,

                'total' =>
                    $items->sum('jumlah')

            ];

        });

    $rekapPeminta = $riwayatKeluar
        ->groupBy('nama_peminta')
        ->map(function ($items) {

            return (object)[

                'nama_peminta' =>
                    $items->first()->nama_peminta ?: '-',

                'total' =>
                    $items->sum('jumlah')

            ];

        });

    $rekapPenjahit = $riwayatKeluar
        ->groupBy('nama_penjahit')
        ->map(function ($items) {

            return (object)[

                'nama_penjahit' =>
                    $items->first()->nama_penjahit ?: '-',

                'total' =>
                    $items->sum('jumlah')

            ];

        });

    $pdf = Pdf::loadView(
        'pelacakan.pdf',
        compact(
            'barangDipilih',
            'riwayatMasuk',
            'riwayatKeluar',
            'rekapProduk',
            'rekapPeminta',
            'rekapPenjahit'
        )
    );

    return $pdf->download(
        'pelacakan-barang.pdf'
    );
}

}
