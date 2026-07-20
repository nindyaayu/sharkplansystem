@extends('layout.app')

@section('content')

<style>

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(135deg,#3F4F44,#556B5D);
    border-radius:22px;
    padding:28px 32px;
    margin-bottom:25px;
    box-shadow:0 10px 25px rgba(0,0,0,.12);
}

.page-title h1{
    margin:0;
    color:#fff;
    font-size:52px;
    font-weight:700;
}

.page-title p{
    margin-top:8px;
    color:rgba(255,255,255,.85);
    font-size:16px;
}

/*================ TABLE =================*/

.table-box{
    background:#ffffff;
    border:1px solid #E5E7EB;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#F8FAFC;
}

thead th{
    padding:16px;
    color:#3F4F44;
    text-align:left;
    font-size:13px;
    font-weight:600;
    border-bottom:1px solid #E5E7EB;
}

tbody td{
    padding:16px;
    border-top:1px solid #E5E7EB;
    color:#374151;
}

tbody tr:hover{
    background:#F9FAFB;
}

/*================ BADGE =================*/

.badge-warning{
    background:#FEF3C7;
    color:#B45309;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-success{
    background:#DCFCE7;
    color:#15803D;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

/*================ BUTTON =================*/

.btn-process{
    background:#3F4F44;
    color:white;
    border:none;
    padding:8px 16px;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
    transition:.25s;
}

.btn-process:hover{
    background:#556B5D;
    transform:translateY(-2px);
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <div class="page-title">
        <h1>Laporan Produksi</h1>
    </div>

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