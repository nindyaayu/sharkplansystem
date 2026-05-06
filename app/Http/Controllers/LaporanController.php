<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // =========================
    // HALAMAN LAPORAN
    // =========================
    public function index()
    {
        $data = Barang::latest()->get();

        return view('laporan', compact('data'));
    }

    // =========================
    // FILTER TANGGAL
    // =========================
    public function filter(Request $request)
    {
        // ambil tanggal
        $tanggal = $request->tanggal;

        // sementara tetap ambil stok realtime
        $data = Barang::latest()->get();

        return view('laporan', compact(
            'data',
            'tanggal'
        ));
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function exportPdf(Request $request)
    {
        // ambil data stok
        $data = Barang::latest()->get();

        // generate pdf
        $pdf = Pdf::loadView(
            'laporan_pdf',
            compact('data')
        );

        // download pdf
        return $pdf->download(
            'laporan-stok.pdf'
        );
    }
}