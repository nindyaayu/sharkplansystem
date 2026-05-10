<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Surat Jalan</title>

<style>

body{
    font-family:sans-serif;
    font-size:13px;
    color:#111;
}

.header{
    width:100%;
    margin-bottom:20px;
}

.company{
    font-size:20px;
    font-weight:bold;
}

.address{
    font-size:12px;
    margin-top:5px;
}

.title{
    text-align:center;
    font-size:18px;
    font-weight:bold;
    margin:25px 0;
}

.info{
    margin-bottom:20px;
}

.info table{
    width:100%;
}

.info td{
    padding:4px 0;
}

.table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.table th,
.table td{
    border:1px solid #000;
    padding:10px;
}

.table th{
    background:#f3f4f6;
}

.ttd{
    width:100%;
    margin-top:60px;
    text-align:center;
}

.ttd td{
    width:25%;
}

.ttd-space{
    height:80px;
}

</style>

</head>

<body>

<!-- ========================= -->
<!-- HEADER -->
<!-- ========================= -->

<div class="header">

<div class="company">

    PT. SHARK PLAN

</div>

<div class="address">

    Jl. Industri No. 01<br>
    Surabaya<br>
    Telp : 0812-xxxx-xxxx

</div>

</div>

<div class="title">

    SURAT JALAN JOB OUT

</div>

<!-- ========================= -->
<!-- INFO -->
<!-- ========================= -->

<div class="info">

<table>

<tr>

<td width="20%">

    No Surat

</td>

<td width="30%">

    : {{ $job->no_surat }}

</td>

<td width="20%">

    Tanggal

</td>

<td>

    :
    {{ date('d/m/Y', strtotime($job->tanggal)) }}

</td>

</tr>

<tr>

<td>

    Vendor

</td>

<td>

    : {{ $job->vendor }}

</td>

<td>

    Ekspedisi

</td>

<td>

    : {{ $job->ekspedisi ?? '-' }}

</td>

</tr>

<tr>

<td>

    Produk

</td>

<td colspan="3">

    :
    {{ $job->produk->nama }}

</td>

</tr>

<tr>

<td>

    Catatan

</td>

<td colspan="3">

    :
    {{ $job->catatan ?? '-' }}

</td>

</tr>

</table>

</div>

<!-- ========================= -->
<!-- TABLE -->
<!-- ========================= -->

<table class="table">

<thead>

<tr>

<th width="8%">

    No

</th>

<th>

    Nama Material

</th>

<th width="15%">

    Qty

</th>

<th width="15%">

    Satuan

</th>

</tr>

</thead>

<tbody>

@foreach($job->details as $detail)

<tr>

<td align="center">

    {{ $loop->iteration }}

</td>

<td>

    {{ $detail->barang->nama }}

</td>

<td align="center">

    {{ number_format($detail->qty, 2) }}

</td>

<td align="center">

    {{ $detail->satuan }}

</td>

</tr>

@endforeach

</tbody>

</table>

<!-- ========================= -->
<!-- TTD -->
<!-- ========================= -->

<table class="ttd">

<tr>

<td>

    Pengirim

</td>

<td>

    Gudang

</td>

<td>

    Ekspedisi

</td>

<td>

    Penerima

</td>

</tr>

<tr>

<td class="ttd-space"></td>
<td class="ttd-space"></td>
<td class="ttd-space"></td>
<td class="ttd-space"></td>

</tr>

<tr>

<td>

(....................)

</td>

<td>

(....................)

</td>

<td>

(....................)

</td>

<td>

(....................)

</td>

</tr>

</table>

</body>

</html>