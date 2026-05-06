@extends('layout.app')

@section('content')

<style>

/* ===== GLOBAL ===== */
body {
    background: #0f172a;
    color: #e5e7eb;
}

/* ===== HEADER ===== */
.page-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.page-header h2 {
    color:white;
}

/* ===== FORM BOX ===== */
.form-box {
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin-bottom:20px;
}

/* INPUT */
.input {
    background: #111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:white;
    min-width:200px;
}

/* SELECT */
select.input {
    appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='20' viewBox='0 0 20 20' width='20'><path d='M5 7l5 5 5-5H5z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
}

select.input option {
    background: #111827;
    color: #ffffff;
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
    transition:0.3s;
}

.btn-primary:hover {
    box-shadow:0 0 12px rgba(99,102,241,0.6);
}

/* ===== TABLE ===== */
.table-box {
    background: rgba(17,24,39,0.7);
    backdrop-filter: blur(10px);
    border-radius:16px;
    padding:15px;
    border:1px solid rgba(255,255,255,0.05);
}

table {
    width:100%;
    border-collapse:collapse;
}

thead {
    background: rgba(255,255,255,0.03);
}

thead th {
    padding:12px;
    text-align:left;
    font-size:13px;
    color:#94a3b8;
}

tbody td {
    padding:12px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover {
    background: rgba(99,102,241,0.05);
}

/* ACTION */
.action-btn {
    background: rgba(255,255,255,0.05);
    border:none;
    padding:6px 10px;
    border-radius:8px;
    cursor:pointer;
    color:white;
    transition:0.2s;
}

.action-btn:hover {
    background: rgba(99,102,241,0.3);
}

/* TOTAL */
.total-box {
    margin-top:15px;
    text-align:right;
    color:#94a3b8;
    font-size:14px;
}

.total-box span {
    color:white;
    font-weight:600;
}

</style>

<!-- ===== HEADER ===== -->
<div class="page-header">

    <h2>BOM</h2>

    <div class="admin">
        👤 Admin
    </div>

</div>

<!-- ===== FORM ===== -->
<form action="{{ route('bom.store') }}" method="POST">

@csrf

<div class="form-box">

    <!-- PRODUK -->
    <select 
        name="produk_id"
        class="input"
        required>

        <option value="">
            Pilih Produk
        </option>

        @foreach($produk as $item)

        <option value="{{ $item->id }}">

            {{ $item->kode }} - {{ $item->nama }}

        </option>

        @endforeach

    </select>

    <!-- BAHAN -->
    <select 
        name="barang_id"
        class="input"
        required>

        <option value="">
            Pilih Bahan
        </option>

        @foreach($barang as $item)

        <option value="{{ $item->id }}">

            {{ $item->kode }} - {{ $item->nama }}

        </option>

        @endforeach

    </select>

    <!-- QTY -->
    <input 
        type="number"
        name="qty"
        class="input"
        placeholder="Jumlah"
        required>

    <!-- TANGGAL -->
    <input 
        type="date"
        name="tanggal"
        class="input"
        required>

    <button class="btn-primary">
        + Tambah BOM
    </button>

</div>

</form>

<!-- ===== TABLE ===== -->
<div class="table-box">

<table>

<thead>
<tr>
<th>No</th>
<th>Produk</th>
<th>Kode Bahan</th>
<th>Nama Bahan</th>
<th>Satuan</th>
<th>Jumlah</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($bom as $index => $item)

    @foreach($item->details as $detail)

    <tr>

        <td>{{ $index + 1 }}</td>

        <td>
            {{ $item->produk->nama }}
        </td>

        <td>
            {{ $detail->barang->kode }}
        </td>

        <td>
            {{ $detail->barang->nama }}
        </td>

        <td>
            {{ $detail->barang->satuan }}
        </td>

        <td>
            {{ $detail->qty }}
        </td>

        <td>
            {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}
        </td>

        <td style="display:flex; gap:8px;">

            <!-- EDIT -->
            <button class="action-btn">
                ✏️
            </button>

            <!-- HAPUS -->
            <button class="action-btn">
                🗑
            </button>

        </td>

    </tr>

    @endforeach

@empty

<tr>

    <td colspan="8" style="text-align:center;">

        Data BOM masih kosong

    </td>

</tr>

@endforelse

</tbody>

</table>

<div class="total-box">

    Total Komponen:
    <span>

        {{ $bom->count() }}

    </span>

</div>

</div>

@endsection