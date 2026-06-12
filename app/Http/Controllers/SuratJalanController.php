<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobOut;

class SuratJalanController extends Controller
{
    // =========================
    // HALAMAN SURAT JALAN
    // =========================

    public function index()
{
    $user = auth()->user();

    $query = JobOut::query();

    if ($user->cabang) {

        $query->where(
            'cabang',
            $user->cabang
        );

    }

    $data = $query
        ->latest()
        ->get();

    return view(
        'surat_jalan',
        compact('data')
    );
}
}