<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">

    <title>
        Laporan Material Pendukung
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

        .aman{
            color:#16a34a;
            font-weight:bold;
        }

        .menipis{
            color:#ca8a04;
            font-weight:bold;
        }

        .habis{
            color:#dc2626;
            font-weight:bold;
        }

    </style>

</head>

<body>

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
        LAPORAN STOK
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

@if($tanggal)

<div style="
    text-align:center;
    margin-bottom:15px;
    font-size:12px;
">

    <b>Tanggal :</b>

    {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}

</div>

@endif

<div class="judul-tabel">
    DATA STOK MATERIAL PENDUKUNG
</div>

<table>

<thead>

<tr>

<th width="5%">No</th>
<th width="12%">Kode</th>
<th>Nama Barang</th>
<th width="15%">Warna</th>
<th width="12%">Stok</th>
<th width="10%">Satuan</th>
<th width="12%">Status</th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->kode }}</td>

<td>{{ $item->nama }}</td>

<td>{{ $item->warna ?? '-' }}</td>

<td class="text-right">
    {{ number_format($item->stok,0) }}
</td>

<td>
    {{ strtoupper($item->satuan) }}
</td>

<td>

    @if($item->stok == 0)

        <span class="habis">
            HABIS
        </span>

    @elseif($item->stok <= 50)

        <span class="menipis">
            MENIPIS
        </span>

    @else

        <span class="aman">
            AMAN
        </span>

    @endif

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

<th colspan="4" style="text-align:right;">
    TOTAL STOK
</th>

<th class="text-right">
    {{ number_format($data->sum('stok'),0) }}
</th>

<th colspan="2">
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