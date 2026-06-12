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
    public function index(Request $request)
    {
        $query = Barang::query();

        // Filter Kode
        if ($request->filled('kode')) {
            $query->where(
                'kode',
                'like',
                '%' . $request->kode . '%'
            );
        }

        // Filter Nama Barang
        if ($request->filled('nama')) {
            $query->where(
                'nama',
                'like',
                '%' . $request->nama . '%'
            );
        }

        // Filter Warna
        if ($request->filled('warna')) {
            $query->where(
                'warna',
                'like',
                '%' . $request->warna . '%'
            );
        }

        $data = $query->latest()->get();

        // Filter Status
        if ($request->filled('status')) {

            if ($request->status == 'habis') {

                $data = $data->where('jumlah_meter', 0);

            } elseif ($request->status == 'menipis') {

                $data = $data->where('jumlah_meter', '>', 0)
                             ->where('jumlah_meter', '<=', 500);

            } elseif ($request->status == 'aman') {

                $data = $data->where('jumlah_meter', '>', 500);
            }
        }

        return view('laporan', compact('data'));
    }

    // =========================
    // EXPORT PDF
    // =========================
    public function exportPdf(Request $request)
    {
        $query = Barang::query();

        if ($request->filled('kode')) {
            $query->where(
                'kode',
                'like',
                '%' . $request->kode . '%'
            );
        }

        if ($request->filled('nama')) {
            $query->where(
                'nama',
                'like',
                '%' . $request->nama . '%'
            );
        }

        if ($request->filled('warna')) {
            $query->where(
                'warna',
                'like',
                '%' . $request->warna . '%'
            );
        }

        $data = $query->latest()->get();

        if ($request->filled('status')) {

            if ($request->status == 'habis') {

                $data = $data->where('jumlah_meter', 0);

            } elseif ($request->status == 'menipis') {

                $data = $data->where('jumlah_meter', '>', 0)
                             ->where('jumlah_meter', '<=', 500);

            } elseif ($request->status == 'aman') {

                $data = $data->where('jumlah_meter', '>', 500);
            }
        }

   $pdf = Pdf::loadView(
        'job_out_pdf',
        [

            'job' => $job,

            'produk' => $job->produk,

            'hasil' => $hasil,

            'kepada' => $request->kepada,

            'alamat' => $request->alamat,

            'no_polisi' => $request->no_polisi,

            'dibuat_oleh' => $request->dibuat_oleh,

            'tanggal_jam' =>
                now()->format('d-m-Y H:i'),

            'qty_produksi' => 0

        ]
    )->setPaper(
        'A5',
        'landscape'
    );

        return $pdf->download(
            'laporan-material-utama.pdf'
        );
    }
}