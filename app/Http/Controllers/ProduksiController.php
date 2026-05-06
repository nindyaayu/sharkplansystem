<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\Produk;
use App\Models\Bom;
use App\Models\Barang;
use App\Models\BarangKeluar;

class ProduksiController extends Controller
{
    // =========================
    // HALAMAN PRODUKSI
    // =========================
    public function index()
    {
        $produk = Produk::all();

        $produksi = Produksi::with('produk')
            ->latest()
            ->get();

        return view('produksi', compact(
            'produk',
            'produksi'
        ));
    }

    // =========================
    // SIMPAN PRODUKSI
    // =========================
    public function store(Request $request)
    {
        $request->validate([

            'produk_id' => 'required',

            'qty_produksi' => 'required|integer|min:1',

            'tanggal' => 'required',

            'jenis_produksi' => 'required',

            'pelaksana' => 'required'

        ]);

        Produksi::create([

            'produk_id' =>
                $request->produk_id,

            'qty_produksi' =>
                $request->qty_produksi,

            'tanggal' =>
                $request->tanggal,

            'jenis_produksi' =>
                $request->jenis_produksi,

            'pelaksana' =>
                $request->pelaksana,

            'status' => 'Draft'

        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Produksi berhasil dibuat'
            );
    }

    // =========================
    // PROSES PRODUKSI
    // =========================
    public function proses($id)
    {
        $produksi = Produksi::findOrFail($id);

        // ambil bom produk
        $bom = Bom::with('details.barang')
            ->where('produk_id', $produksi->produk_id)
            ->get();

        foreach ($bom as $item) {

            foreach ($item->details as $detail) {

                $barang = $detail->barang;

                // =========================
                // HITUNG KEBUTUHAN
                // =========================

                $qty =
                    $detail->qty *
                    $produksi->qty_produksi;

                $totalMeter = 0;

                $totalKeluar = 0;

                // CM
                if (
                    $detail->satuan_pakai == 'CM'
                ) {

                    $totalMeter =
                        $qty / 100;
                }

                // METER
                elseif (
                    $detail->satuan_pakai == 'METER'
                ) {

                    $totalMeter = $qty;
                }

                // PCS / ROLL
                elseif (
                    $detail->satuan_pakai == 'PCS'
                    ||
                    $detail->satuan_pakai == 'ROLL'
                ) {

                    $totalKeluar = $qty;
                }

                // konversi ke roll
                if (
                    $detail->satuan_pakai != 'PCS'
                    &&
                    $detail->satuan_pakai != 'ROLL'
                ) {

                    if (
                        $barang->isi_per_satuan
                        &&
                        $barang->isi_per_satuan > 0
                    ) {

                        $totalKeluar = ceil(
                            $totalMeter /
                            $barang->isi_per_satuan
                        );
                    }
                }

                // =========================
                // KURANGI STOK
                // =========================

                $barang->stok -= $totalKeluar;

                if ($barang->stok < 0) {

                    $barang->stok = 0;
                }

                $barang->save();

                // =========================
                // SIMPAN BARANG KELUAR
                // =========================

                BarangKeluar::create([

                    'barang_id' =>
                        $barang->id,

                    'jumlah' =>
                        $totalKeluar,

                    'tanggal_keluar' =>
                        now(),

                    'tujuan' =>
                        'Produksi - ' .
                        $produksi->pelaksana

                ]);
            }
        }

        // update status
        $produksi->update([

            'status' => 'Diproduksi'

        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Produksi berhasil diproses'
            );
    }
}