<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // =========================
    // TAMPIL DATA
    // =========================

public function index()
{
    $data = Barang::orderBy('kategori')
                  ->orderBy('nama')
                  ->get();

    return view('bahan', compact('data'));
}

    // =========================
    // TAMBAH DATA
    // =========================

    public function store(Request $request)
    {
        // =========================
        // VALIDASI
        // =========================

        $request->validate([

            'nama' => 'required',

            'kategori' => 'required',

            'satuan' => 'required'

        ]);

        // =========================
        // PREFIX KODE
        // =========================

        $prefix =
            $request->kategori == 'Kain'
            ? 'MU-'
            : 'MP-';

        // =========================
        // AMBIL DATA TERAKHIR
        // =========================

        $lastBarang = Barang::where(
            'kode',
            'like',
            $prefix . '%'
        )->latest()->first();

        // =========================
        // GENERATE NOMOR
        // =========================

        if ($lastBarang) {

            $lastNumber = (int)
                substr($lastBarang->kode, 3);

            $newNumber =
                str_pad(
                    $lastNumber + 1,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

        } else {

            $newNumber = '001';
        }

        // =========================
        // KODE FINAL
        // =========================

        $kode = $prefix . $newNumber;

        // =========================
        // SIMPAN MASTER BARANG
        // =========================

        Barang::create([

            'kode' => $kode,

            'nama' => $request->nama,

            'kategori' => $request->kategori,

            'warna' => $request->warna,

            'satuan' => $request->satuan,

            /*
            =========================
            STOK AWAL = 0
            STOK BERASAL DARI
            TRANSAKSI MASUK/KELUAR
            =========================
            */

            'jumlah_roll' => 0,

            'jumlah_meter' => 0,

            'stok' => 0,

            'isi_per_satuan' =>
                $request->isi_per_satuan,

            'satuan_konversi' =>
                $request->satuan_konversi

        ]);

        return back()->with(
            'success',
            'Data bahan berhasil ditambahkan'
        );
    }

    // =========================
    // EDIT DATA
    // =========================

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $barang->update([

            'nama' => $request->nama,

            /*
            =========================
            FIX KATEGORI NULL
            =========================
            */

            'kategori' => !empty($request->kategori)
                ? $request->kategori
                : $barang->kategori,

            'warna' => $request->warna,

            'satuan' => $request->satuan,

            /*
            =========================
            STOK TIDAK DIEDIT MANUAL
            =========================
            */

            'isi_per_satuan' =>
                $request->isi_per_satuan,

            'satuan_konversi' =>
                $request->satuan_konversi

        ]);

        return back()->with(
            'success',
            'Data bahan berhasil diupdate'
        );
    }

    // =========================
    // HAPUS DATA
    // =========================

    public function destroy($id)
    {
        Barang::destroy($id);

        return back()->with(
            'success',
            'Data bahan berhasil dihapus'
        );
    }
}