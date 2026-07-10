<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOut;
use App\Models\JobOutDetail;
use App\Models\Produk;
use App\Models\Bom;
use App\Models\Barang;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;

class JobOutController extends Controller
{
    // =========================
    // HALAMAN JOB OUT
    // =========================

    public function index()
    {
        $produk = Produk::all();

        $jobOut = JobOut::with([
            'produk',
            'details.barang'
        ])
        ->latest()
        ->get();

        return view(
            'job_out',
            compact(
                'produk',
                'jobOut'
            )
        );
    }

    // =========================
    // SIMPAN JOB OUT MANUAL
    // =========================

    public function store(Request $request)
    {
        $request->validate([

            'produk_id' => 'required',

            'vendor' => 'required',

            'tanggal' => 'required'

        ]);

        // =========================
        // NOMOR SURAT
        // =========================

        $last = JobOut::orderBy('id', 'desc')->first();

        if ($last) {

            $pecah = explode('/', $last->no_surat);

            $nomor = (int) end($pecah) + 1;

        } else {

            $nomor = 1;
        }

        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $cabang = auth()->user()->cabang;

        $kodeCabang = match ($cabang) {

            'Lawang'  => 'LWG',

            'Pandaan' => 'PDN',

            default   => strtoupper(substr($cabang, 0, 3))
        };

        $kode =
            'SJ/' .
            $kodeCabang .
            '/' .
            $bulanRomawi[now()->month] .
            '/' .
            str_pad(
                $nomor,
                4,
                '0',
                STR_PAD_LEFT
            );
    }

    // =========================
    // DOWNLOAD PDF RIWAYAT
    // =========================

    public function pdf($id)
    {
        $job = JobOut::with([
            'produk',
            'details.barang'
        ])
        ->findOrFail($id);

        $hasil = [];

        foreach($job->details as $detail){

            $hasil[] = [

                'bahan' =>
                    $detail->barang->nama,

                'qty_roll' =>
                    $detail->qty,

                'satuan' =>
                    $detail->satuan
            ];
        }

            $pdf = Pdf::loadView(
                'job_out_pdf',
                [

                    'job' => $job,

                    'produk' => $job->produk,

                    'hasil' => $hasil,

                    'qty_produksi' => 0

                ]
            )->setPaper(
                'A5',
                'landscape'
            );


            return $pdf->download(
                str_replace('/', '-', $job->no_surat) . '.pdf'
            );
    }

    // =========================
    // GENERATE PDF DARI BOM
    // =========================

    public function generatePdf(Request $request)
    {
        $produk = Produk::find(
            $request->produk_id
        );

        // =========================
        // AMBIL BOM
        // =========================

        $bom = Bom::with('details.barang')
            ->where(
                'produk_id',
                $request->produk_id
            )
            ->get();

        // =========================
        // NOMOR SURAT
        // =========================

        $last = JobOut::orderBy('id', 'desc')->first();

            if ($last) {

                $pecah = explode('/', $last->no_surat);

                $nomor = (int) end($pecah) + 1;

            } else {

                $nomor = 1;
            }

        $bulanRomawi = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII'
        ];

        $cabang = auth()->user()->cabang;

        $kodeCabang = match ($cabang) {

            'Lawang'  => 'LWG',

            'Pandaan' => 'PDN',

            default   => strtoupper(substr($cabang, 0, 3))
        };

        $kode =
            'SJ/' .
            $kodeCabang .
            '/' .
            $bulanRomawi[now()->month] .
            '/' .
            str_pad(
                $nomor,
                4,
                '0',
                STR_PAD_LEFT
            );

        // =========================
        // SIMPAN HEADER
        // =========================

        $job = JobOut::create([

            'no_surat' => $kode,

            'produk_id' =>
                $request->produk_id,

            'vendor' => $request->kepada,

            'ekspedisi' => $request->no_polisi,

            'tanggal' =>
                now()->toDateString(),

            'status' => 'Dikirim',

            'catatan' => $request->alamat,

            'cabang' =>
                auth()->user()->cabang

        ]);

        $hasil = [];

        // =========================
        // LOOP MATERIAL
        // =========================

        foreach($bom as $item){

            if(
                $request->mode == 'komponen'
                &&
                $request->komponen
            ){

                if(
                    $item->nama_komponen
                    != $request->komponen
                ){

                    continue;
                }
            }

            foreach($item->details as $detail){

                // =========================
                // HITUNG QTY ROLL
                // =========================

                $totalMeter =
                    (
                        $detail->qty *
                        $request->qty_produksi
                    ) / 100;

                $isiRoll =
                    $detail->barang->isi_per_satuan ?: 1;

                $qtyRoll =
                    ceil(
                        $totalMeter / $isiRoll
                    );

                // =========================
                // SIMPAN DETAIL
                // =========================

                JobOutDetail::create([

                    'job_out_id' =>
                        $job->id,

                    'barang_id' =>
                        $detail->barang_id,

                    'qty' =>
                        $qtyRoll,

                    'satuan' =>
                        'ROLL'
                ]);

                // =========================
                // KURANGI STOK
                // =========================

                $barang = Barang::find(
                    $detail->barang_id
                );

                if($barang){

                    $barang->jumlah_roll -=
                        $qtyRoll;

                    if(
                        $barang->jumlah_roll < 0
                    ){

                        $barang->jumlah_roll = 0;
                    }

                    $barang->save();
                }

                // =========================
                // BARANG KELUAR
                // =========================

                BarangKeluar::create([

                    'barang_id' =>
                        $detail->barang_id,

                    'jumlah' =>
                        0,

                    'jumlah_roll' =>
                        $qtyRoll,

                    'tanggal_keluar' =>
                        now(),

                    'tujuan' =>
                        'SURAT JALAN - ' .
                        $request->kepada
                ]);

                // =========================
                // DATA PDF
                // =========================

                $hasil[] = [

                    'bahan' =>
                        $detail->barang->nama,

                    'qty_roll' =>
                        $qtyRoll,

                    'satuan' =>
                        'ROLL'
                ];
            }
        }

        // =========================
        // GENERATE PDF
        // =========================

            $pdf = Pdf::loadView(
                'job_out_pdf',
                [
                    'job' => $job,

                    'produk' => $job->produk,

                    'hasil' => $hasil,

                    'kepada' => $request->kepada,

                    'alamat' => $request->alamat,

                    'no_polisi' => $request->no_polisi,

                    'dibuat_oleh' =>
                        $request->dibuat_oleh,

                    'tanggal_jam' =>
                        now()->format('d-m-Y H:i'),

                    'qty_produksi' => 0
                ]
            )->setPaper(
                'A5',
                'landscape'
            );

            return $pdf->download(
                str_replace('/', '-', $job->no_surat) . '.pdf'
            );
    }
}