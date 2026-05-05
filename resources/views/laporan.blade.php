@extends('layout.app')

@section('content')

<style>

/* ===== HEADER ===== */
.title {
    color:white;
    font-weight:600;
    margin-bottom:20px;
}

/* ===== FILTER ===== */
.filter-bar {
    display:flex;
    gap:10px;
    margin-bottom:20px;
}

.input {
    background:#111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px;
    border-radius:8px;
    color:white;
}

/* BUTTON */
.btn {
    padding:10px 14px;
    border-radius:8px;
    border:none;
    cursor:pointer;
}

.btn-show {
    background:#6366f1;
    color:white;
}

.btn-pdf {
    background:#e5e7eb;
}

/* ===== TABLE ===== */
.table-box {
    background:rgba(17,24,39,0.7);
    border-radius:12px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
}

table {
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
thead {
    background:#facc15; /* kuning tapi lebih soft */
}

thead th {
    padding:14px;
    font-size:13px;
    font-weight:600;
    color:#111;
    text-align:left;
}

/* BODY */
tbody td {
    padding:14px;
    border-top:1px solid rgba(255,255,255,0.05);
    color:#e5e7eb;
}

/* ZEBRA */
tbody tr:nth-child(even) {
    background:rgba(255,255,255,0.02);
}

/* HOVER */
tbody tr:hover {
    background:rgba(99,102,241,0.08);
}

/* ===== STOK WARNA ===== */
.stok-normal {
    background:#facc15;
    color:#111;
    font-weight:600;
    border-radius:6px;
    padding:4px 10px;
    display:inline-block;
}

.stok-habis {
    background:#ef4444;
    color:white;
    font-weight:600;
    border-radius:6px;
    padding:4px 10px;
    display:inline-block;
}

</style>

<h2 class="title">Laporan Stok Akhir</h2>

<div class="filter-bar">
    <input type="date" class="input">
    <button class="btn btn-show">🔍 Tampilkan</button>
    <button class="btn btn-pdf">📄 Export PDF</button>
</div>

<div class="table-box">
<table>
<thead>
<tr>
<th>No</th>
<th>Nama Barang</th>
<th>Stok Akhir</th>
<th>Satuan</th>
</tr>
</thead>

<tbody>
<tr>
<td>1</td>
<td>Benang</td>
<td><span class="stok-normal">600</span></td>
<td>Cone</td>
</tr>

<tr>
<td>2</td>
<td>Buckle Cobra</td>
<td><span class="stok-normal">250</span></td>
<td>Pcs</td>
</tr>

<tr>
<td>3</td>
<td>Buckle Magnet QR</td>
<td><span class="stok-habis">0</span></td>
<td>Pcs</td>
</tr>

</tbody>
</table>
</div>

@endsection