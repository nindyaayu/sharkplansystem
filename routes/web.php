<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| PUBLIC 
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('login');
});

Route::post('/login', [AuthController::class, 'login']);


/*
|--------------------------------------------------------------------------
| PROTECTED (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // ===== DASHBOARD =====
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // ===== MENU UTAMA =====
    Route::get('/bahan', fn() => view('bahan'));
    Route::get('/produk', fn() => view('produk'));
    Route::get('/bom', fn() => view('bom'));

    // ===== INVENTORI =====
    Route::get('/inventori', fn() => view('inventori'));
    Route::get('/barang-masuk', fn() => view('barang_masuk'));
    Route::get('/barang-keluar', fn() => view('barang_keluar'));

    // ===== LAPORAN GRAFIK =====
    Route::get('/laporan', function () {

        $labels = ['01','05','10','15','20','25','30'];
        $masuk  = [20,60,30,80,70,90,75];
        $keluar = [10,40,20,50,65,50,45];

        return view('laporan', compact('labels','masuk','keluar'));
    });

    // ===== LAPORAN STOK AKHIR (PDF STYLE) =====
    Route::get('/laporan-stok', fn() => view('laporan_stok'));

    // ===== MENU LAIN =====
    Route::get('/pengguna', fn() => view('pengguna'));
    Route::get('/pengaturan', fn() => view('pengaturan'));

    // ===== LOGOUT =====
    Route::get('/logout', [AuthController::class, 'logout']);
});