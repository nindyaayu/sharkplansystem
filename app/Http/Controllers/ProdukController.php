<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // =========================
    // TAMPIL DATA
    // =========================

    public function index()
    {
        $data = Produk::latest()->get();

        return view(
            'produk',
            compact('data')
        );
    }

    // =========================
    // TAMBAH PRODUK
    // =========================

    public function store(Request $request)
    {
        // =========================
        // PREFIX KODE
        // =========================

        $prefix = strtoupper($request->prefix);

        // =========================
        // AMBIL DATA TERAKHIR
        // =========================

        $lastProduk = Produk::where(
            'kode',
            'like',
            $prefix . '%'
        )->latest()->first();

        // =========================
        // GENERATE NOMOR
        // =========================

        if($lastProduk){

            $lastNumber = (int)
                substr($lastProduk->kode, 1);

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
        // STATUS
        // =========================

        if($request->qty_kirim >= $request->qty_order){

            $status = 'Selesai';

        }elseif($request->qty_kirim > 0){

            $status = 'Proses';

        }else{

            $status = 'Belum';
        }

        // =========================
        // SIMPAN
        // =========================

        Produk::create([

            'kode' => $kode,

            'nama' => $request->nama,

            'satuan' => $request->satuan,

            'client' => $request->client,

            'no_po' => $request->no_po,

            'qty_order' => $request->qty_order ?? 0,

            'qty_kirim' => $request->qty_kirim ?? 0,

            'tahap' => $request->tahap,

            'status' => $status,

            'created_at' => $request->tanggal_input

        ]);

        return back();
    }

    // =========================
    // UPDATE PRODUK
    // =========================

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // =========================
        // STATUS
        // =========================

        if($request->qty_kirim >= $request->qty_order){

            $status = 'Selesai';

        }elseif($request->qty_kirim > 0){

            $status = 'Proses';

        }else{

            $status = 'Belum';
        }

        $produk->update([

            'nama' => $request->nama,

            'satuan' => $request->satuan,

            'client' => $request->client,

            'no_po' => $request->no_po,

            'qty_order' => $request->qty_order,

            'qty_kirim' => $request->qty_kirim,

            'tahap' => $request->tahap,

            'status' => $status,

        ]);

        return back();
    }

    // =========================
    // HAPUS
    // =========================

    public function destroy($id)
    {
        Produk::destroy($id);

        return back();
    }
}