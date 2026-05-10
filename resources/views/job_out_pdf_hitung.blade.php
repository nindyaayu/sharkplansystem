<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8">

<title>Surat Jalan</title>

<style>

body{
    font-family:serif;
    font-size:13px;
    color:#111;
    margin:40px;
}

.header{
    text-align:center;
    margin-bottom:30px;
}

.title{
    font-size:42px;
    font-weight:bold;
    margin-bottom:10px;
}

.line{
    border-top:3px solid #000;
    width:60%;
    margin:0 auto 15px auto;
}

.company{
    font-size:26px;
    font-weight:bold;
}

.address{
    font-size:15px;
    margin-top:8px;
}

.info{
    margin-top:40px;
    margin-bottom:35px;
}

.info table{
    width:100%;
}

.info td{
    padding:6px 0;
    font-size:16px;
}

.table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.table th,
.table td{
    border:1px solid #000;
    padding:12px;
    font-size:15px;
}

.table th{
    text-align:center;
    font-weight:bold;
}

.ttd{
    width:100%;
    margin-top:90px;
    text-align:center;
}

.ttd td{
    width:25%;
    font-size:16px;
}

.ttd-space{
    height:90px;
}

</style>

</head>

<body>

<!-- ================= HEADER ================= -->

<div class="header">

    <div class="title">

        SURAT JALAN

    </div>

    <div class="line"></div>

    <div class="company">

        PT. SHARK GLOBALINDO JAYA

    </div>

    <div class="address">

        Srigading, Kec. Lawang, Kabupaten Malang, Jawa Timur 65216

    </div>

</div>

<!-- ================= INFO ================= -->

<div class="info">

<table>

<tr>

<td width="20%">

    Kepada

</td>

<td width="30%">

    : {{ $vendor }}

</td>

<td width="20%">

    Tanggal Kirim

</td>

<td>

    : {{ date('d F Y') }}

</td>

</tr>

<tr>

<td>

    Alamat

</td>

<td>

    : -

</td>

<td>

    No. Surat Jalan

</td>

<td>

    : SJ-001

</td>

</tr>

</table>

</div>

<!-- ================= TABLE ================= -->

<table class="table">

<thead>

<tr>

<th width="8%">

    No

</th>

<th>

    Nama Barang

</th>

<th width="15%">

    Qty

</th>

<th width="15%">

    Satuan

</th>

<th width="20%">

    Keterangan

</th>

</tr>

</thead>

<tbody>

@foreach($hasil as $item)

<tr>

<td align="center">

    {{ $loop->iteration }}

</td>

<td>

    {{ $item['bahan'] }}

</td>

<td align="center">

    {{ number_format($item['qty_roll'],0) }}

</td>

<td align="center">

    ROLL

</td>

<td align="center">

    -

</td>

</tr>

@endforeach

<!-- ROW KOSONG -->

@for($i = count($hasil); $i < 4; $i++)

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

(.........................)

</td>

<td>

(.........................)

</td>

<td>

(.........................)

</td>

<td>

(.........................)

</td>

</tr>

</table>

</body>

</html>