<!DOCTYPE html>
<html>
<head>

    <title>
        Laporan Material Utama
    </title>

    <style>

        body{
            font-family:sans-serif;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        p{
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

    Laporan Material Utama

</h2>

@if($tanggal)

<p>

    Tanggal :
    {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}

</p>

@endif

<table>

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama Barang</th>
<th>Warna</th>
<th>Jumlah Roll</th>
<th>Jumlah Meter</th>
<th>Status</th>

</tr>

</thead>

<tbody>

@foreach($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->kode }}</td>

<td>{{ $item->nama }}</td>

<td>{{ $item->warna }}</td>

<td>{{ $item->jumlah_roll }} Roll</td>

<td>{{ $item->jumlah_meter }} Meter</td>

<td>

    @if($item->jumlah_meter == 0)

        Habis

    @elseif($item->jumlah_meter <= 500)

        Menipis

    @else

        Aman

    @endif

</td>

</tr>

@endforeach

</tbody>

</table>

</body>
</html>