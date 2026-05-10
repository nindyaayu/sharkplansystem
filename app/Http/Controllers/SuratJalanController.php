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
        $data = JobOut::latest()->get();

        return view(
            'surat_jalan',
            compact('data')
        );
    }
}