<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    // tampil halaman
    public function index()
    {
        // ambil data barang masuk + relasi barang
        $barangMasuks = BarangMasuk::with('barang')
            ->latest()
            ->get();

        // ambil semua barang untuk dropdown form
        $barangs = Barang::all();

        return view('barang_masuk', compact(
            'barangMasuks',
            'barangs'
        ));
    }

    // simpan data barang masuk
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required',
            'supplier' => 'required'
        ]);

        // simpan transaksi barang masuk
        BarangMasuk::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'supplier' => $request->supplier,
        ]);

        // update stok barang
        $barang = Barang::find($request->barang_id);

        $barang->stok += $request->jumlah;

        $barang->save();

        return redirect()
            ->back()
            ->with('success', 'Barang masuk berhasil ditambahkan');
    }
// update barang masuk
public function update(Request $request, $id)
{
    $request->validate([
        'barang_id' => 'required',
        'jumlah' => 'required|integer|min:1',
        'tanggal_masuk' => 'required',
        'supplier' => 'required'
    ]);

    // data lama
    $barangMasuk = BarangMasuk::findOrFail($id);

    // rollback stok lama
    $barangLama = Barang::find($barangMasuk->barang_id);

    $barangLama->stok -= $barangMasuk->jumlah;

    if ($barangLama->stok < 0) {
        $barangLama->stok = 0;
    }

    $barangLama->save();

    // update transaksi
    $barangMasuk->update([
        'barang_id' => $request->barang_id,
        'jumlah' => $request->jumlah,
        'tanggal_masuk' => $request->tanggal_masuk,
        'supplier' => $request->supplier,
    ]);

    // tambah stok baru
    $barangBaru = Barang::find($request->barang_id);

    $barangBaru->stok += $request->jumlah;

    $barangBaru->save();

    return redirect()
        ->back()
        ->with('success', 'Barang masuk berhasil diupdate');
}
    // hapus barang masuk
    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        // kurangi stok saat data dihapus
        $barang = Barang::find($barangMasuk->barang_id);

        $barang->stok -= $barangMasuk->jumlah;

        // cegah stok minus
        if ($barang->stok < 0) {
            $barang->stok = 0;
        }

        $barang->save();

        // hapus transaksi
        $barangMasuk->delete();

        return redirect()
            ->back()
            ->with('success', 'Data berhasil dihapus');
    }
}