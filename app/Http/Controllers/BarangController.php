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
        Barang::create([

            'kode' => $request->kode,

            'nama' => $request->nama,

            'warna' => $request->warna,

            'satuan' => $request->satuan,

            // TAMBAHAN BARU
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

            'kode' => $request->kode,

            'nama' => $request->nama,

            'warna' => $request->warna,

            'satuan' => $request->satuan,

            // TAMBAHAN BARU
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