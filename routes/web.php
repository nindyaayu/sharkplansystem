<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\BomController;
use App\Models\Barang;

/*
|--------------------------------------------------------------------------
| PUBLIC (LOGIN)
|--------------------------------------------------------------------------
*/

// login
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

    // ===== DASHBOARD =====
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ===== BAHAN (CRUD DATABASE) =====
    Route::get('/bahan', [BarangController::class, 'index']);
    Route::post('/bahan', [BarangController::class, 'store']);
    Route::put('/bahan/{id}', [BarangController::class, 'update']);
    Route::delete('/bahan/{id}', [BarangController::class, 'destroy']);

    // ===== MENU LAIN =====
    Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/produk', [ProdukController::class, 'store']);
Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);
    Route::get('/bom', [BomController::class, 'index'])
    ->name('bom.index');

Route::post('/bom', [BomController::class, 'store'])
    ->name('bom.store');

    // ===== INVENTORI =====
    Route::get('/inventori', fn() => view('inventori'));

    // ===== BARANG MASUK =====
Route::get('/barang-masuk', [BarangMasukController::class, 'index'])
    ->name('barang-masuk.index');

Route::post('/barang-masuk', [BarangMasukController::class, 'store'])
    ->name('barang-masuk.store');

Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])
    ->name('barang-masuk.destroy');
Route::put('/barang-masuk/{id}', [BarangMasukController::class, 'update'])
    ->name('barang-masuk.update');

// ===== BARANG KELUAR =====
Route::get('/barang-keluar', [BarangKeluarController::class, 'index'])
    ->name('barang-keluar.index');

Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])
    ->name('barang-keluar.store');

Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])
    ->name('barang-keluar.destroy');
Route::put('/barang-keluar/{id}', [BarangKeluarController::class, 'update'])
    ->name('barang-keluar.update');

    // ===== PROSES STOK =====
    //Route::post('/barang-masuk', [BarangMasukController::class, 'store']);
    //Route::post('/barang-keluar', [BarangKeluarController::class, 'store']);

    // ===== LAPORAN =====
    Route::get('/laporan', function () {
        $labels = ['01','05','10','15','20','25','30'];
        $masuk  = [20,60,30,80,70,90,75];
        $keluar = [10,40,20,50,65,50,45];

        return view('laporan', compact('labels','masuk','keluar'));
    });

    // ===== MENU LAIN =====
    Route::get('/pengguna', fn() => view('pengguna'));
    Route::get('/pengaturan', fn() => view('pengaturan'));

    // ===== LOGOUT =====
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});