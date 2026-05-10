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
        $data = Barang::latest()->get();

        return view('bahan', compact('data'));
    }

    // =========================
    // TAMBAH DATA
    // =========================
    public function store(Request $request)
    {
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
        // SIMPAN DATA
        // =========================

        Barang::create([

            'kode' => $kode,

            'nama' => $request->nama,

            'kategori' => $request->kategori,

            'warna' => $request->warna,

            'satuan' => $request->satuan,

            /*
            =========================
            MATERIAL UTAMA
            =========================
            */

            'jumlah_roll' =>
                $request->jumlah_roll ?? 0,

            'jumlah_meter' =>
                $request->jumlah_meter ?? 0,

            /*
            =========================
            MATERIAL PENDUKUNG
            =========================
            */

            'stok' =>
                $request->stok ?? 0,

            'isi_per_satuan' =>
                $request->isi_per_satuan,

            'satuan_konversi' =>
                $request->satuan_konversi

        ]);

        return back();
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
            MATERIAL UTAMA
            =========================
            */

            'jumlah_roll' =>
                $request->jumlah_roll ?? 0,

            'jumlah_meter' =>
                $request->jumlah_meter ?? 0,

            /*
            =========================
            MATERIAL PENDUKUNG
            =========================
            */

            'stok' =>
                $request->stok ?? 0,

            'isi_per_satuan' =>
                $request->isi_per_satuan,

            'satuan_konversi' =>
                $request->satuan_konversi

        ]);

        return back();
    }

    // =========================
    // HAPUS DATA
    // =========================
    public function destroy($id)
    {
        Barang::destroy($id);

        return back();
    }
}