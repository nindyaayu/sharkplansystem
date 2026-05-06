<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bom;
use App\Models\BomDetail;
use App\Models\Produk;
use App\Models\Barang;

class BomController extends Controller
{
    public function index()
    {
        $produk = Produk::all();

        $barang = Barang::all();

        $bom = Bom::with([
            'produk',
            'details.barang'
        ])->latest()->get();

        return view('bom', compact(
            'produk',
            'barang',
            'bom'
        ));
    }

    // simpan bom
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required',
            'barang_id' => 'required',
            'qty' => 'required|integer|min:1',
            'tanggal' => 'required'
        ]);

        // simpan header bom
        $bom = Bom::create([
            'produk_id' => $request->produk_id,
            'tanggal' => $request->tanggal
        ]);

        // simpan detail
        BomDetail::create([
            'bom_id' => $bom->id,
            'barang_id' => $request->barang_id,
            'qty' => $request->qty
        ]);

        return redirect()
            ->back()
            ->with('success', 'BOM berhasil ditambahkan');
    }
}