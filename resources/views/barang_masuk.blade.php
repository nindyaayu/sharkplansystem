@extends('layout.app')

@section('content')

<style>

.page-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:25px;
}

.page-header h2{
    color:white;
    font-weight:600;
}

.filter-bar{
    display:flex;
    gap:15px;
    align-items:end;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:#e5e7eb;
}

.btn-primary{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    font-weight:500;
    cursor:pointer;
}

.table-box{
    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:rgba(255,255,255,0.03);
}

thead th{
    padding:14px;
    text-align:left;
    font-size:13px;
    color:#e2e8f0;
    border-bottom:1px solid rgba(255,255,255,0.08);
}

tbody td{
    padding:14px;
    color:#f1f5f9;
    font-size:14px;
}

tbody tr{
    border-top:1px solid rgba(255,255,255,0.05);
}

.badge-in{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.action-btn{
    background:rgba(255,255,255,0.05);
    border:none;
    padding:6px 10px;
    border-radius:8px;
    color:#e5e7eb;
    cursor:pointer;
}

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content{
    background:#111827;
    padding:25px;
    border-radius:16px;
    width:400px;
    border:1px solid rgba(255,255,255,0.08);
}

.modal-content h3{
    color:white;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    color:#cbd5e1;
    display:block;
    margin-bottom:6px;
}

.form-actions{
    display:flex;
    justify-content:end;
    gap:10px;
    margin-top:20px;
}

</style>

<div class="page-header">

    <h2>Barang Masuk</h2>

</div>
<!-- FILTER -->

<div class="card filter-card">

    <form method="GET"
      style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">

    <input
        type="date"
        name="tanggal_awal"
        value="{{ request('tanggal_awal') }}"
        class="input">

    <span style="color:white;">
        s/d
    </span>

    <input
        type="date"
        name="tanggal_akhir"
        value="{{ request('tanggal_akhir') }}"
        class="input">

    <button
        type="submit"
        class="btn-primary">

        🔍 Tampilkan

    </button>

    <a
        href="{{ url()->current() }}"
        class="btn-secondary">

        ♻ Reset

    </a>

    <a
        href="{{ request()->is('barang-masuk-material-utama')
            ? route('barang-masuk-material-utama-pdf',[
                'tanggal_awal'=>request('tanggal_awal'),
                'tanggal_akhir'=>request('tanggal_akhir')
            ])
            : route('barang-masuk-material-pendukung-pdf',[
                'tanggal_awal'=>request('tanggal_awal'),
                'tanggal_akhir'=>request('tanggal_akhir')
            ]) }}"
        class="btn-secondary"
        style="text-decoration:none;">

        📄 Export PDF

    </a>

</form>

</div>

<!-- STATISTIK -->

<div class="stats-grid">

    <div class="card stat-card">

        <div class="stat-title">
            Total Transaksi
        </div>

        <div class="stat-value">
            {{ number_format($totalTransaksi) }}
        </div>

    </div>

    <div class="card stat-card">

        <div class="stat-title">
            Total Qty
        </div>

        <div class="stat-value">
            {{ number_format($totalQty) }}
        </div>

    </div>

    <div class="card stat-card">

        <div class="stat-title">
            Hari Ini
        </div>

        <div class="stat-value">
            {{ $hariIni }}
        </div>

    </div>

    <div class="card stat-card">

        <div class="stat-title">
            Bulan Ini
        </div>

        <div class="stat-value">
            {{ $bulanIni }}
        </div>

    </div>

</div>

<div class="filter-bar">

    <button
        class="btn-primary"
        onclick="document.getElementById('modalInput').style.display='flex'">

        + Input Barang

    </button>

</div>

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>Tanggal</th>
<th>Kode</th>
<th>Nama</th>
<th>Supplier</th>

@if(request()->is('barang-masuk-material-utama'))

    <th>Roll</th>
    <th>Meter</th>

@else

    <th>Jumlah</th>

@endif

<th>Satuan</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($barangMasuks as $index => $item)

<tr>

<td>{{ $index + 1 }}</td>

<td>
{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
</td>

<td>{{ $item->barang->kode }}</td>

<td>{{ $item->barang->nama }}</td>

<td>{{ $item->supplier }}</td>

@if(request()->is('barang-masuk-material-utama'))

    <td>

        <span class="badge-in">

            {{ $item->jumlah_roll ?? 0 }} Roll

        </span>

    </td>

    <td>

        <span class="badge-in">

            {{ $item->jumlah }} Meter

        </span>

    </td>

@else

    <td>

        <span class="badge-in">

            {{ $item->jumlah }}

        </span>

    </td>

@endif

<td>{{ $item->barang->satuan }}</td>

<td style="display:flex; gap:8px;">

<button
    class="action-btn"
    onclick="document.getElementById('editModal{{ $item->id }}').style.display='flex'">

    ✏️

</button>

<form
    action="{{ route('barang-masuk.destroy', $item->id) }}"
    method="POST">

    @csrf
    @method('DELETE')

    <button class="action-btn">

        🗑

    </button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<!-- ================= MODAL EDIT ================= -->

@foreach($barangMasuks as $item)

<div id="editModal{{ $item->id }}" class="modal">

<div class="modal-content">

<h3>Edit Barang Masuk</h3>

<form
    action="{{ route('barang-masuk.update', $item->id) }}"
    method="POST">

@csrf
@method('PUT')

<div class="form-group">

<label>Barang</label>

<select
    name="barang_id"
    class="input"
    style="width:100%;">

    @foreach($barangs as $barang)

    <option
        value="{{ $barang->id }}"
        {{ $barang->id == $item->barang_id ? 'selected' : '' }}>

        {{ $barang->kode }} - {{ $barang->nama }}

    </option>

    @endforeach

</select>

</div>

<div class="form-group">

<label>Supplier</label>

<input
    type="text"
    name="supplier"
    value="{{ $item->supplier }}"
    class="input"
    style="width:100%;"
    required>

</div>

@if(request()->is('barang-masuk-material-utama'))

<div class="form-group">

<label>Jumlah Roll</label>

<input
    type="number"
    name="jumlah_roll"
    value="{{ $item->jumlah_roll ?? 0 }}"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-group">

<label>Jumlah Meter</label>

<input
    type="number"
    name="jumlah"
    value="{{ $item->jumlah }}"
    class="input"
    style="width:100%;"
    required>

</div>

@else

<div class="form-group">

<label>Jumlah</label>

<input
    type="number"
    name="jumlah"
    value="{{ $item->jumlah }}"
    class="input"
    style="width:100%;"
    required>

</div>

@endif

<div class="form-group">

<label>Tanggal Masuk</label>

<input
    type="date"
    name="tanggal_masuk"
    value="{{ $item->tanggal_masuk }}"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-actions">

<button
    type="button"
    class="action-btn"
    onclick="document.getElementById('editModal{{ $item->id }}').style.display='none'">

    Batal

</button>

<button type="submit" class="btn-primary">

    Update

</button>

</div>

</form>

</div>
</div>

@endforeach

<!-- ================= MODAL INPUT ================= -->

<div id="modalInput" class="modal">

<div class="modal-content">

<h3>Input Barang Masuk</h3>

<form action="{{ route('barang-masuk.store') }}" method="POST">

@csrf

<div class="form-group">

<label>Barang</label>

<select
    name="barang_id"
    class="input"
    style="width:100%;">

    @foreach($barangs as $barang)

    <option value="{{ $barang->id }}">

        {{ $barang->kode }} - {{ $barang->nama }}

    </option>

    @endforeach

</select>

</div>

<div class="form-group">

<label>Supplier</label>

<input
    type="text"
    name="supplier"
    class="input"
    style="width:100%;"
    required>

</div>

@if(request()->is('barang-masuk-material-utama'))

<div class="form-group">

<label>Jumlah Roll</label>

<input
    type="number"
    name="jumlah_roll"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-group">

<label>Jumlah Meter</label>

<input
    type="number"
    name="jumlah"
    class="input"
    style="width:100%;"
    required>

</div>

@else

<div class="form-group">

<label>Jumlah</label>

<input
    type="number"
    name="jumlah"
    class="input"
    style="width:100%;"
    required>

</div>

@endif

<div class="form-group">

<label>Tanggal Masuk</label>

<input
    type="date"
    name="tanggal_masuk"
    value="{{ date('Y-m-d') }}"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-actions">

<button
    type="button"
    class="action-btn"
    onclick="document.getElementById('modalInput').style.display='none'">

    Batal

</button>

<button type="submit" class="btn-primary">

    Simpan

</button>

</div>

</form>

</div>
</div>

@endsection