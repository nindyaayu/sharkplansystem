<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page {
    margin: 8px;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:10px;
    color:#000;
}

/* ================= HEADER ================= */

.header{
    border-bottom:2px solid #000;
    padding-bottom:4px;
}

.header table{
    width:100%;
    border-collapse:collapse;
}

.logo{
    width:70px;
}

.company{
    text-align:center;
}

.company-name{
    font-size:18px;
    font-weight:bold;
}

.company-info{
    font-size:9px;
}

.title{
    text-align:right;
    font-size:16px;
    font-weight:bold;
    vertical-align:bottom;
}

/* ================= INFO ================= */

.info{
    margin-top:6px;
}

.info table{
    width:100%;
}

.info td{
    padding:2px;
    font-size:10px;
}

/* ================= TABEL ================= */

.table-barang{
    width:100%;
    border-collapse:collapse;
    margin-top:8px;
}

.table-barang th,
.table-barang td{
    border:1px solid #000;
}

.table-barang th{
    text-align:center;
    padding:4px;
    font-size:10px;
}

.table-barang td{
    height:24px;
    padding:3px;
}

/* ================= TTD ================= */

.ttd{
    width:100%;
    border-collapse:collapse;
    margin-top:8px;
}

.ttd td{
    border:1px solid #000;
}

.ttd-head{
    text-align:center;
    font-weight:bold;
    height:25px;
}

.ttd-body{
    height:65px;
}

.center{
    text-align:center;
}

</style>

</head>

<body>

<!-- HEADER -->

<div class="header">

<table>

<tr>

<td width="15%">

@if(file_exists(public_path('images/logo-shark.png')))
<img
src="{{ public_path('images/logo-shark.png') }}"
style="height:55px;">
@endif

</td>

<td width="65%" class="company">

<div class="company-name">
PT. SHARK GLOBALINDO JAYA
</div>

<div class="company-info">
Jl. Inspol Suwoto Krajan Sawah No.2
</div>

<div class="company-info">
Desa Srigading - Kec. Lawang 65216
</div>

<div class="company-info">
Telepon : 0812 7203 1999
</div>

</td>

<td width="20%" class="title">

SURAT JALAN

</td>

</tr>

</table>

</div>

<!-- INFO -->

<div class="info">

<table>

<tr>

<td width="12%">Kepada</td>
<td width="38%">: {{ $job->vendor }}</td>

<td width="18%">Tgl / Jam Berangkat</td>
<td>: {{ date('d/m/Y', strtotime($job->tanggal)) }}</td>

</tr>

<tr>

<td>Alamat</td>
<td>: </td>

<td>Tanggal Kedatangan</td>
<td>: </td>

</tr>

<tr>

<td></td>
<td></td>

<td>No. Surat Jalan</td>
<td>: {{ $job->no_surat }}</td>

</tr>

<tr>

<td></td>
<td></td>

<td>No. Pol Kendaraan</td>
<td>: </td>

</tr>

</table>

</div>

<!-- TABEL BARANG -->

<table class="table-barang">

<thead>

<tr>

<th width="40%">
Nama Barang
</th>

<th width="15%">
Jumlah Pengiriman
</th>

<th width="15%">
Barang Diterima
</th>

<th width="15%">
Barang Ditolak
</th>

<th width="15%">
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

@for($i=0; $i<5; $i++)

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

<!-- TTD -->

<table class="ttd">

    <!-- Header -->

    <tr>

        <td colspan="2" class="ttd-head">
            Diterima Oleh,
        </td>

        <td class="ttd-head">
            Diperiksa Oleh,
        </td>

        <td class="ttd-head">
            Dibuat Oleh
        </td>

    </tr>

    <!-- Tanggal & Jam -->

    <tr>

        <td style="padding:5px;">
            Tanggal :
        </td>

        <td style="padding:5px;">
            Jam :
        </td>

        <td rowspan="2"></td>

        <td rowspan="2"></td>

    </tr>

    <!-- Area Tanda Tangan -->

    <tr>

        <td colspan="2" class="ttd-body"></td>

    </tr>

    <!-- Nama Penanda Tangan -->

    <tr>

        <td colspan="2" class="center">
            Penerima
        </td>

        <td class="center">
            Ekspedisi / Security
        </td>

        <td class="center">
            &nbsp;
        </td>

    </tr>

</table>

</td>
</body>
</html>