@extends('layout.app')

@section('content')

<style>

body{
    background:#0f172a;
    color:#e5e7eb;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-header h2{
    color:white;
}

/* ================= FORM ================= */

.form-box{
    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:16px;
    padding:20px;
    margin-bottom:20px;
}

.form-row{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    align-items:center;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:white;
    min-width:180px;
}

select.input option{
    background:#111827;
}

/* ================= BUTTON ================= */

.btn-primary{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
    transition:0.3s;
}

.btn-primary:hover{
    box-shadow:0 0 12px rgba(99,102,241,0.6);
}

.action-btn{
    background:rgba(255,255,255,0.05);
    border:none;
    padding:6px 10px;
    border-radius:8px;
    color:white;
    cursor:pointer;
    transition:0.2s;
}

.action-btn:hover{
    background:rgba(99,102,241,0.3);
}

.btn-delete{
    background:rgba(239,68,68,0.15);
    color:#ef4444;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

/* ================= TABLE ================= */

.table-box{
    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
    margin-bottom:20px;
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
    color:#94a3b8;
}

tbody td{
    padding:14px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover{
    background:rgba(99,102,241,0.05);
}

.badge{
    background:rgba(99,102,241,0.15);
    color:#a5b4fc;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.title-section{
    margin-bottom:15px;
    font-size:16px;
    font-weight:600;
    color:white;
}

.component-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

.component-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:5px;
}

.component-subtitle{
    color:#94a3b8;
}

/* ================= MODAL ================= */

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(5px);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content{
    background:#111827;
    padding:25px;
    border-radius:16px;
    width:400px;
    border:1px solid rgba(255,255,255,0.05);
}

.modal-title{
    font-size:18px;
    margin-bottom:20px;
    color:white;
}

.modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>Master BOM</h2>

    <div>
        👤 Admin
    </div>

</div>

<!-- ================================================= -->
<!-- FORM TAMBAH KOMPONEN -->
<!-- ================================================= -->

<div class="form-box">

<div class="title-section">

    Tambah Komponen

</div>

<form action="{{ route('master-bom.store') }}" method="POST">

@csrf

<div class="form-row">

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

    <!-- NAMA KOMPONEN -->
    <input 
        type="text"
        name="nama_komponen"
        class="input"
        placeholder="Nama Komponen"
        required>

    <!-- TANGGAL -->
    <input 
        type="date"
        name="tanggal"
        class="input"
        required>

    <button 
        type="submit"
        class="btn-primary">

        + Buat Komponen

    </button>

</div>

</form>

</div>

<!-- ================================================= -->
<!-- LIST KOMPONEN -->
<!-- ================================================= -->

@foreach($bom as $item)

<div class="table-box">

<!-- ================= HEADER KOMPONEN ================= -->

<div class="component-header">

    <div>

        <div class="component-title">

            {{ $item->produk->nama }}

        </div>

        <div class="component-subtitle">

            Komponen:
            {{ $item->nama_komponen }}

        </div>

    </div>

    <!-- HAPUS KOMPONEN -->
    <form 
        action="{{ route('master-bom.destroy', $item->id) }}"
        method="POST">

        @csrf
        @method('DELETE')

        <button 
            type="submit"
            class="btn-delete"
            onclick="return confirm('Hapus komponen ini?')">

            🗑 Hapus Komponen

        </button>

    </form>

</div>

<!-- ================= FORM TAMBAH BAHAN ================= -->

<div style="padding:20px;">

<form action="{{ route('bom-detail.store') }}" method="POST">

@csrf

<input 
    type="hidden"
    name="bom_id"
    value="{{ $item->id }}">

<div class="form-row">

    <!-- BAHAN -->
    <select 
        name="barang_id"
        class="input"
        required>

        <option value="">
            Pilih Bahan
        </option>

        @foreach($barang as $bahan)

        <option value="{{ $bahan->id }}">

            {{ $bahan->kode }} - {{ $bahan->nama }}

        </option>

        @endforeach

    </select>

    <!-- QTY -->
    <input 
        type="number"
        step="0.01"
        name="qty"
        class="input"
        placeholder="Qty per 1 pcs"
        required>

    <!-- SATUAN PAKAI -->
    <select 
        name="satuan_pakai"
        class="input"
        required>

        <option value="">
            Satuan Pakai
        </option>

        <option value="CM">
            CM
        </option>

        <option value="METER">
            METER
        </option>

        <option value="PCS">
            PCS
        </option>

        <option value="ROLL">
            ROLL
        </option>

    </select>

    <button 
        type="submit"
        class="btn-primary">

        + Tambah Bahan

    </button>

</div>

</form>

</div>

<!-- ================= TABLE DETAIL ================= -->

<table>

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama Bahan</th>
<th>Satuan Gudang</th>
<th>Qty / pcs</th>
<th>Satuan Pakai</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($item->details as $index => $detail)

<tr>

<td>

    {{ $index + 1 }}

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

    {{ number_format($detail->qty,2) }}

</td>

<td>

    <span class="badge">

        {{ $detail->satuan_pakai }}

    </span>

</td>

<!-- ================= AKSI ================= -->

<td style="display:flex; gap:8px;">

    <!-- EDIT -->
    <button 
        type="button"
        class="action-btn"

        onclick="openEditModal(

            '{{ $detail->id }}',

            '{{ $detail->qty }}',

            '{{ $detail->satuan_pakai }}'

        )">

        ✏️

    </button>

    <!-- HAPUS -->
    <form 
        action="{{ route('bom-detail.destroy', $detail->id) }}"
        method="POST">

        @csrf
        @method('DELETE')

        <button 
            type="submit"
            class="action-btn"
            onclick="return confirm('Hapus bahan ini?')">

            🗑️

        </button>

    </form>

</td>

</tr>

@empty

<tr>

<td colspan="7" style="text-align:center;">

    Belum ada bahan

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endforeach

<!-- ================= MODAL EDIT ================= -->

<div class="modal" id="editModal">

    <div class="modal-content">

        <div class="modal-title">

            Edit BOM Detail

        </div>

        <form 
            method="POST"
            id="editForm">

            @csrf
            @method('PUT')

            <!-- QTY -->
            <input 
                type="number"
                step="0.01"
                name="qty"
                id="editQty"
                class="input"
                placeholder="Qty"
                required>

            <br><br>

            <!-- SATUAN -->
            <select 
                name="satuan_pakai"
                id="editSatuan"
                class="input"
                required>

                <option value="CM">CM</option>

                <option value="METER">METER</option>

                <option value="PCS">PCS</option>

                <option value="ROLL">ROLL</option>

            </select>

            <div class="modal-actions">

                <button 
                    type="button"
                    class="action-btn"
                    onclick="closeEditModal()">

                    Batal

                </button>

                <button 
                    type="submit"
                    class="btn-primary">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openEditModal(id, qty, satuan){

    document
        .getElementById('editModal')
        .style.display = 'flex';

    document
        .getElementById('editQty')
        .value = qty;

    document
        .getElementById('editSatuan')
        .value = satuan;

    document
        .getElementById('editForm')
        .action = '/bom-detail/' + id;
}

function closeEditModal(){

    document
        .getElementById('editModal')
        .style.display = 'none';
}

</script>

@endsection