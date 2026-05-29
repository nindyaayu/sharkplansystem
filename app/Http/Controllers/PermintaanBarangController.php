<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PermintaanBarang;
use App\Models\BarangKeluar;
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

            public function update(Request $request, $id)
                {
                $permintaan = PermintaanBarang::with(
                'details.barang'
                )->findOrFail($id);

                if (
                    $request->status == 'Sudah Diambil'
                    &&
                    $permintaan->status != 'Sudah Diambil'
                ) {

                    foreach ($permintaan->details as $detail) {

                        $barang = $detail->barang;

                        // =========================
                        // BARANG KELUAR
                        // =========================

                        BarangKeluar::create([

                            'barang_id' =>
                                $barang->id,

                            'jumlah' =>
                                $detail->jumlah,

                            'jumlah_roll' =>
                                0,

                            'tanggal_keluar' =>
                                now(),

                            'tujuan' =>
                                'INTERNAL - ' .
                                strtoupper(
                                    $permintaan->nama_penjahit
                                )

                        ]);

                        // =========================
                        // KURANGI STOK
                        // =========================

                        $barang->update([

                            'stok' =>
                                max(
                                    0,
                                    $barang->stok - $detail->jumlah
                                )

                        ]);
                    }
                }

                $permintaan->update([

                    'status' => $request->status

                ]);

                return redirect()
                    ->route('permintaan-barang')
                    ->with(
                        'success',
                        'Status berhasil diperbarui'
                    );

                }




}