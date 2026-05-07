<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Produk;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // total bahan
        $totalBahan = Barang::count();

        // bahan baru hari ini
        $bahanBaru = Barang::whereDate(
            'created_at',
            Carbon::today()
        )->count();

        // total produk
        $totalProduk = Produk::count();

        // total stok
        $totalStok = Barang::sum('stok');

        // total transaksi
        $totalTransaksi =
            BarangMasuk::count() +
            BarangKeluar::count();

        // stok kritis
        $stokKritis = Barang::where(
            'stok',
            '<=',
            5
        )->count();

        // chart barang masuk
        $barangMasukChart = [];

        for ($i = 1; $i <= 12; $i++) {

            $barangMasukChart[] =
                BarangMasuk::whereMonth(
                    'tanggal_masuk',
                    $i
                )->sum('jumlah');
        }

        // chart barang keluar
        $barangKeluarChart = [];

        for ($i = 1; $i <= 12; $i++) {

            $barangKeluarChart[] =
                BarangKeluar::whereMonth(
                    'tanggal_keluar',
                    $i
                )->sum('jumlah');
        }

        return view(
            'dashboard',
            compact(

                'totalBahan',

                'bahanBaru',

                'totalProduk',

                'totalStok',

                'totalTransaksi',

                'stokKritis',

                'barangMasukChart',

                'barangKeluarChart'

            )
        );
    }
}