@extends('layout.app')

@section('content')

<style>

body{
    background:#0f172a;
    color:#e5e7eb;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-header h2{
    color:white;
}

/* ================= TABLE ================= */

.table-box{
    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);
    border-radius:16px;
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
    padding:14px;
    text-align:left;
    color:#94a3b8;
    font-size:13px;
}

tbody td{
    padding:14px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover{
    background:rgba(99,102,241,0.05);
}

/* ================= BADGE ================= */

.badge-warning{
    background:rgba(250,204,21,0.2);
    color:#facc15;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.badge-success{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

/* ================= BUTTON ================= */

.btn-process{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

.btn-process:hover{
    background:rgba(34,197,94,0.3);
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>Laporan Produksi</h2>

</div>

<!-- ================= TABLE ================= -->

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>Produk</th>
<th>Qty</th>
<th>Tanggal</th>
<th>Jenis</th>
<th>Pelaksana</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($produksi as $index => $item)

<tr>

<td>

    {{ $index + 1 }}

</td>

<td>

    {{ $item->produk->nama }}

</td>

<td>

    {{ number_format($item->qty_produksi) }}

</td>

<td>

    {{ $item->tanggal }}

</td>

<td>

    {{ $item->jenis_produksi }}

</td>

<td>

    {{ $item->pelaksana }}

</td>

<td>

    @if($item->status == 'Draft')

        <span class="badge-warning">

            Draft

        </span>

    @else

        <span class="badge-success">

            Diproduksi

        </span>

    @endif

</td>

<td>

    @if($item->status == 'Draft')

    <form 
        action="{{ route('produksi.proses', $item->id) }}"
        method="POST">

        @csrf

        <button 
            type="submit"
            class="btn-process"
            onclick="return confirm('Proses produksi ini?')">

            Proses

        </button>

    </form>

    @else

        ✔

    @endif

</td>

</tr>

@empty

<tr>

<td colspan="8" style="text-align:center;">

    Belum ada data produksi

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection