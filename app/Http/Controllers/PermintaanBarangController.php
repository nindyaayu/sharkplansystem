<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PermintaanBarang;
use Illuminate\Http\Request;

class PermintaanBarangController extends Controller
{
    public function index()
    {
        $barang = Barang::orderBy('nama')->get();

        $permintaan = PermintaanBarang::latest()->get();

        return view(
            'permintaan_barang',
            compact(
                'barang',
                'permintaan'
            )
        );
    }

    public function store(Request $request)
            {
                $last = PermintaanBarang::latest()->first();

                if ($last) {

                    $lastNumber = (int) str_replace(
                        'PB-',
                        '',
                        $last->nomor_permintaan
                    );

                    $nextNumber = $lastNumber + 1;

                } else {

                    $nextNumber = 1;
                }

                $permintaan = PermintaanBarang::create([

                    'nomor_permintaan' =>
                        'PB-' .
                        str_pad(
                            $nextNumber,
                            4,
                            '0',
                            STR_PAD_LEFT
                        ),

                    'tanggal' => now(),

                    'nama_peminta' =>
                        $request->nama_peminta,

                    'nama_penjahit' =>
                        $request->nama_penjahit,

                    'status' => 'Menunggu'
                ]);

                foreach (
                    $request->barang_id as $index => $barangId
                ) {

                    \App\Models\DetailPermintaanBarang::create([

                        'permintaan_barang_id' =>
                            $permintaan->id,

                        'barang_id' =>
                            $barangId,

                        'jumlah' =>
                            $request->jumlah[$index]

                    ]);
                }

                return redirect()
                    ->route('permintaan-barang')
                    ->with(
                        'success',
                        'Permintaan berhasil dibuat'
                    );
            }

            public function show($id)
                {
                $permintaan = PermintaanBarang::with(
                'details.barang'
                )->findOrFail($id);
                return response()->json($permintaan);
                }

}