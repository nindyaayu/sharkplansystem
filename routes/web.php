<?php

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
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
use App\Http\Controllers\JobOutController;
use App\Http\Controllers\SuratJalanController;
use App\Http\Controllers\PermintaanBarangController;
use App\Http\Controllers\PelacakanBarangController;
use App\Http\Controllers\KomponenProdukController;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\HasilCutting;
use App\Models\Produk;

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

    // semua bahan
    Route::get('/bahan', [BarangController::class, 'index']);

    // material utama
    Route::get('/material-utama', function () {

    $query = Barang::where(
        'kategori',
        'Kain'
    );

    if(request('sort') == 'za'){

        $query->orderBy('nama', 'desc');

    } elseif(request('sort') == 'new'){

        $query->latest();

    } elseif(request('sort') == 'old'){

        $query->oldest();

    } else {

        $query->orderBy('nama', 'asc');

    }

    $data = $query->get();

    return view('bahan', compact('data'));

});

    // material pendukung
    Route::get('/material-pendukung', function () {

    $query = Barang::where(
        'kategori',
        'Aksesoris'
    );

    if(request('sort') == 'za'){

        $query->orderBy('nama', 'desc');

    } elseif(request('sort') == 'new'){

        $query->latest();

    } elseif(request('sort') == 'old'){

        $query->oldest();

    } else {

        $query->orderBy('nama', 'asc');

    }

    $data = $query->get();

    return view('bahan', compact('data'));

});

    // tambah bahan
    Route::post('/bahan', [BarangController::class, 'store']);

    // edit bahan
    Route::put('/bahan/{id}', [BarangController::class, 'update']);

    // hapus bahan
    Route::delete('/bahan/{id}', [BarangController::class, 'destroy']);

    // =========================
    // PRODUK
    // =========================

    Route::get('/produk', [ProdukController::class, 'index']);

    Route::post('/produk', [ProdukController::class, 'store']);
    Route::put('/produk/{id}', [ProdukController::class, 'update']);
    Route::delete('/produk/{id}', [ProdukController::class, 'destroy']);

    // =========================
    // KOMPONEN PRODUK
    // =========================

    Route::post(
        '/komponen-produk',
        [KomponenProdukController::class, 'store']
    );

    Route::get(
        '/komponen-produk/{produkId}',
        [KomponenProdukController::class, 'getKomponen']
    );

    Route::put(
        '/komponen-produk/{id}',
        [KomponenProdukController::class, 'update']
    );

    Route::delete(
        '/komponen-produk/{id}',
        [KomponenProdukController::class, 'destroy']
    );

    // =========================
    // SUB KOMPONEN
    // =========================

    Route::post(
        '/sub-komponen',
        [KomponenProdukController::class, 'storeSubKomponen']
    );

    Route::get(
        '/sub-komponen/{parentId}',
        [KomponenProdukController::class, 'getSubKomponen']
    );

    Route::put(
        '/sub-komponen/{id}',
        [KomponenProdukController::class, 'update']
    );

    Route::delete(
        '/sub-komponen/{id}',
        [KomponenProdukController::class, 'destroy']
    );
    // ==================================================
    // MASTER BOM
    // ==================================================

    Route::get('/master-bom', [BomController::class, 'index'])
        ->name('master-bom');

    Route::post('/master-bom', [BomController::class, 'store'])
        ->name('master-bom.store');
    Route::put('/master-bom/{id}', [BomController::class, 'update'])
        ->name('master-bom.update');

    Route::post('/bom-detail', [BomController::class, 'storeDetail'])
        ->name('bom-detail.store');

    Route::put('/bom-detail/{id}', [BomController::class, 'updateDetail'])
        ->name('bom-detail.update');

    Route::delete('/bom-detail/{id}', [BomController::class, 'destroyDetail'])
        ->name('bom-detail.destroy');

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

    Route::get('/produksi', [ProduksiController::class, 'index'])
        ->name('produksi');

    Route::post('/produksi', [ProduksiController::class, 'store'])
        ->name('produksi.store');

    Route::post('/produksi/proses/{id}', [ProduksiController::class, 'proses'])
        ->name('produksi.proses');

    // =========================
    // PERMINTAAN BARANG
    // =========================

        Route::get(
            '/permintaan-barang',
            [PermintaanBarangController::class, 'index']
        )->name('permintaan-barang');

        Route::post(
            '/permintaan-barang',
            [PermintaanBarangController::class, 'store']
        )->name('permintaan-barang.store');

        Route::put(
            '/permintaan-barang/{id}',
            [PermintaanBarangController::class, 'update']
        )->name('permintaan-barang.update');

        Route::delete(
            '/permintaan-barang/{id}',
            [PermintaanBarangController::class, 'destroy']
        )->name('permintaan-barang.destroy');


        Route::get(
            '/permintaan-barang/{id}',
            [PermintaanBarangController::class, 'show']
        )->name('permintaan-barang.show');
        
        Route::put(
            '/permintaan-barang-detail/{id}',
            [PermintaanBarangController::class, 'updateDetailStatus']
        )->name('permintaan-barang-detail.update');

            // =========================
            // ketik barang di permimntaan barang
            // =========================

        Route::get('/search-barang', function () {

            return \App\Models\Barang::select(
                'id',
                'kode',
                'nama',
                'warna',
                'stok',
                'satuan'
            )
            ->where(function($q){

                $q->where(
                    'nama',
                    'like',
                    '%' . request('q') . '%'
                )
                ->orWhere(
                    'kode',
                    'like',
                    '%' . request('q') . '%'
                );

            })
            ->limit(20)
            ->get()
            ->map(function($item){

                return [

                    'id' => $item->id,

                    'text' =>
                        $item->kode .
                        ' | ' .
                        $item->nama .
                        ' | ' .
                        $item->warna .
                        ' | ' .
                        number_format($item->stok) .
                        ' ' .
                        strtoupper($item->satuan)

                ];

            });

        });
    // =========================
    // INVENTORI
    // =========================

    Route::get('/inventori', fn() => view('inventori'));

    /*
    |--------------------------------------------------------------------------
    | BARANG MASUK
    |--------------------------------------------------------------------------
    */

    // =========================
    // MATERIAL UTAMA
    // =========================


        Route::get('/barang-masuk-material-utama', function (Request $request) {

    $query = \App\Models\BarangMasuk::with('barang')
        ->whereHas('barang', function ($q) {

            $q->where('kategori', 'Kain');

        });

        if (auth()->user()->cabang) {

        $query->where(
            'cabang',
            auth()->user()->cabang
        );

    }

    // FILTER PERIODE

    if (
        $request->filled('tanggal_awal')
        &&
        $request->filled('tanggal_akhir')
    ) {

        $query->whereBetween(
            'tanggal_masuk',
            [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]
        );

    }

    $barangMasuks = $query
        ->latest()
        ->get();

    $barangs = Barang::where(
        'kategori',
        'Kain'
    )->get();

    $totalTransaksi = $barangMasuks->count();

    $totalQty = $barangMasuks->sum('jumlah');

    $hariIni = $barangMasuks->where(
        'tanggal_masuk',
        now()->format('Y-m-d')
    )->count();

    $bulanIni = $barangMasuks->filter(function($item){

        return \Carbon\Carbon::parse(
            $item->tanggal_masuk
        )->month == now()->month;

    })->count();

    return view('barang_masuk', compact(
        'barangMasuks',
        'barangs',
        'totalTransaksi',
        'totalQty',
        'hariIni',
        'bulanIni'
    ));

})->name('barang-masuk-material-utama');
// =========================
// EXPORT PDF MATERIAL UTAMA
// =========================

Route::get('/barang-masuk-material-utama-pdf', function (Request $request) {

    $query = \App\Models\BarangMasuk::with('barang')
        ->whereHas('barang', function ($q) {

            $q->where('kategori', 'Kain');

        });

    if (
        $request->filled('tanggal_awal')
        &&
        $request->filled('tanggal_akhir')
    ) {

        $query->whereBetween(
            'tanggal_masuk',
            [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]
        );

    }

    $rawData = $query
        ->latest()
        ->get();

    $data = $rawData
    ->groupBy('barang_id')
    ->map(function($items){

        $first = $items->first();

        $totalJumlah =
            $items->sum('jumlah_roll')
            +
            $items->sum('jumlah');

        $supplier =
            $items
                ->pluck('supplier')
                ->filter()
                ->unique()
                ->implode(', ');

            return (object)[

                'kode' =>
                    $first->barang->kode,

                'nama' =>
                    $first->barang->nama,

                'supplier' =>
                    $supplier,

                'roll' =>
                    $items->sum('jumlah_roll'),

                'meter' =>
                    $items->sum('jumlah'),

            ];

        });

    $pdf = Pdf::loadView(
    'barang_masuk_utama_pdf',
        [
            'data' => $data,
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir
        ]
    );

    return $pdf->download(
        'barang-masuk-material-utama.pdf'
    );

})->name('barang-masuk-material-utama-pdf');


    // =========================
    // MATERIAL PENDUKUNG
    // =========================

    Route::get('/barang-masuk-material-pendukung', function (Request $request) {

        $query = \App\Models\BarangMasuk::with('barang')
            ->whereHas('barang', function ($q) {

                $q->where('kategori', 'Aksesoris');

            });

            if (auth()->user()->cabang) {

            $query->where(
                'cabang',
                auth()->user()->cabang
            );

        }

        // FILTER TANGGAL

        if (
            $request->filled('tanggal_awal')
            &&
            $request->filled('tanggal_akhir')
        ) {

            $query->whereBetween(
                'tanggal_masuk',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );

        }

        $barangMasuks = $query
            ->latest()
            ->get();

        $barangs = Barang::where(
            'kategori',
            'Aksesoris'
        )->get();

        // STATISTIK

        $totalTransaksi = $barangMasuks->count();

        $totalQty = $barangMasuks->sum('jumlah');

        $hariIni = $barangMasuks->where(
            'tanggal_masuk',
            now()->format('Y-m-d')
        )->count();

        $bulanIni = $barangMasuks->filter(function($item){

            return \Carbon\Carbon::parse(
                $item->tanggal_masuk
            )->month == now()->month;

        })->count();

        return view('barang_masuk', compact(
            'barangMasuks',
            'barangs',
            'totalTransaksi',
            'totalQty',
            'hariIni',
            'bulanIni'
        ));

    })->name('barang-masuk-material-pendukung');

    // =========================
    // STORE
    // =========================

    Route::post('/barang-masuk', [BarangMasukController::class, 'store'])
        ->name('barang-masuk.store');

    // =========================
    // DELETE
    // =========================

    Route::delete('/barang-masuk/{id}', [BarangMasukController::class, 'destroy'])
        ->name('barang-masuk.destroy');

    // =========================
    // UPDATE
    // =========================

    Route::put('/barang-masuk/{id}', [BarangMasukController::class, 'update'])
        ->name('barang-masuk.update');

// =========================
// EXPORT PDF MATERIAL PENDUKUNG
// =========================

Route::get('/barang-masuk-material-pendukung-pdf', function (\Illuminate\Http\Request $request) {

    $query = \App\Models\BarangMasuk::with('barang')
        ->whereHas('barang', function ($q) {

            $q->where('kategori', 'Aksesoris');

        });

    if (
    $request->filled('tanggal_awal')
    &&
    $request->filled('tanggal_akhir')
    ) {

        $query->whereBetween(
            'tanggal_masuk',
            [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]
        );

    }

    $rawData = $query
        ->latest()
        ->get();

    $data = $rawData
        ->groupBy('barang_id')
        ->map(function($items){

            $first = $items->first();

            $totalJumlah =
                $items->sum('jumlah');

            $supplier =
                $items
                    ->groupBy('supplier')
                    ->map(function($s){

                        return
                            $s->first()->supplier .
                            ' (' .
                            $s->sum('jumlah') .
                            ')';

                    })
                    ->implode(', ');

            return (object)[

                'kode'    => $first->barang->kode,
                'nama'    => $first->barang->nama,
                'supplier'=> $supplier,
                'jumlah'  => $totalJumlah,
                'satuan'  => $first->barang->satuan,

            ];

        });

    $pdf = Pdf::loadView(
    'barang_masuk_pdf',
    [
        'data' => $data,
        'tanggal_awal' => $request->tanggal_awal,
        'tanggal_akhir' => $request->tanggal_akhir
    ]
);

    return $pdf->download(
        'barang-masuk-material-pendukung.pdf'
    );

})->name('barang-masuk-material-pendukung-pdf');

    /*
    |--------------------------------------------------------------------------
    | BARANG KELUAR
    |--------------------------------------------------------------------------
    */

    // =========================
    // MATERIAL UTAMA
    // =========================

    Route::get('/barang-keluar-material-utama', function (Request $request) {

        $query = \App\Models\BarangKeluar::with('barang')
            ->whereHas('barang', function ($q) {

                $q->where('kategori', 'Kain');

            });

            if (auth()->user()->cabang) {

                $query->where(
                    'cabang',
                    auth()->user()->cabang
                );

            }

        if (
            $request->filled('tanggal_awal')
            &&
            $request->filled('tanggal_akhir')
        ) {

            $query->whereBetween(
                'tanggal_keluar',
                [
                    $request->tanggal_awal,
                    $request->tanggal_akhir
                ]
            );

        }

        $barangKeluars = $query
            ->latest()
            ->get();

        $barangs = Barang::where(
            'kategori',
            'Kain'
        )->get();

        $produks = \App\Models\Produk::all();

        return view(
            'barang_keluar',
            compact(
                'barangKeluars',
                'barangs',
                'produks'
            )
        );

    })->name('barang-keluar-material-utama');

    // =========================
    // EXPORT PDF MATERIAL UTAMA
    // =========================

    Route::get('/barang-keluar-material-utama-pdf', function (Request $request) {

            $query = \App\Models\BarangKeluar::with('barang')
                ->whereHas('barang', function ($q) {

                    $q->where('kategori', 'Kain');

                });

                if (auth()->user()->cabang) {

                $query->where(
                    'cabang',
                    auth()->user()->cabang
                );

            }

            if (
                $request->filled('tanggal_awal')
                &&
                $request->filled('tanggal_akhir')
            ) {

                $query->whereBetween(
                    'tanggal_keluar',
                    [
                        $request->tanggal_awal,
                        $request->tanggal_akhir
                    ]
                );

            }

            $data = $query
                ->latest()
                ->get();

            $pdf = Pdf::loadView(
                'barang_keluar_utama_pdf',
                [
                    'data' => $data,
                    'tanggal_awal' => $request->tanggal_awal,
                    'tanggal_akhir' => $request->tanggal_akhir
                ]
            );

            return $pdf->download(
                'barang-keluar-material-utama.pdf'
            );

        })->name('barang-keluar-material-utama-pdf');

    // =========================
    // MATERIAL PENDUKUNG
    // =========================

    Route::get('/barang-keluar-material-pendukung', function (Request $request) {

            $query = \App\Models\BarangKeluar::with('barang')
                ->whereHas('barang', function ($q) {

                    $q->where('kategori', 'Aksesoris');

                });
                if (auth()->user()->cabang) {

                    $query->where(
                        'cabang',
                        auth()->user()->cabang
                    );

                }

                if (auth()->user()->cabang) {

                    $query->where(
                        'cabang',
                        auth()->user()->cabang
                    );

                }

            if (
                $request->filled('tanggal_awal')
                &&
                $request->filled('tanggal_akhir')
            ) {

                $query->whereBetween(
                    'tanggal_keluar',
                    [
                        $request->tanggal_awal,
                        $request->tanggal_akhir
                    ]
                );

            }

            $barangKeluars = $query
                ->latest()
                ->get();

            $barangs = Barang::where(
                'kategori',
                'Aksesoris'
            )->get();

            $produks = \App\Models\Produk::all();

            return view(
                'barang_keluar',
                compact(
                    'barangKeluars',
                    'barangs',
                    'produks'
                )
            );

        })->name('barang-keluar-material-pendukung');

        // =========================
        // EXPORT PDF MATERIAL PENDUKUNG
        // =========================

        Route::get('/barang-keluar-material-pendukung-pdf', function (Request $request) {

            $query = \App\Models\BarangKeluar::with('barang')
                ->whereHas('barang', function ($q) {

                    $q->where('kategori', 'Aksesoris');

                });
                if (auth()->user()->cabang) {

                $query->where(
                    'cabang',
                    auth()->user()->cabang
                );

            }

                if (auth()->user()->cabang) {

                $query->where(
                    'cabang',
                    auth()->user()->cabang
                );

            }

            if (
                $request->filled('tanggal_awal')
                &&
                $request->filled('tanggal_akhir')
            ) {

                $query->whereBetween(
                    'tanggal_keluar',
                    [
                        $request->tanggal_awal,
                        $request->tanggal_akhir
                    ]
                );

            }

            $data = $query
                ->latest()
                ->get();

            $pdf = Pdf::loadView(
                'barang_keluar_pendukung_pdf',
                [
                    'data' => $data,
                    'tanggal_awal' => $request->tanggal_awal,
                    'tanggal_akhir' => $request->tanggal_akhir
                ]
            );

            return $pdf->download(
                'barang-keluar-material-pendukung.pdf'
            );

        })->name('barang-keluar-material-pendukung-pdf');

    // =========================
    // STORE
    // =========================

    Route::post('/barang-keluar', [BarangKeluarController::class, 'store'])
        ->name('barang-keluar.store');

    // =========================
    // DELETE
    // =========================

    Route::delete('/barang-keluar/{id}', [BarangKeluarController::class, 'destroy'])
        ->name('barang-keluar.destroy');

    // =========================
    // UPDATE
    // =========================

    Route::put('/barang-keluar/{id}', [BarangKeluarController::class, 'update'])
        ->name('barang-keluar.update');
    // =========================
    // JOB OUT
    // =========================

    Route::get('/job-out', [JobOutController::class, 'index'])
        ->name('job-out');

    Route::post('/job-out', [JobOutController::class, 'store'])
        ->name('job-out.store');
    Route::get(
        '/job-out/generate-pdf',
        [JobOutController::class, 'generatePdf']
    )->name('job-out.generate');

    Route::get(
        '/surat-jalan',
        [SuratJalanController::class, 'index']
    )->name('surat-jalan');

// =========================
// PELACAKAN BARANG
// =========================
    Route::get(
    '/pelacakan-barang',
    [PelacakanBarangController::class, 'index']
);
// =========================
// LAPORAN MATERIAL UTAMA
// =========================
    Route::get('/laporan-material-utama', function (Request $request) {

    $tanggal = $request->tanggal;

    $data = Barang::where(
        'kategori',
        'Kain'
    )->get();

    // =========================
    // HITUNG STOK BERDASARKAN TANGGAL
    // =========================

    foreach($data as $item){

        // =========================
        // TOTAL MASUK
        // =========================

        $totalMasukRoll =
            $item->barangMasuk()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_masuk',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah_roll');

        $totalMasukMeter =
            $item->barangMasuk()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_masuk',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        // =========================
        // TOTAL KELUAR
        // =========================

        $totalKeluarRoll =
            $item->barangKeluar()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_keluar',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah_roll');

        $totalKeluarMeter =
            $item->barangKeluar()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_keluar',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        // =========================
        // STOK AKHIR
        // =========================

        $item->jumlah_roll =
            $totalMasukRoll -
            $totalKeluarRoll;

        $item->jumlah_meter =
            $totalMasukMeter -
            $totalKeluarMeter;
    }

    return view(
        'laporan_material_utama',
        compact(
            'data',
            'tanggal'
        )
    );

})->name('laporan-material-utama');
Route::get('/laporan-material-utama-pdf', function (Request $request) {

    $tanggal = $request->tanggal;

    $kode   = $request->kode;
    $nama   = $request->nama;
    $warna  = $request->warna;
    $status = $request->status;

    $query = Barang::where(
        'kategori',
        'Kain'
    );

    if ($kode) {
        $query->where(
            'kode',
            'like',
            "%{$kode}%"
        );
    }

    if ($nama) {
        $query->where(
            'nama',
            'like',
            "%{$nama}%"
        );
    }

    if ($warna) {
        $query->where(
            'warna',
            'like',
            "%{$warna}%"
        );
    }

    $data = $query->get();

    foreach($data as $item){

        // TOTAL MASUK

        $totalMasukRoll =
            $item->barangMasuk()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_masuk',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah_roll');

        $totalMasukMeter =
            $item->barangMasuk()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_masuk',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        // TOTAL KELUAR

        $totalKeluarRoll =
            $item->barangKeluar()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_keluar',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah_roll');

        $totalKeluarMeter =
            $item->barangKeluar()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_keluar',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        // STOK AKHIR

        $item->jumlah_roll =
            $totalMasukRoll -
            $totalKeluarRoll;

        $item->jumlah_meter =
            $totalMasukMeter -
            $totalKeluarMeter;
    }

    if ($status == 'Habis') {

    $data = $data->filter(function ($item) {
        return $item->jumlah_meter == 0;
    });

} elseif ($status == 'Menipis') {

    $data = $data->filter(function ($item) {
        return $item->jumlah_meter > 0
            && $item->jumlah_meter <= 500;
    });

} elseif ($status == 'Aman') {

    $data = $data->filter(function ($item) {
        return $item->jumlah_meter > 500;
    });

}
$pdf = Pdf::loadView(
        'laporan_material_utama_pdf',
        compact(
            'data',
            'tanggal'
        )
    );

    return $pdf->download(
        'laporan-material-utama.pdf'
    );

});
// =========================
        // ROUTE LAPORAN MATERIAL PENDUKUNG
        // =========================
Route::get('/laporan-material-pendukung', function (Request $request) {

    $tanggal = $request->tanggal;

$kode   = $request->kode;
$nama   = $request->nama;
$warna  = $request->warna;
$satuan = $request->satuan;
$status = $request->status;

$query = Barang::where(
    'kategori',
    'Aksesoris'
);

if ($kode) {
    $query->where('kode','like',"%{$kode}%");
}

if ($nama) {
    $query->where('nama','like',"%{$nama}%");
}

if ($warna) {
    $query->where('warna','like',"%{$warna}%");
}

if ($satuan) {
    $query->where('satuan','like',"%{$satuan}%");
}

$data = $query->get();

    foreach($data as $item){

        // =========================
        // TOTAL MASUK
        // =========================

        $totalMasuk =
            $item->barangMasuk()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_masuk',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        // =========================
        // TOTAL KELUAR
        // =========================

        $totalKeluar =
            $item->barangKeluar()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_keluar',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        // =========================
        // STOK AKHIR
        // =========================

        $item->stok =
            $totalMasuk -
            $totalKeluar;
    }

    return view(
        'laporan_material_pendukung',
        compact(
            'data',
            'tanggal'
        )
    );

})->name('laporan-material-pendukung');

Route::get('/laporan-material-pendukung-pdf', function (Request $request) {

    $tanggal = $request->tanggal;

$kode   = $request->kode;
$nama   = $request->nama;
$warna  = $request->warna;
$satuan = $request->satuan;
$status = $request->status;

$query = Barang::where(
    'kategori',
    'Aksesoris'
);

if ($kode) {
    $query->where(
        'kode',
        'like',
        "%{$kode}%"
    );
}

if ($nama) {
    $query->where(
        'nama',
        'like',
        "%{$nama}%"
    );
}

if ($warna) {
    $query->where(
        'warna',
        'like',
        "%{$warna}%"
    );
}

if ($satuan) {
    $query->where(
        'satuan',
        'like',
        "%{$satuan}%"
    );
}

$data = $query->get();

    foreach($data as $item){

        $totalMasuk =
            $item->barangMasuk()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_masuk',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        $totalKeluar =
            $item->barangKeluar()
                ->when($tanggal, function($q) use ($tanggal){

                    $q->whereDate(
                        'tanggal_keluar',
                        '<=',
                        $tanggal
                    );

                })
                ->sum('jumlah');

        $item->stok =
            $totalMasuk -
            $totalKeluar;
    }
    if ($status == 'Habis') {

    $data = $data->filter(function ($item) {
        return $item->jumlah_roll == 0;
    });

}
elseif ($status == 'Menipis') {

    $data = $data->filter(function ($item) {
        return $item->jumlah_roll > 0
            && $item->jumlah_roll <= 5;
    });

}
elseif ($status == 'Aman') {

    $data = $data->filter(function ($item) {
        return $item->jumlah_roll > 5;
    });

}
    if ($status == 'Habis') {

    $data = $data->filter(function ($item) {
        return $item->stok == 0;
    });

}
elseif ($status == 'Menipis') {

    $data = $data->filter(function ($item) {
        return $item->stok > 0
            && $item->stok <= 50;
    });

}
elseif ($status == 'Aman') {

    $data = $data->filter(function ($item) {
        return $item->stok > 50;
    });

}

    $pdf = Pdf::loadView(
        'laporan_material_pendukung_pdf',
        compact(
            'data',
            'tanggal'
        )
    );

    return $pdf->download(
        'laporan-material-pendukung.pdf'
    );

});
    // =========================
    // LAPORAN PRODUKSI
    // =========================

    Route::get(
        '/laporan-produksi',
        [ProduksiController::class, 'laporan']
    )->name('laporan-produksi');

    Route::get('/hasil-cutting', function () {

    $data = HasilCutting::latest()->get();

    $produk = Produk::orderBy('nama')->get();

    return view(
        'hasil_cutting',
        compact(
            'data',
            'produk'
        )
    );

})->name('hasil-cutting');
Route::post('/hasil-cutting/store', function (Request $request) {

    HasilCutting::create([

        'tanggal'    => $request->tanggal,
        'produk'     => $request->produk,
        'komponen'   => $request->komponen,
        'hasil_pot'  => $request->hasil_pot,
        'keterangan' => $request->keterangan

    ]);

    return redirect('/hasil-cutting');

});
        Route::get('/hasil-cutting/delete/{id}', function ($id) {

            HasilCutting::findOrFail($id)->delete();

            return redirect('/hasil-cutting');

        });
        Route::get('/hasil-cutting/edit/{id}', function ($id) {

            $item = HasilCutting::findOrFail($id);

            $produk = Produk::orderBy('nama')->get();

            return view(
                'hasil_cutting_edit',
                compact(
                    'item',
                    'produk'
                )
            );

        });
        Route::post('/hasil-cutting/update/{id}', function (Request $request, $id) {

    HasilCutting::findOrFail($id)->update([

        'tanggal'    => $request->tanggal,
        'produk'     => $request->produk,
        'komponen'   => $request->komponen,
        'hasil_pot'  => $request->hasil_pot,
        'keterangan' => $request->keterangan

    ]);

    return redirect('/hasil-cutting');

});
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
        
    Route::get('/sinkron-stok-awal', function () {

    $barangs = Barang::all();

    foreach($barangs as $barang){

        $cek = BarangMasuk::where(
            'barang_id',
            $barang->id
        )
        ->first();

        if(!$cek){

            BarangMasuk::create([

                'barang_id' =>
                    $barang->id,

                'jumlah' =>
                    $barang->stok ?? 0,

                'jumlah_roll' =>
                    $barang->jumlah_roll ?? 0,

                'tanggal_masuk' =>
                    now(),

                'supplier' =>
                    'STOK AWAL',
            ]);
        }
    }

    return 'Sinkron stok awal berhasil';
});
});