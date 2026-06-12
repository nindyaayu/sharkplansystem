<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>
        Laporan Barang Keluar (Material Pendukung)
    </title>

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
            color:#1e293b;
        }

        .header-line{
            border:none;
            border-top:3px solid #1e40af;
            margin-top:10px;
            margin-bottom:20px;
        }

        .judul-tabel{
            background:#1e40af;
            color:white;
            padding:8px;
            font-weight:bold;
            margin-bottom:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th,
        table td{
            border:1px solid #64748b;
            padding:8px;
            font-size:11px;
        }

        table th{
            background:#1e40af;
            color:white;
        }

        .text-right{
            text-align:right;
        }

    </style>

</head>

<body>

<!-- HEADER -->

<table style="width:100%;border:none;">

<tr>

<td style="border:none;width:90px;">

    <img
        src="{{ public_path('images/logo-shark.png') }}"
        width="70">

</td>

<td style="border:none;">

    <div style="
        font-size:28px;
        font-weight:bold;
        color:#1e3a8a;
    ">
        SHARKPLAN
    </div>

    <div style="
        font-size:14px;
        color:#64748b;
    ">
        Inventory & Production System
    </div>

    <div style="
        font-size:20px;
        font-weight:bold;
        margin-top:8px;
    ">
        LAPORAN BARANG KELUAR
    </div>

    <div style="
        font-size:12px;
        color:#475569;
    ">
        Material Pendukung
    </div>

</td>

<td
    align="right"
    style="
        border:none;
        font-size:11px;
    ">

    <b>Tanggal Cetak</b><br>
    {{ now()->format('d/m/Y H:i') }}

    <br><br>

    <b>Cabang</b><br>
    {{ auth()->user()->cabang ?? 'PUSAT' }}

</td>

</tr>

</table>

<hr class="header-line">

@if(!empty($tanggal_awal) && !empty($tanggal_akhir))

<div style="
    text-align:center;
    margin-bottom:15px;
    font-size:12px;
">

    <b>Periode :</b>

    {{ \Carbon\Carbon::parse($tanggal_awal)->format('d-m-Y') }}

    s/d

    {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d-m-Y') }}

</div>

@endif

<div class="judul-tabel">
    DATA BARANG KELUAR MATERIAL PENDUKUNG
</div>

<table>

<thead>

<tr>

<th width="5%">No</th>
<th width="12%">Tanggal</th>
<th width="12%">Kode</th>
<th>Nama Barang</th>
<th width="25%">Tujuan</th>
<th width="10%">Jumlah</th>
<th width="10%">Satuan</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>
    {{ $loop->iteration }}
</td>

<td>
    {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d-m-Y') }}
</td>

<td>
    {{ $item->barang->kode ?? '-' }}
</td>

<td>
    {{ $item->barang->nama ?? '-' }}
</td>

<td>
    {{ $item->tujuan }}
</td>

<td class="text-right">
    {{ number_format($item->jumlah,0) }}
</td>

<td>
    {{ strtoupper($item->barang->satuan ?? '-') }}
</td>

</tr>

@empty

<tr>

<td colspan="7" align="center">

    Tidak ada data

</td>

</tr>

@endforelse

</tbody>

<tfoot>

<tr>

<th colspan="5" style="text-align:right;">
    TOTAL
</th>

<th class="text-right">
    {{ number_format($data->sum('jumlah'),0) }}
</th>

<th>
    -
</th>

</tr>

</tfoot>

</table>

<br><br>

<div style="
    text-align:center;
    font-size:10px;
    color:#64748b;
">

    Dicetak dari sistem SHARKPLAN -
    Inventory & Production System

</div>

</body>
</html>