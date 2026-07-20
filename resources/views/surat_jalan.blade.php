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
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

.page-title h1{
    margin:0;
    color:#fff;
    font-size:46px;
    font-weight:700;
}

.page-title p{
    margin-top:8px;
    color:rgba(255,255,255,.85);
    font-size:15px;
}

/* ================= TABLE ================= */

.table-box{
    background:#fff;
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
    color:#374151;
    border-top:1px solid #E5E7EB;
}

tbody tr:hover{
    background:#F9FAFB;
}

/* ================= BADGE ================= */

.badge{
    background:#DCFCE7;
    color:#15803D;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

/* ================= BUTTON ================= */

.btn-download{
    background:#3F4F44;
    color:#fff;
    text-decoration:none;
    padding:8px 16px;
    border-radius:10px;
    font-size:13px;
    font-weight:600;
    transition:.25s;
}

.btn-download:hover{
    background:#556B5D;
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <div class="page-title">
        <h1>Riwayat Surat Jalan</h1>
        <p>Daftar seluruh surat jalan yang telah dibuat</p>
    </div>

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