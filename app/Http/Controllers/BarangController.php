<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $data = Barang::all();
        return view('bahan', compact('data'));
    }

    public function store(Request $request)
    {
        Barang::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'satuan' => $request->satuan,
            'stok' => 0
        ]);

        return back();
    }

    public function destroy($id)
    {
        Barang::destroy($id);
        return back();
    }
}