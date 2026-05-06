<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BomController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProduksiController;
use App\Models\Barang;

/*
|--------------------------------------------------------------------------
| PUBLIC (LOGIN)
|--------------------------------------------------------------------------
*/

// =========================
// LOGIN
// =========================
Route::get('/login', function () {

    return view('login');

})->name('login');

Route::get('/', function () {

    return redirect()->route('login');

});

Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| PROTECTED
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // =========================
    // DASHBOARD
    // =========================
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // =========================
    // BAHAN
    // =========================
    Route::get('/bahan', [BarangController::class, 'index']);

    Route::post('/bahan', [BarangController::class, 'store']);

    Route::put('/bahan/{id}', [BarangController::class, 'update']);

    Route::delete('/bahan/{id}', [BarangController::class, 'destroy']);

    // =========================
    // PRODUK
    // =========================
    Route::get('/produk', [ProdukController::class, 'index']);

    Route::post('/produk', [ProdukController::class, 'store']);

    Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);

    // ==================================================
    // MASTER BOM
    // ==================================================

    // halaman master bom
    Route::get('/master-bom', [BomController::class, 'index'])
        ->name('master-bom');

    // simpan header bom
    Route::post('/master-bom', [BomController::class, 'store'])
        ->name('master-bom.store');

    // simpan detail bahan
    Route::post('/bom-detail', [BomController::class, 'storeDetail'])
        ->name('bom-detail.store');

    // update detail bahan
    Route::put('/bom-detail/{id}', [BomController::class, 'updateDetail'])
        ->name('bom-detail.update');

    // hapus detail bahan
    Route::delete('/bom-detail/{id}', [BomController::class, 'destroyDetail'])
        ->name('bom-detail.destroy');

    // hapus header bom
    Route::delete('/master-bom/{id}', [BomController::class, 'destroy'])
        ->name('master-bom.destroy');

    // ==================================================
    // PERHITUNGAN BOM
    // ==================================================
    Route::get('/perhitungan-bom', [BomController::class, 'perhitungan'])
        ->name('perhitungan-bom');

    // ==================================================
    // ROUTE /bom
    // ==================================================
    Route::redirect('/bom', '/master-bom');

    // ==================================================
    // PRODUKSI
    // ==================================================

    // halaman produksi
    Route::get('/produksi', [ProduksiController::class, 'index'])
        ->name('produksi');

    // simpan produksi
    Route::post('/produksi', [ProduksiController::class, 'store'])
        ->name('produksi.store');

    // proses produksi
    Route::post('/produksi/proses/{id}', [ProduksiController::class, 'proses'])
        ->name('produksi.proses');

    // =========================
    // INVENTORI
    // =========================
    Route::get('/inventori', fn() => view('inventori'));

    // =========================
    // BARANG MASUK
    // =========================
    Route::get('/barang-masuk', [BarangMasukController::class, 'index'])
        ->name('barang-masuk.index');

    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])
        ->name('barang-masuk.store');

    Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])
        ->name('barang-masuk.destroy');

    Route::put('/barang-masuk/{id}', [BarangMasukController::class, 'update'])
        ->name('barang-masuk.update');

    // =========================
    // BARANG KELUAR
    // =========================
    Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])
        ->name('barang-keluar.index');

    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])
        ->name('barang-keluar.store');

    Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])
        ->name('barang-keluar.destroy');

    Route::put('/barang-keluar/{id}', [BarangKeluarController::class, 'update'])
        ->name('barang-keluar.update');

    // =========================
    // LAPORAN
    // =========================

    // halaman laporan
    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan');

    // filter tampilkan
    Route::get('/laporan/filter', [LaporanController::class, 'filter'])
        ->name('laporan.filter');

    // export pdf
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])
        ->name('laporan.pdf');

    // =========================
    // MENU LAIN
    // =========================
    Route::get('/pengguna', fn() => view('pengguna'));

    Route::get('/pengaturan', fn() => view('pengaturan'));

    // =========================
    // LOGOUT
    // =========================
    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');

});