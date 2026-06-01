<!DOCTYPE html>
<html>
<head>

    <title>
        Laporan Barang (Material Utama) Masuk
    </title>

    <style>

        body{
            font-family:sans-serif;
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th,
        table td{
            border:1px solid #000;
            padding:8px;
            font-size:12px;
        }

        table th{
            background:#f3f4f6;
        }

    </style>

</head>

<body>

<h2>
    Laporan Barang (Material Utama) Masuk
</h2>

@if(!empty($tanggal_awal) && !empty($tanggal_akhir))

<p style="text-align:center;">

    Periode :

    {{ \Carbon\Carbon::parse($tanggal_awal)->format('d-m-Y') }}

    s/d

    {{ \Carbon\Carbon::parse($tanggal_akhir)->format('d-m-Y') }}

</p>

@endif

<table>

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama Barang</th>
<th>Supplier</th>
<th>Total Roll</th>
<th>Total Meter</th>

</tr>

</thead>

<tbody>

@foreach($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->kode }}</td>

<td>{{ $item->nama }}</td>

<td>{{ $item->supplier }}</td>

<td>{{ $item->roll }}</td>

<td>{{ $item->meter }}</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>