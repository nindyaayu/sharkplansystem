<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BatchProduction;
use App\Models\Produk;

class BatchProductionController extends Controller
{
    // =========================
    // DAFTAR BATCH PRODUKSI
    // =========================
    public function index(Request $request)
    {
        $query = BatchProduction::with('produk');

        // =========================
        // SEARCH
        // =========================
        if ($request->search) {

            $query->where('kode_batch', 'like', '%' . $request->search . '%')
                ->orWhereHas('produk', function ($q) use ($request) {

                    $q->where('nama', 'like', '%' . $request->search . '%');

                });

        }

        // =========================
        // FILTER STATUS
        // =========================
        if ($request->status) {

            $query->where('status', $request->status);

        }

        $batchProductions = $query
            ->latest()
            ->paginate(10);

        return view(
            'production.batch.index',
            compact('batchProductions')
        );
    }

    // =========================
    // FORM TAMBAH
    // =========================
    public function create()
    {
        $produk = Produk::orderBy('nama')->get();

        return view(
            'production.batch.create',
            compact('produk')
        );
    }

    // =========================
    // SIMPAN
    // =========================
    public function store(Request $request)
    {
        $request->validate([

            'produk_id' => 'required|exists:produks,id',

            'qty_order' => 'required|integer|min:1',

            'tanggal' => 'required|date',

            'keterangan' => 'nullable|string'

        ]);

        BatchProduction::create([

            'kode_batch' => $this->generateKodeBatch(),

            'produk_id' => $request->produk_id,

            'qty_order' => $request->qty_order,

            'tanggal' => $request->tanggal,

            'keterangan' => $request->keterangan,

            'status' => 'Draft'

        ]);

        return redirect()
            ->route('batch-production.index')
            ->with(
                'success',
                'Batch produksi berhasil dibuat.'
            );
    }

    // =========================
    // FORM EDIT
    // =========================
    public function edit($id)
    {
        $batch = BatchProduction::findOrFail($id);

        $produk = Produk::orderBy('nama')->get();

        return view(
            'production.batch.edit',
            compact(
                'batch',
                'produk'
            )
        );
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $request->validate([

            'produk_id' => 'required|exists:produks,id',

            'qty_order' => 'required|integer|min:1',

            'tanggal' => 'required|date',

            'keterangan' => 'nullable|string',

            'status' => 'required'

        ]);

        $batch = BatchProduction::findOrFail($id);

        $batch->update([

            'produk_id' => $request->produk_id,

            'qty_order' => $request->qty_order,

            'tanggal' => $request->tanggal,

            'keterangan' => $request->keterangan,

            'status' => $request->status

        ]);

        return redirect()
            ->route('batch-production.index')
            ->with(
                'success',
                'Batch produksi berhasil diperbarui.'
            );
    }

    // =========================
    // GENERATE KODE BATCH
    // =========================
    private function generateKodeBatch()
    {
        $tanggal = now()->format('Ymd');

        $last = BatchProduction::whereDate(
            'created_at',
            today()
        )->count() + 1;

        return 'BP-' .
            $tanggal .
            '-' .
            str_pad($last, 3, '0', STR_PAD_LEFT);
    }
}