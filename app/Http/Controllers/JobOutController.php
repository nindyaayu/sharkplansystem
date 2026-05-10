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

        $last = JobOut::latest()->first();

        if($last){

            $nomor =
                (int) substr(
                    $last->no_surat,
                    3
                ) + 1;

        }else{

            $nomor = 1;
        }

        $kode =
            'SJ-' .
            str_pad(
                $nomor,
                3,
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

            'vendor' =>
                $request->vendor,

            'ekspedisi' =>
                $request->ekspedisi,

            'tanggal' =>
                $request->tanggal,

            'status' => 'Dikirim',

            'catatan' =>
                $request->catatan

        ]);

        // =========================
        // AMBIL BOM
        // =========================

        $bom = Bom::with(
            'details.barang'
        )
        ->where(
            'produk_id',
            $request->produk_id
        )
        ->get();

        // =========================
        // LOOP MATERIAL
        // =========================

        foreach($bom as $item){

            foreach($item->details as $detail){

                JobOutDetail::create([

                    'job_out_id' =>
                        $job->id,

                    'barang_id' =>
                        $detail->barang_id,

                    'qty' =>
                        $detail->qty,

                    'satuan' =>
                        $detail->satuan_pakai

                ]);

                $barang = Barang::find(
                    $detail->barang_id
                );

                if($barang){

                    if(
                        $detail->satuan_pakai
                        == 'ROLL'
                    ){

                        $barang->jumlah_roll -=
                            $detail->qty;

                        if(
                            $barang->jumlah_roll < 0
                        ){

                            $barang->jumlah_roll = 0;
                        }
                    }

                    $barang->save();
                }

                BarangKeluar::create([

                    'barang_id' =>
                        $detail->barang_id,

                    'jumlah' =>
                        0,

                    'jumlah_roll' =>
                        $detail->qty,

                    'tanggal_keluar' =>
                        $request->tanggal,

                    'tujuan' =>
                        'JOB OUT - ' .
                        $request->vendor

                ]);
            }
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Job Out berhasil dibuat'
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
            'job_out_pdf_hitung',
            [

                'job' => $job,

                'produk' =>
                    $job->produk,

                'hasil' =>
                    $hasil,

                'vendor' =>
                    $job->vendor,

                'ekspedisi' =>
                    $job->ekspedisi,

                'catatan' =>
                    $job->catatan,

                'qty_produksi' => 0
            ]
        );

        return $pdf->download(
            $job->no_surat . '.pdf'
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

        $last = JobOut::latest()->first();

        if($last){

            $nomor =
                (int) substr(
                    $last->no_surat,
                    3
                ) + 1;

        }else{

            $nomor = 1;
        }

        $kode =
            'SJ-' .
            str_pad(
                $nomor,
                3,
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

            'vendor' =>
                $request->vendor,

            'ekspedisi' =>
                $request->ekspedisi,

            'tanggal' =>
                now(),

            'status' => 'Dikirim',

            'catatan' =>
                $request->catatan

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
                        $request->vendor
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
            'job_out_pdf_hitung',
            [

                'job' => $job,

                'produk' => $produk,

                'hasil' => $hasil,

                'vendor' =>
                    $request->vendor,

                'ekspedisi' =>
                    $request->ekspedisi,

                'catatan' =>
                    $request->catatan,

                'qty_produksi' =>
                    $request->qty_produksi
            ]
        );

        return $pdf->download(
            $kode . '.pdf'
        );
    }
}