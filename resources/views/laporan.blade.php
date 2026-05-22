@extends('layout.app')

@section('content')

<style>

body{
    background:#0f172a;
    color:#e5e7eb;
}

/* ================= HEADER ================= */

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-header h2{
    color:white;
    font-weight:700;
}

/* ================= FILTER ================= */

.filter-box{
    background:rgba(17,24,39,0.7);
    border:1px solid rgba(255,255,255,0.05);
    backdrop-filter:blur(10px);
    border-radius:16px;
    padding:20px;
    margin-bottom:20px;
}

.filter-bar{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:11px 14px;
    border-radius:10px;
    color:white;
    min-width:220px;
}
select.input{
    appearance:none;
    cursor:pointer;
}
.input::placeholder{
    color:#64748b;
}

/* ================= BUTTON ================= */

.btn{
    border:none;
    padding:11px 16px;
    border-radius:10px;
    cursor:pointer;
    font-weight:500;
    transition:0.3s;
}

.btn-show{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    color:white;
}

.btn-show:hover{
    box-shadow:0 0 12px rgba(99,102,241,0.6);
}

.btn-pdf{
    background:rgba(255,255,255,0.08);
    color:white;
}

.btn-pdf:hover{
    background:rgba(255,255,255,0.15);
}

/* ================= CARD INFO ================= */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.summary-card{
    background:rgba(17,24,39,0.7);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:16px;
    padding:18px;
}

.summary-title{
    color:#94a3b8;
    font-size:13px;
    margin-bottom:10px;
}

.summary-value{
    color:white;
    font-size:28px;
    font-weight:700;
}

/* ================= TABLE ================= */

.table-box{
    background:rgba(17,24,39,0.7);
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
thead{
    background:rgba(255,255,255,0.03);
}

thead th{
    padding:15px;
    font-size:13px;
    font-weight:600;
    color:#94a3b8;
    text-align:left;
}

/* BODY */
tbody td{
    padding:15px;
    border-top:1px solid rgba(255,255,255,0.05);
    color:#e5e7eb;
    font-size:14px;
}

/* HOVER */
tbody tr:hover{
    background:rgba(99,102,241,0.05);
}

/* ================= BADGE ================= */

.badge-stock{
    background:rgba(99,102,241,0.15);
    color:#c4b5fd;
    padding:5px 10px;
    border-radius:8px;
    display:inline-block;
    font-weight:600;
}

.badge-safe{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
}

.badge-warning{
    background:rgba(250,204,21,0.2);
    color:#facc15;
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
}

.badge-danger{
    background:rgba(239,68,68,0.2);
    color:#ef4444;
    padding:5px 10px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>Laporan Stok Akhir</h2>

</div>

<!-- ================= FILTER ================= -->

<div class="filter-box">

    <form 
    action="{{ route('laporan.filter') }}"
    method="GET">

<div class="filter-bar">

    <input
        type="text"
        name="kode"
        class="input"
        placeholder="Kode Barang"
        value="{{ request('kode') }}">

    <input
        type="text"
        name="nama"
        class="input"
        placeholder="Nama Barang"
        value="{{ request('nama') }}">

    <input
        type="text"
        name="warna"
        class="input"
        placeholder="Warna"
        value="{{ request('warna') }}">

    <select
        name="status"
        class="input">

        <option value="">Semua Status</option>

        <option value="aman"
            {{ request('status')=='aman' ? 'selected' : '' }}>
            Aman
        </option>

        <option value="menipis"
            {{ request('status')=='menipis' ? 'selected' : '' }}>
            Menipis
        </option>

        <option value="habis"
            {{ request('status')=='habis' ? 'selected' : '' }}>
            Habis
        </option>

    </select>

    <input
        type="date"
        name="tanggal"
        class="input"
        value="{{ request('tanggal') }}">

    <button type="submit" class="btn btn-show">
        🔍 Tampilkan
    </button>

    <a
        href="{{ route('laporan.filter') }}"
        class="btn btn-pdf">
        ♻ Reset
    </a>

    <a
        href="{{ route('laporan.pdf', request()->all()) }}"
        class="btn btn-pdf">
        📄 Export PDF
    </a>

</div>

</form>

</div>

<!-- ================= SUMMARY ================= -->

<div class="summary-grid">

    <div class="summary-card">

        <div class="summary-title">

            Total Bahan

        </div>

        <div class="summary-value">

            {{ $data->count() }}

        </div>

    </div>

    <div class="summary-card">

        <div class="summary-title">

            Stok Aman

        </div>

        <div class="summary-value">

            {{ $data->where('stok', '>', 50)->count() }}

        </div>

    </div>

    <div class="summary-card">

        <div class="summary-title">

            Stok Menipis

        </div>

        <div class="summary-value">

            {{ $data->whereBetween('stok',[1,50])->count() }}

        </div>

    </div>

    <div class="summary-card">

        <div class="summary-title">

            Stok Habis

        </div>

        <div class="summary-value">

            {{ $data->where('stok',0)->count() }}

        </div>

    </div>

</div>

<!-- ================= TABLE ================= -->

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama Barang</th>
<th>Warna</th>
<th>Stok Akhir</th>
<th>Satuan</th>
<th>Status</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>

    {{ $loop->iteration }}

</td>

<td>

    {{ $item->kode }}

</td>

<td>

    {{ $item->nama }}

</td>

<td>

    {{ $item->warna ?? '-' }}

</td>

<td>

    <span class="badge-stock">

        {{ number_format($item->stok) }}

    </span>

</td>

<td>

    {{ $item->satuan }}

</td>

<td>

    @if($item->stok == 0)

        <span class="badge-danger">

            Habis

        </span>

    @elseif($item->stok <= 50)

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

    Belum ada data laporan

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection