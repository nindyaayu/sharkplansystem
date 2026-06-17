<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\KomponenProduk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
        {
            $data = Produk::when(
                auth()->user()->cabang,
                function ($q) {

                    $q->where(
                        'cabang',
                        auth()->user()->cabang
                    );

                }
            )
            ->latest()
            ->get();

            $komponen =
            KomponenProduk::whereNull(
                'parent_id'
            )
            ->latest()
            ->get();

            return view(
                'produk',
                compact(
                    'data',
                    'komponen'
                )
            );
        }

    public function store(Request $request)
    {
        $prefix = strtoupper(substr($request->nama, 0, 1));

        $lastProduk = Produk::where(
            'kode',
            'like',
            $prefix . '%'
        )
        ->orderBy('kode', 'desc')
        ->first();

        if ($lastProduk) {

            $lastNumber = (int) substr(
                $lastProduk->kode,
                1
            );

            $newNumber = str_pad(
                $lastNumber + 1,
                3,
                '0',
                STR_PAD_LEFT
            );

        } else {

            $newNumber = '001';

        }

        $kode = $prefix . $newNumber;

        Produk::create([

            'kode'   => $kode,

            'nama'   => $request->nama,

            'varian' => $request->varian,

            'satuan' => $request->satuan,

            'cabang' => auth()->user()->cabang

        ]);

        return back();
    }

    public function update(
        Request $request,
        $id
    )
    {
        $produk =
            Produk::findOrFail($id);

        $produk->update([

            'nama'   => $request->nama,

            'varian' => $request->varian,

            'satuan' => $request->satuan,

            'cabang' => auth()->user()->cabang

        ]);

        return back();
    }

    public function destroy($id)
    {
        Produk::destroy($id);

        return back();
    }
}