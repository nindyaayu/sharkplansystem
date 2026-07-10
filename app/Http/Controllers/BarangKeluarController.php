<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\Produk;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    // =========================
    // TAMPIL HALAMAN
    // =========================

    public function index()
    {
        $query = BarangKeluar::with([
            'barang',
            'produk'
        ]);

        if (auth()->user()->cabang) {

            $query->where(
                'cabang',
                auth()->user()->cabang
            );

        }

        $barangKeluars = $query
            ->latest()
            ->get();

        $barangs = Barang::all();

        $produks = Produk::all();

        return view('barang_keluar', compact(
            'barangKeluars',
            'barangs'
        ));
    }

    // =========================
    // SIMPAN BARANG KELUAR
    // =========================

    public function store(Request $request)
    {
        $request->validate([

            'barang_id' => 'required',

            'tanggal_keluar' => 'required',

        ]);

        // =========================
        // CARI BARANG
        // =========================

        $barang = Barang::find($request->barang_id);

        $tujuan = $request->tujuan;

            if (
                $request->filled('mode')
                &&
                $request->filled('nama_peminta')
            ) {

                $tujuan =
                    strtoupper($request->mode)
                    . ' - ' .
                    strtoupper($request->nama_peminta);

                if ($request->filled('nama_penjahit')) {

                    $tujuan .=
                        ' - ' .
                        strtoupper($request->nama_penjahit);

                }
            }

        // =========================
        // MATERIAL UTAMA
        // =========================

        if ($barang->kategori == 'Kain') {

            if ($barang->jumlah_meter < $request->jumlah) {

                return redirect()
                    ->back()
                    ->with('error', 'Jumlah meter tidak mencukupi');
            }

            // =========================
            // SIMPAN TRANSAKSI
            // =========================

            BarangKeluar::create([

                'barang_id' => $request->barang_id,

                'nama_peminta' =>
                    $request->nama_peminta,

                'nama_penjahit' =>
                    $request->nama_penjahit,

                'jumlah_roll' =>
                    $request->jumlah_roll,

                'jumlah' =>
                    $request->jumlah,

                'tanggal_keluar' =>
                    $request->tanggal_keluar,

                'tujuan' => $tujuan,

                'cabang' => auth()->user()->cabang,

            ]);

            // =========================
            // KURANGI STOK
            // =========================

            $barang->jumlah_roll -=
                $request->jumlah_roll;

            $barang->jumlah_meter -=
                $request->jumlah;

        }

        // =========================
        // MATERIAL PENDUKUNG
        // =========================

        else {

            if ($barang->stok < $request->jumlah) {

                return redirect()
                    ->back()
                    ->with('error', 'Stok tidak mencukupi');
            }

            BarangKeluar::create([

                'barang_id' => $request->barang_id,

                'produk_id' =>
                    $request->produk_id,

                'nama_peminta' =>
                    $request->nama_peminta,

                'nama_penjahit' =>
                    $request->nama_penjahit,

                'jumlah' =>
                    $request->jumlah,

                'tanggal_keluar' =>
                    $request->tanggal_keluar,

                'tujuan' => $tujuan,

                'cabang' => auth()->user()->cabang,

            ]);

            $barang->stok -=
                $request->jumlah;
        }

        $barang->save();

        return redirect()
            ->back()
            ->with('success', 'Barang keluar berhasil ditambahkan');
    }

    // =========================
    // UPDATE BARANG KELUAR
    // =========================

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $barang = Barang::find($request->barang_id);

        // =========================
        // KEMBALIKAN STOK LAMA
        // =========================

        if ($barang->kategori == 'Kain') {

            $barang->jumlah_roll +=
                $barangKeluar->jumlah_roll;

            $barang->jumlah_meter +=
                $barangKeluar->jumlah;

        } else {

            $barang->stok +=
                $barangKeluar->jumlah;
        }

        // =========================
        // UPDATE TRANSAKSI
        // =========================

        $barangKeluar->update([

            'barang_id' =>
                $request->barang_id,

            'jumlah_roll' =>
                $request->jumlah_roll ?? 0,

            'jumlah' =>
                $request->jumlah,

            'tanggal_keluar' =>
                $request->tanggal_keluar,

            'tujuan' =>
                $request->tujuan,

        ]);

        // =========================
        // KURANGI STOK BARU
        // =========================

        if ($barang->kategori == 'Kain') {

            $barang->jumlah_roll -=
                $request->jumlah_roll;

            $barang->jumlah_meter -=
                $request->jumlah;

        } else {

            $barang->stok -=
                $request->jumlah;
        }

        $barang->save();

        return redirect()
            ->back()
            ->with('success', 'Barang keluar berhasil diupdate');
    }

    // =========================
    // HAPUS BARANG KELUAR
    // =========================

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $barang = Barang::find(
            $barangKeluar->barang_id
        );

        // =========================
        // KEMBALIKAN STOK
        // =========================

        if ($barang->kategori == 'Kain') {

            $barang->jumlah_roll +=
                $barangKeluar->jumlah_roll;

            $barang->jumlah_meter +=
                $barangKeluar->jumlah;

        } else {

            $barang->stok +=
                $barangKeluar->jumlah;
        }

        $barang->save();

        // =========================
        // HAPUS TRANSAKSI
        // =========================

        $barangKeluar->delete();

        return redirect()
            ->back()
            ->with('success', 'Data berhasil dihapus');
    }
}