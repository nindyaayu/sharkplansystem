<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\PermintaanBarang;
use App\Models\BarangKeluar;
use App\Models\Produk;
use App\Models\DetailPermintaanBarang;
use Illuminate\Http\Request;

class PermintaanBarangController extends Controller
{
    public function index()
{
    $barang = Barang::orderBy('nama')->get();

    $produk = Produk::orderBy('nama')->get();

    $permintaan = PermintaanBarang::with([
    'produk',
    'komponen'
])
    ->latest()
    ->get();

    return view(
        'permintaan_barang',
        compact(
            'barang',
            'produk',
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

                'produk_id' => $request->produk_id,

                'komponen_produk_id' =>
                    $request->komponen_produk_id,

                'nama_peminta' =>
                    $request->nama_peminta,

                'nama_penjahit' =>
                    $request->nama_penjahit,

                'status' => 'Menunggu'
            ]);

            foreach (
    $request->barang_id as $index => $barangId
) {

    DetailPermintaanBarang::create([

    'permintaan_barang_id' => $permintaan->id,
    'barang_id' => $barangId,
    'jumlah' => $request->jumlah[$index],
    'status' => 'Menunggu'

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
                    $permintaan = PermintaanBarang::with([
                        'details.barang'
                    ])->findOrFail($id);

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

                        // HANYA BARANG ACC YANG KELUAR
                        if ($detail->status != 'ACC') {
                            continue;
                        }

                        $barang = $detail->barang;

                        BarangKeluar::create([

                            'barang_id' => $barang->id,

                            'permintaan_barang_id' => $permintaan->id,

                            'produk_id' => $permintaan->produk_id,

                            'nama_peminta' => $permintaan->nama_peminta,

                            'nama_penjahit' => $permintaan->nama_penjahit,

                            'jumlah' => $detail->jumlah,

                            'jumlah_roll' => 0,

                            'tanggal_keluar' => now(),

                            'tujuan' =>
                                'INTERNAL - ' .
                                strtoupper($permintaan->nama_peminta) .
                                ' - ' .
                                strtoupper($permintaan->nama_penjahit)

                        ]);

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

                public function updateDetailStatus(Request $request, $id)
{
    if (
        strtolower(auth()->user()->role) != 'admin' &&
        strtolower(auth()->user()->role) != 'gudang'
    ) {
        $permintaan->refresh();
        return response()->json([
            'success' => false,
            'message' => 'Akses ditolak'
        ], 403);
    }

    $detail = DetailPermintaanBarang::findOrFail($id);

        $detail->status = $request->status;
            $detail->save();

            $detail->refresh();

            $permintaan = PermintaanBarang::with('details')
                ->findOrFail($detail->permintaan_barang_id);

            $permintaan->load('details');

    $total = $permintaan->details->count();

        $acc = $permintaan->details
            ->where('status','ACC')
            ->count();

        $kosong = $permintaan->details
            ->where('status','Kosong')
            ->count();

        $ditolak = $permintaan->details
            ->where('status','Ditolak')
            ->count();

        if($acc == $total){

            $status = 'Disetujui';

        }
        elseif($kosong == $total){

            $status = 'Kosong';

        }
        elseif($ditolak == $total){

            $status = 'Ditolak';

        }
        elseif($acc > 0){

            $status = 'Disetujui Sebagian';

        }
        else{

            $status = 'Menunggu';

        }

        $permintaan->update([
            'status' => $status
        ]);
}
}