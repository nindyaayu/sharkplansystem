<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    // =========================
    // TAMPIL HALAMAN
    // =========================

    public function index(Request $request)
{
    $query = BarangMasuk::with('barang');

    // FILTER TANGGAL
    if ($request->filled('tanggal')) {

        $query->whereDate(
            'tanggal_masuk',
            $request->tanggal
        );
    }

    $barangMasuks = $query
        ->latest()
        ->get();

    $barangs = Barang::all();

    // =====================
    // STATISTIK
    // =====================

    $totalTransaksi = BarangMasuk::count();

    $totalQty = BarangMasuk::sum('jumlah');

    $hariIni = BarangMasuk::whereDate(
        'tanggal_masuk',
        now()->toDateString()
    )->count();

    $bulanIni = BarangMasuk::whereMonth(
        'tanggal_masuk',
        now()->month
    )
    ->whereYear(
        'tanggal_masuk',
        now()->year
    )
    ->count();

    return view(
        'barang_masuk',
        compact(
            'barangMasuks',
            'barangs',
            'totalTransaksi',
            'totalQty',
            'hariIni',
            'bulanIni'
        )
    );
}

    // =========================
    // SIMPAN DATA
    // =========================

    public function store(Request $request)
    {
        $request->validate([

            'barang_id' => 'required',

            'jumlah' => 'required|integer|min:1',

            'tanggal_masuk' => 'required',

            'supplier' => 'required'

        ]);

        // =========================
        // CARI BARANG
        // =========================

        $barang = Barang::find($request->barang_id);

        // =========================
        // MATERIAL UTAMA
        // =========================

        if($barang->kategori == 'Kain'){

            BarangMasuk::create([

                'barang_id' =>
                    $request->barang_id,

                'jumlah_roll' =>
                    $request->jumlah_roll,

                'jumlah' =>
                    $request->jumlah,

                'tanggal_masuk' =>
                    $request->tanggal_masuk,

                'supplier' =>
                    $request->supplier,

                'cabang' => auth()->user()->cabang,

            ]);

            // tambah stok kain

            $barang->jumlah_roll +=
                $request->jumlah_roll;

            $barang->jumlah_meter +=
                $request->jumlah;

        }

        // =========================
        // MATERIAL PENDUKUNG
        // =========================

        else{

            BarangMasuk::create([

                'barang_id' =>
                    $request->barang_id,

                'jumlah' =>
                    $request->jumlah,

                'tanggal_masuk' =>
                    $request->tanggal_masuk,

                'supplier' =>
                    $request->supplier,

                'cabang' => auth()->user()->cabang,

            ]);

            $barang->stok +=
                $request->jumlah;
        }

        $barang->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'Barang masuk berhasil ditambahkan'
            );
    }

    // =========================
    // UPDATE DATA
    // =========================

    public function update(Request $request, $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $barang = Barang::find($request->barang_id);

        // =========================
        // ROLLBACK STOK LAMA
        // =========================

        if($barang->kategori == 'Kain'){

            $barang->jumlah_roll -=
                $barangMasuk->jumlah_roll;

            $barang->jumlah_meter -=
                $barangMasuk->jumlah;

            if($barang->jumlah_roll < 0){

                $barang->jumlah_roll = 0;

            }

            if($barang->jumlah_meter < 0){

                $barang->jumlah_meter = 0;

            }

        }else{

            $barang->stok -=
                $barangMasuk->jumlah;

            if($barang->stok < 0){

                $barang->stok = 0;

            }
        }

        // =========================
        // UPDATE TRANSAKSI
        // =========================

        $barangMasuk->update([

            'barang_id' =>
                $request->barang_id,

            'jumlah_roll' =>
                $request->jumlah_roll ?? 0,

            'jumlah' =>
                $request->jumlah,

            'tanggal_masuk' =>
                $request->tanggal_masuk,

            'supplier' =>
                $request->supplier,

        ]);

        // =========================
        // TAMBAH STOK BARU
        // =========================

        if($barang->kategori == 'Kain'){

            $barang->jumlah_roll +=
                $request->jumlah_roll;

            $barang->jumlah_meter +=
                $request->jumlah;

        }else{

            $barang->stok +=
                $request->jumlah;
        }

        $barang->save();

        return redirect()
            ->back()
            ->with(
                'success',
                'Barang masuk berhasil diupdate'
            );
    }

    // =========================
    // HAPUS DATA
    // =========================

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $barang = Barang::find(
            $barangMasuk->barang_id
        );

        // =========================
        // KURANGI STOK
        // =========================

        if($barang->kategori == 'Kain'){

            $barang->jumlah_roll -=
                $barangMasuk->jumlah_roll;

            $barang->jumlah_meter -=
                $barangMasuk->jumlah;

            if($barang->jumlah_roll < 0){

                $barang->jumlah_roll = 0;

            }

            if($barang->jumlah_meter < 0){

                $barang->jumlah_meter = 0;

            }

        }else{

            $barang->stok -=
                $barangMasuk->jumlah;

            if($barang->stok < 0){

                $barang->stok = 0;

            }
        }

        $barang->save();

        // =========================
        // HAPUS TRANSAKSI
        // =========================

        $barangMasuk->delete();

        return redirect()
            ->back()
            ->with(
                'success',
                'Data berhasil dihapus'
            );
    }
}