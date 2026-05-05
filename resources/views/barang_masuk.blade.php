@extends('layout.app')

@section('content')

<style>

/* ===== HEADER ===== */
.page-header {
    display:flex;
    justify-content:space-between;
    margin-bottom:25px;
}
.page-header h2 { 
    color:white;
    font-weight:600;
}

/* ===== FILTER ===== */
.filter-bar {
    display:flex;
    gap:15px;
    align-items:end;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.filter-group {
    display:flex;
    flex-direction:column;
    gap:5px;
}

.filter-group label {
    font-size:12px;
    color:#94a3b8;
}

/* INPUT */
.input {
    background:#111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:#e5e7eb;
    min-width:160px;
}

/* date icon */
input[type="date"]::-webkit-calendar-picker-indicator {
    filter: invert(1);
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    font-weight:500;
    cursor:pointer;
    transition:0.3s;
}

.btn-primary:hover {
    box-shadow:0 0 12px rgba(99,102,241,0.6);
}

/* ===== TABLE BOX ===== */
.table-box {
    background:rgba(17,24,39,0.7);
    backdrop-filter: blur(10px);
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
}

/* TABLE */
table {
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
thead {
    background: rgba(255,255,255,0.03);
}

thead th {
    padding:14px;
    text-align:left;
    font-size:13px;
    color:#e2e8f0;
    font-weight:600;
    border-bottom:1px solid rgba(255,255,255,0.08);
}

/* BODY */
tbody td {
    padding:14px;
    color:#f1f5f9;
    font-size:14px;
}

/* ROW */
tbody tr {
    border-top:1px solid rgba(255,255,255,0.05);
    transition:0.2s;
}

tbody tr:nth-child(even) {
    background: rgba(255,255,255,0.02);
}

tbody tr:hover {
    background: rgba(99,102,241,0.08);
}

/* BADGE */
.badge-in {
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
    font-weight:500;
}

/* ACTION */
.action-btn {
    background:rgba(255,255,255,0.05);
    border:none;
    padding:6px 10px;
    border-radius:8px;
    color:#e5e7eb;
    cursor:pointer;
    transition:0.2s;
}

.action-btn:hover {
    background: rgba(99,102,241,0.4);
}

</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h2>Barang Masuk</h2>
</div>

<!-- ===== FILTER ===== -->
<div class="filter-bar">

    <button class="btn-primary">+ Input Barang</button>

    <div class="filter-group">
        <label>Dari</label>
        <input type="date" class="input">
    </div>

    <div class="filter-group">
        <label>Sampai</label>
        <input type="date" class="input">
    </div>

</div>

<!-- ===== TABLE ===== -->
<div class="table-box">
<table>
<thead>
<tr>
<th>No</th>
<th>Tanggal</th>
<th>Kode</th>
<th>Nama</th>
<th>Jumlah</th>
<th>Satuan</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<tr>
<td>1</td>
<td>22/05/2024</td>
<td>BB001</td>
<td>Besi Hollow</td>
<td><span class="badge-in">100</span></td>
<td>Kg</td>
<td>
<button class="action-btn">👁</button>
<button class="action-btn">🗑</button>
</td>
</tr>

<tr>
<td>2</td>
<td>21/05/2024</td>
<td>BB002</td>
<td>Plat Besi</td>
<td><span class="badge-in">50</span></td>
<td>Lembar</td>
<td>
<button class="action-btn">👁</button>
<button class="action-btn">🗑</button>
</td>
</tr>

</tbody>
</table>
</div>

@endsection