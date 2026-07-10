<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page{
    margin:0.2cm;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:8px;
    color:#000;
    margin:0;
    padding:0;
}

/* ================= HEADER ================= */

.header{
    height:2.2cm;
    border-bottom:1px solid #000;
}

.header-table{
    width:100%;
    border-collapse:collapse;
}

.logo{
    height:1.9cm;
}

.company-name{
    text-align:center;
    font-size:14px;
    font-weight:bold;
}

.company-info{
    text-align:center;
    font-size:7px;
    line-height:1.2;
}

.surat-jalan{
    text-align:center;
    font-size:9px;
    font-weight:bold;
}

/* ================= INFO ================= */

.info{
    height:1.8cm;
    padding-top:2px;
}

.info-table{
    width:100%;
    border-collapse:collapse;
}

.info-table td{
    font-size:8px;
    padding:2px;
    vertical-align:top;
}

/* ================= TABEL ================= */

.table-barang{
    width:100%;
    border-collapse:collapse;
}

.table-barang th,
.table-barang td{
    border:1px solid #000;
}

.table-barang th{
    height:0.7cm;
    font-size:8px;
    text-align:center;
    padding:0;
}

.table-barang td{
    height:0.75cm;
    padding:2px;
    font-size:8px;
}

/* ================= TTD ================= */

.ttd{
    width:100%;
    border-collapse:collapse;
}

.ttd td{
    border:1px solid #000;
}

.ttd-head{
    height:0.7cm;
    text-align:center;
    font-weight:bold;
    font-size:8px;
}

.ttd-info{
    height:0.45cm;
    font-size:8px;
    padding-left:6px;
    padding-right:6px;
}

.ttd-body{
    height:2.8cm;
}

.center{
    font-size:9px;
    vertical-align:bottom;
}

</style>

</head>

<body>

<!-- ================= HEADER ================= -->

<div class="header">

<table class="header-table">

<tr>

<td width="15%">

@if(file_exists(public_path('images/logo-shark.png')))
<img
src="{{ public_path('images/logo-shark.png') }}"
class="logo">
@endif

</td>

<td width="60%">

<div class="company-name">
PT. SHARK GLOBALINDO JAYA
</div>

<div class="company-info">
Alamat : Jl. Inspol Suwoto Krajan Sawah No.2
</div>

<div class="company-info">
Desa Srigading - Kec. Lawang 65216
</div>

<div class="company-info">
Telepon : 0812 7203 1999
</div>

</td>

<td width="25%">

<div class="surat-jalan">
SURAT JALAN
</div>

</td>

</tr>

</table>

</div>

<!-- ================= INFO ================= -->

<div class="info">

<table class="info-table">

<tr>

<td width="12%">
Kepada
</td>

<td width="32%">
: {{ $job->vendor }}
</td>

<td width="20%">
Tgl / Jam Berangkat
</td>

<td>
: {{ date('d/m/Y', strtotime($job->tanggal)) }}
</td>

</tr>

<tr>

<td>
Alamat
</td>

<td>
:
</td>

<td>
Tanggal Kedatangan
</td>

<td>
:
</td>

</tr>

<tr>

<td></td>
<td></td>

<td>
No. Surat Jalan
</td>

<td>
: {{ $job->no_surat }}
</td>

</tr>

<tr>

<td></td>
<td></td>

<td>
No. Pol Kendaraan
</td>

<td>
:
</td>

</tr>

</table>

</div>

<!-- ================= TABEL ================= -->

<table class="table-barang">

<thead>

<tr>

<th width="36%">
Nama Barang
</th>

<th width="16%">
Jumlah Pengiriman
</th>

<th width="16%">
Barang Diterima
</th>

<th width="16%">
Barang Ditolak
</th>

<th width="16%">
Kurang Barang
</th>

</tr>

</thead>

<tbody>

@foreach($job->details as $detail)

<tr>

<td>
{{ $detail->barang->nama }}
</td>

<td align="center">
{{ number_format($detail->qty,0) }}
</td>

<td></td>
<td></td>
<td></td>

</tr>

@endforeach

@for($i = count($job->details); $i < 6; $i++)

<tr>

<td>&nbsp;</td>
<td></td>
<td></td>
<td></td>
<td></td>

</tr>

@endfor

</tbody>

</table>

<!-- ================= TTD ================= -->

<table class="ttd">

<tr>

<td width="34%" class="ttd-head">
Diterima Oleh,
</td>

<td width="40%" colspan="2" class="ttd-head">
Diperiksa Oleh,
</td>

<td width="26%" class="ttd-head">
Dibuat Oleh,
</td>

</tr>

<tr>

<td class="ttd-info">

<span style="float:left">
Tanggal:
</span>

<span style="float:right">
Jam:
</span>

</td>

<td width="36%" colspan="2"></td>

<td></td>

</tr>

<tr>

<td class="ttd-body"></td>

<td class="ttd-body"></td>

<td class="ttd-body"></td>

<td class="ttd-body"></td>

</tr>

<tr>

<td class="center">
Penerima
</td>

<td class="center">
Ekspedisi
</td>

<td class="center">
Security
</td>

<td class="center">
&nbsp;
</td>

</tr>

</table>

</body>
</html>