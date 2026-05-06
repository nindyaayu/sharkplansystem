<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $data = Produk::all();
        return view('produk', compact('data'));
    }

    public function store(Request $request)
    {
        Produk::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'satuan' => $request->satuan
        ]);

        return back();
    }

    public function destroy($id)
    {
        Produk::destroy($id);
        return back();
    }
}