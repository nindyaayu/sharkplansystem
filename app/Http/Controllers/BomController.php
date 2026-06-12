<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Produk;
use App\Models\Barang;

class BomController extends Controller
{
    // =========================
    // TAMPIL HALAMAN MASTER BOM
    // =========================
    public function index()
    {
        $produk = Produk::where(
            'cabang',
            auth()->user()->cabang
        )->get();

        $barang = Barang::where(
            'cabang',
            auth()->user()->cabang
        )->get();

        $bom = Bom::with([
            'produk',
            'details.barang'
        ])
        ->where(
            'cabang',
            auth()->user()->cabang
        )
        ->latest()
        ->get();

        return view('bom', compact(
            'produk',
            'barang',
            'bom'
        ));
    }
// =========================
// UPDATE HEADER BOM
// =========================
public function update(Request $request, $id)
{
    $request->validate([

        'nama_komponen' => 'required'

    ]);

    $bom = Bom::findOrFail($id);

    $bom->update([

        'nama_komponen' =>
            $request->nama_komponen

    ]);

    return redirect()
        ->back()
        ->with('success', 'Komponen berhasil diupdate');
}
    // =========================
    // SIMPAN HEADER BOM
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'nama_komponen' => 'required',
            'tanggal' => 'required'
        ]);

        Bom::create([
            'produk_id' => $request->produk_id,
            'nama_komponen' => $request->nama_komponen,
            'tanggal' => $request->tanggal,
            'cabang' => auth()->user()->cabang
        ]);

        return redirect()
            ->back()
            ->with('success', 'Komponen BOM berhasil dibuat');
    }

    // =========================
    // SIMPAN DETAIL BAHAN
    // =========================
    public function storeDetail(Request $request)
    {
        $request->validate([

            'bom_id' => 'required',

            'barang_id' => 'required',

            'qty' => 'required|numeric|min:0.01',

            'satuan_pakai' => 'required'

        ]);

        BomDetail::create([

            'bom_id' => $request->bom_id,

            'barang_id' => $request->barang_id,

            'qty' => $request->qty,

            'satuan_pakai' =>
                $request->satuan_pakai,

            'cabang' => auth()->user()->cabang

        ]);

        return redirect()
            ->back()
            ->with('success', 'Bahan berhasil ditambahkan');
    }

    // =========================
    // UPDATE DETAIL BOM
    // =========================
    public function updateDetail(Request $request, $id)
    {
        $request->validate([

            'qty' => 'required|numeric|min:0.01',

            'satuan_pakai' => 'required'

        ]);

        $detail = BomDetail::findOrFail($id);

        $detail->update([

            'qty' => $request->qty,

            'satuan_pakai' =>
                $request->satuan_pakai

        ]);

        return redirect()
            ->back()
            ->with('success', 'Qty bahan berhasil diupdate');
    }

    // =========================
    // HAPUS DETAIL BOM
    // =========================
    public function destroyDetail($id)
    {
        $detail = BomDetail::findOrFail($id);

        $detail->delete();

        return redirect()
            ->back()
            ->with('success', 'Bahan berhasil dihapus');
    }

    // =========================
    // HAPUS HEADER BOM
    // =========================
    public function destroy($id)
    {
        $bom = Bom::findOrFail($id);

        $bom->details()->delete();

        $bom->delete();

        return redirect()
            ->back()
            ->with('success', 'Komponen BOM berhasil dihapus');
    }

    // =========================
    // PERHITUNGAN BOM
    // =========================
    public function perhitungan(Request $request)
    {
        // produk
        $produk = Produk::where(
            'cabang',
            auth()->user()->cabang
        )->get();

        // dropdown komponen
        $bom = collect();

        if($request->produk_id){

            $bom = Bom::where(
                'produk_id',
                $request->produk_id
            )
            ->where(
                'cabang',
                auth()->user()->cabang
            )
            ->orderBy('nama_komponen')
            ->get();
        }

        // hasil
        $hasil = collect();

        // jika produk dipilih
        if ($request->produk_id && $request->qty_produksi) {

            // query bom
            $query = Bom::with('details.barang')
                ->where('produk_id', $request->produk_id
                
                                )
                ->where(
                    'cabang',
                    auth()->user()->cabang
                    
                    );

            // mode komponen
            if (
                $request->mode == 'komponen'
                &&
                $request->komponen
            ) {

                $query->where(
                    'nama_komponen',
                    $request->komponen
                );
            }

            // ambil data
            $bomData = $query->get();

            // looping bom
            foreach ($bomData as $item) {

                foreach ($item->details as $detail) {

                    $barang = $detail->barang;

                    // key bahan
                    $key = $barang->id;

                    // =========================
                    // TOTAL AWAL
                    // =========================

                    $totalAwal =
                        $detail->qty *
                        $request->qty_produksi;

                    // default
                    $totalCm = 0;
                    $totalMeter = 0;
                    $rollDibutuhkan = 0;

                    // =========================
                    // KONVERSI BERDASARKAN SATUAN
                    // =========================

                    // CM
                    if (
                        $detail->satuan_pakai == 'CM'
                    ) {

                        $totalCm = $totalAwal;

                        $totalMeter =
                            $totalCm / 100;
                    }

                    // METER
                    elseif (
                        $detail->satuan_pakai == 'METER'
                    ) {

                        $totalMeter = $totalAwal;

                        $totalCm =
                            $totalMeter * 100;
                    }

                    // ROLL
                    elseif (
                        $detail->satuan_pakai == 'ROLL'
                    ) {

                        $rollDibutuhkan =
                            $totalAwal;
                    }

                    // PCS
                    elseif (
                        $detail->satuan_pakai == 'PCS'
                    ) {

                        $rollDibutuhkan =
                            $totalAwal;
                    }

                    // =========================
                    // HITUNG ROLL
                    // =========================

                    if (
                        $detail->satuan_pakai != 'ROLL'
                        &&
                        $detail->satuan_pakai != 'PCS'
                    ) {

                        if (
                            $barang->isi_per_satuan
                            &&
                            $barang->isi_per_satuan > 0
                        ) {

                            $rollDibutuhkan =

                                ceil(
                                    $totalMeter /
                                    $barang->isi_per_satuan
                                );
                        }
                    }

                    // =========================
                    // GABUNGKAN BAHAN
                    // =========================

                    if ($hasil->has($key)) {

                        $lama = $hasil[$key];

                        $hasil[$key] = [

                            'komponen' =>
                                $lama['komponen'] .
                                ', ' .
                                $item->nama_komponen,

                            'bahan' =>
                                $barang->nama,

                            'satuan' =>
                                $barang->satuan,

                            'satuan_pakai' =>
                                $detail->satuan_pakai,

                            'qty_per_pcs' =>
                                $lama['qty_per_pcs'] +
                                $detail->qty,

                            'total_cm' =>
                                $lama['total_cm'] +
                                $totalCm,

                            'total_meter' =>
                                $lama['total_meter'] +
                                $totalMeter,

                            'roll_dibutuhkan' =>
                                $lama['roll_dibutuhkan'] +
                                $rollDibutuhkan,

                            'stok' =>
                                $barang->stok,

                            'isi_per_satuan' =>
                                $barang->isi_per_satuan,

                            'satuan_konversi' =>
                                $barang->satuan_konversi

                        ];

                    } else {

                        $hasil[$key] = [

                            'komponen' =>
                                $item->nama_komponen,

                            'bahan' =>
                                $barang->nama,

                            'satuan' =>
                                $barang->satuan,

                            'satuan_pakai' =>
                                $detail->satuan_pakai,

                            'qty_per_pcs' =>
                                $detail->qty,

                            'total_cm' =>
                                $totalCm,

                            'total_meter' =>
                                $totalMeter,

                            'roll_dibutuhkan' =>
                                $rollDibutuhkan,

                            'stok' =>
                                $barang->stok,

                            'isi_per_satuan' =>
                                $barang->isi_per_satuan,

                            'satuan_konversi' =>
                                $barang->satuan_konversi

                        ];
                    }
                }
            }
        }

        return view('perhitungan_bom', compact(
            'produk',
            'bom',
            'hasil'
        ));
    }
}