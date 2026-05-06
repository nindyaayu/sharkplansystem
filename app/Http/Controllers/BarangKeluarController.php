<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    // tampil halaman
    public function index()
    {
        // ambil data barang keluar
        $barangKeluars = BarangKeluar::with('barang')
            ->latest()
            ->get();

        // ambil data barang
        $barangs = Barang::all();

        return view('barang_keluar', compact(
            'barangKeluars',
            'barangs'
        ));
    }

    // simpan barang keluar
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required',
            'jumlah' => 'required|integer|min:1',
            'tanggal_keluar' => 'required',
            'tujuan' => 'required'
        ]);

        // cari barang
        $barang = Barang::find($request->barang_id);

        // cek stok
        if ($barang->stok < $request->jumlah) {

            return redirect()
                ->back()
                ->with('error', 'Stok tidak mencukupi');

        }

        // simpan transaksi
        BarangKeluar::create([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_keluar' => $request->tanggal_keluar,
            'tujuan' => $request->tujuan,
        ]);

        // kurangi stok
        $barang->stok -= $request->jumlah;

        $barang->save();

        return redirect()
            ->back()
            ->with('success', 'Barang keluar berhasil ditambahkan');
    }
// update barang keluar
public function update(Request $request, $id)
{
    $request->validate([
        'barang_id' => 'required',
        'jumlah' => 'required|integer|min:1',
        'tanggal_keluar' => 'required',
        'tujuan' => 'required'
    ]);

    // data lama
    $barangKeluar = BarangKeluar::findOrFail($id);

    // rollback stok lama
    $barangLama = Barang::find($barangKeluar->barang_id);

    $barangLama->stok += $barangKeluar->jumlah;

    $barangLama->save();

    // cek stok barang baru
    $barangBaru = Barang::find($request->barang_id);

    if ($barangBaru->stok < $request->jumlah) {

        return redirect()
            ->back()
            ->with('error', 'Stok tidak mencukupi');

    }

    // update transaksi
    $barangKeluar->update([
        'barang_id' => $request->barang_id,
        'jumlah' => $request->jumlah,
        'tanggal_keluar' => $request->tanggal_keluar,
        'tujuan' => $request->tujuan,
    ]);

    // kurangi stok baru
    $barangBaru->stok -= $request->jumlah;

    $barangBaru->save();

    return redirect()
        ->back()
        ->with('success', 'Barang keluar berhasil diupdate');
}
    // hapus barang keluar
    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        // kembalikan stok
        $barang = Barang::find($barangKeluar->barang_id);

        $barang->stok += $barangKeluar->jumlah;

        $barang->save();

        // hapus transaksi
        $barangKeluar->delete();

        return redirect()
            ->back()
            ->with('success', 'Data berhasil dihapus');
    }
}