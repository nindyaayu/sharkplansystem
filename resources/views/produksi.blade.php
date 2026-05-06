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

/* ================= FORM ================= */

.form-box{
    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:16px;
    padding:20px;
    margin-bottom:20px;
}

.form-row{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:white;
    min-width:220px;
}

select.input option{
    background:#111827;
}

/* ================= BUTTON ================= */

.btn-primary{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
    transition:0.3s;
}

.btn-primary:hover{
    box-shadow:0 0 12px rgba(99,102,241,0.6);
}

.btn-process{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
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

.badge{
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.badge-warning{
    background:rgba(250,204,21,0.2);
    color:#facc15;
}

.badge-success{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>Produksi</h2>

</div>

<!-- ================= FORM ================= -->

<div class="form-box">

<form action="{{ route('produksi.store') }}" method="POST">

@csrf

<div class="form-row">

    <!-- PRODUK -->
    <select 
        name="produk_id"
        class="input"
        required>

        <option value="">
            Pilih Produk
        </option>

        @foreach($produk as $item)

        <option value="{{ $item->id }}">

            {{ $item->kode }} - {{ $item->nama }}

        </option>

        @endforeach

    </select>

    <!-- QTY -->
    <input 
        type="number"
        name="qty_produksi"
        class="input"
        placeholder="Qty Produksi"
        required>

    <!-- TANGGAL -->
    <input 
        type="date"
        name="tanggal"
        class="input"
        required>

    <!-- JENIS -->
    <select 
        name="jenis_produksi"
        class="input"
        required>

        <option value="">
            Jenis Produksi
        </option>

        <option value="Internal">
            Internal
        </option>

        <option value="Job Out">
            Job Out
        </option>

    </select>

    <!-- PELAKSANA -->
    <input 
        type="text"
        name="pelaksana"
        class="input"
        placeholder="Pelaksana / Vendor"
        required>

    <button class="btn-primary">

        + Simpan Produksi

    </button>

</div>

</form>

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

        <span class="badge badge-warning">

            Draft

        </span>

    @else

        <span class="badge badge-success">

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