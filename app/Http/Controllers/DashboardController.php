<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // total bahan
        $totalBahan = Barang::count();

        // bahan baru hari ini
        $bahanBaru = Barang::whereDate('created_at', Carbon::today())->count();

        return view('dashboard', compact('totalBahan','bahanBaru'));
    }
}