<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KomponenProduk;
use Illuminate\Http\Request;

class KomponenProdukController extends Controller
{
    public function getKomponen($produkId)
    {
        return KomponenProduk::where(
            'produk_id',
            $produkId
        )
        ->whereNull('parent_id')
        ->orderBy('nama_komponen')
        ->get();
    }

    public function getSubKomponen($parentId)
{
    return KomponenProduk::where(
        'parent_id',
        $parentId
    )
    ->orderBy('nama_komponen')
    ->get();
}

    public function storeSubKomponen(
        Request $request
    )
    {
        $parent =
            KomponenProduk::findOrFail(
                $request->parent_id
            );

        KomponenProduk::create([

            'produk_id' =>
                $parent->produk_id,

            'parent_id' =>
                $request->parent_id,

            'nama_komponen' =>
                $request->nama_komponen

        ]);

        return response()->json([
            'success' => true
        ]);
    }


    public function store(Request $request)
    {
        $komponen = KomponenProduk::create([

            'produk_id' =>
                $request->produk_id,

            'parent_id' =>
                null,

            'nama_komponen' =>
                $request->nama_komponen

        ]);

        return response()->json([

            'success' => true,

            'id' => $komponen->id,

            'nama_komponen' =>
                $komponen->nama_komponen

        ]);
    }

    public function update(
        Request $request,
        $id
    )
    {
        $komponen =
            KomponenProduk::findOrFail($id);

        $komponen->update([

            'nama_komponen' =>
                $request->nama_komponen

        ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function destroy($id)
    {
        KomponenProduk::destroy($id);

        return response()->json([
            'success' => true
        ]);
    }
}