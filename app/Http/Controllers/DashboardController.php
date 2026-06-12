<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Barang;
use App\Models\Produk;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // =========================
        // ADMIN PUSAT
        // =========================

        if (is_null($user->cabang)) {

            $totalBahan = Barang::count();

            $bahanBaru = Barang::whereDate(
                'created_at',
                Carbon::today()
            )->count();

            $totalProduk = Produk::count();

            $totalStok = Barang::sum('stok');

            $totalTransaksi =
                BarangMasuk::count() +
                BarangKeluar::count();

            $stokKritis = Barang::where(
                'stok',
                '<=',
                5
            )->count();

            $barangMasukChart = [];
            $barangKeluarChart = [];

            for ($i = 1; $i <= 12; $i++) {

                $barangMasukChart[] =
                    BarangMasuk::whereMonth(
                        'tanggal_masuk',
                        $i
                    )->sum('jumlah');

                $barangKeluarChart[] =
                    BarangKeluar::whereMonth(
                        'tanggal_keluar',
                        $i
                    )->sum('jumlah');
            }
        }

        // =========================
        // USER CABANG
        // =========================

        else {

            $cabang = $user->cabang;

            $totalBahan = Barang::where(
                'cabang',
                $cabang
            )->count();

            $bahanBaru = Barang::where(
                'cabang',
                $cabang
            )
            ->whereDate(
                'created_at',
                Carbon::today()
            )
            ->count();

            $totalProduk = Produk::where(
                'cabang',
                $cabang
            )->count();

            $totalStok = Barang::where(
                'cabang',
                $cabang
            )->sum('stok');

            $totalTransaksi =
                BarangMasuk::where(
                    'cabang',
                    $cabang
                )->count()
                +
                BarangKeluar::where(
                    'cabang',
                    $cabang
                )->count();

            $stokKritis = Barang::where(
                'cabang',
                $cabang
            )
            ->where(
                'stok',
                '<=',
                5
            )
            ->count();

            $barangMasukChart = [];
            $barangKeluarChart = [];

            for ($i = 1; $i <= 12; $i++) {

                $barangMasukChart[] =
                    BarangMasuk::where(
                        'cabang',
                        $cabang
                    )
                    ->whereMonth(
                        'tanggal_masuk',
                        $i
                    )
                    ->sum('jumlah');

                $barangKeluarChart[] =
                    BarangKeluar::where(
                        'cabang',
                        $cabang
                    )
                    ->whereMonth(
                        'tanggal_keluar',
                        $i
                    )
                    ->sum('jumlah');
            }
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