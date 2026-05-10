@extends('layout.app')

@section('content')

<style>

.page-title{
    color:white;
    font-size:32px;
    font-weight:700;
    margin-bottom:25px;
}

.top-box{
    background:rgba(17,24,39,0.7);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:18px;
    padding:20px;
    margin-bottom:20px;
}

.filter-box{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.08);
    padding:12px 14px;
    border-radius:12px;
    color:white;
    min-width:220px;
}

.btn{
    padding:12px 18px;
    border:none;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
    color:white;
}

.btn-primary{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
}

.btn-dark{
    background:#374151;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:16px;
    margin-bottom:25px;
}

.stat-card{
    background:rgba(17,24,39,0.7);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:18px;
    padding:22px;
}

.stat-title{
    color:#94a3b8;
    font-size:14px;
    margin-bottom:10px;
}

.stat-value{
    color:white;
    font-size:40px;
    font-weight:700;
}

.table-box{
    background:rgba(17,24,39,0.7);
    border-radius:18px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:rgba(255,255,255,0.03);
}

thead th{
    padding:16px;
    color:#94a3b8;
    text-align:left;
    font-size:13px;
}

tbody td{
    padding:16px;
    border-top:1px solid rgba(255,255,255,0.05);
    color:#f8fafc;
}

.badge-stock{
    background:rgba(99,102,241,0.2);
    color:#c4b5fd;
    padding:7px 12px;
    border-radius:10px;
    display:inline-block;
    font-weight:600;
}

.badge-safe{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    padding:6px 12px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
}

.badge-warning{
    background:rgba(250,204,21,0.2);
    color:#facc15;
    padding:6px 12px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
}

.badge-danger{
    background:rgba(239,68,68,0.2);
    color:#ef4444;
    padding:6px 12px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
}

</style>

<div class="page-title">

    Laporan Material Utama

</div>

<!-- FILTER -->

<div class="top-box">

    <form method="GET">

        <div class="filter-box">

            <input
                type="date"
                name="tanggal"
                value="{{ request('tanggal') }}"
                class="input">

            <button
                type="submit"
                class="btn btn-primary">

                🔍 Tampilkan

            </button>

            <a
                href="/laporan-material-utama-pdf?tanggal={{ request('tanggal') }}"
                class="btn btn-dark"
                style="text-decoration:none; display:flex; align-items:center;">

                📄 Export PDF

            </a>

        </div>

    </form>

</div>

<!-- STATISTIK -->

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-title">

            Total Kain

        </div>

        <div class="stat-value">

            {{ $data->count() }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Total Roll

        </div>

        <div class="stat-value">

            {{ number_format($data->sum('jumlah_roll')) }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Total Meter

        </div>

        <div class="stat-value">

            {{ number_format($data->sum('jumlah_meter')) }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Stok Habis

        </div>

        <div class="stat-value">

            {{ $data->where('jumlah_meter',0)->count() }}

        </div>

    </div>

</div>

<!-- TABEL -->

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama Barang</th>
<th>Warna</th>
<th>Jumlah Roll</th>
<th>Jumlah Meter</th>
<th>Status</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->kode }}</td>

<td>{{ $item->nama }}</td>

<td>{{ $item->warna ?? '-' }}</td>

<td>

    <span class="badge-stock">

        {{ number_format($item->jumlah_roll) }} Roll

    </span>

</td>

<td>

    <span class="badge-stock">

        {{ number_format($item->jumlah_meter) }} Meter

    </span>

</td>

<td>

    @if($item->jumlah_meter == 0)

        <span class="badge-danger">

            Habis

        </span>

    @elseif($item->jumlah_meter <= 500)

        <span class="badge-warning">

            Menipis

        </span>

    @else

        <span class="badge-safe">

            Aman

        </span>

    @endif

</td>

</tr>

@empty

<tr>

<td colspan="7" style="text-align:center;">

    Tidak ada data

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection