<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Laporan Stok</title>

<style>

body{
    font-family: sans-serif;
}

h2{
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    border:1px solid #000;
    padding:8px;
    font-size:12px;
    text-align:left;
}

th{
    background:#f3f4f6;
}

</style>

</head>

<body>

<h2>Laporan Stok Barang</h2>

<table>

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama Barang</th>
<th>Warna</th>
<th>Stok</th>
<th>Satuan</th>

</tr>

</thead>

<tbody>

@foreach($data as $item)

<tr>

<td>

    {{ $loop->iteration }}

</td>

<td>

    {{ $item->kode }}

</td>

<td>

    {{ $item->nama }}

</td>

<td>

    {{ $item->warna ?? '-' }}

</td>

<td>

    {{ $item->stok }}

</td>

<td>

    {{ $item->satuan }}

</td>

</tr>

@endforeach

</tbody>

</table>

</body>

</html>