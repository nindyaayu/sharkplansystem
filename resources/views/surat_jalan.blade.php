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

/* ================= BUTTON ================= */

.btn-download{
    background:linear-gradient(90deg,#22c55e,#16a34a);
    border:none;
    padding:8px 14px;
    border-radius:10px;
    color:white;
    text-decoration:none;
    font-size:13px;
}

.badge{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>

        Riwayat Surat Jalan

    </h2>

</div>

<!-- ================= TABLE ================= -->

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>No Surat</th>
<th>Vendor</th>
<th>Tanggal</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>

    {{ $loop->iteration }}

</td>

<td>

    {{ $item->no_surat }}

</td>

<td>

    {{ $item->vendor }}

</td>

<td>

    {{ date('d M Y', strtotime($item->tanggal)) }}

</td>

<td>

    <span class="badge">

        {{ $item->status }}

    </span>

</td>

<td>

    <a
        href="/job-out/pdf/{{ $item->id }}"
        class="btn-download">

        Download PDF

    </a>

</td>

</tr>

@empty

<tr>

<td colspan="6" style="text-align:center;">

    Belum ada surat jalan

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection