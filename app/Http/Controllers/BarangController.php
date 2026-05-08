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

        if($lastBarang){

            $lastNumber = (int)
                substr($lastBarang->kode, 3);

            $newNumber =
                str_pad(
                    $lastNumber + 1,
                    3,
                    '0',
                    STR_PAD_LEFT
                );

        }else{

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

            'isi_per_satuan' =>
                $request->isi_per_satuan,

            'satuan_konversi' =>
                $request->satuan_konversi,

            'stok' => $request->stok ?? 0

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

            // kode tidak diubah manual
            'nama' => $request->nama,

            'kategori' => $request->kategori,

            'warna' => $request->warna,

            'satuan' => $request->satuan,

            'isi_per_satuan' =>
                $request->isi_per_satuan,

            'satuan_konversi' =>
                $request->satuan_konversi,

            'stok' => $request->stok

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