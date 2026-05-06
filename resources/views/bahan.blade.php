@extends('layout.app')

@section('content')

<style>

body{
    background:#0f172a;
    color:#e5e7eb;
}

/* ================= HEADER ================= */

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.page-header h2{
    color:white;
}

/* ================= ACTION ================= */

.action-bar{
    display:flex;
    justify-content:space-between;
    margin-bottom:15px;
}

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
    box-shadow:0 0 10px rgba(99,102,241,0.6);
}

/* ================= TABLE ================= */

.table-box{
    background:rgba(17,24,39,0.7);
    border-radius:16px;
    padding:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

/* HEADER */
thead th{
    padding:12px;
    color:#94a3b8;
    text-align:left;
}

/* BODY */
tbody td{
    padding:12px;
    border-top:1px solid rgba(255,255,255,0.05);
}

/* HOVER */
tbody tr:hover{
    background:rgba(99,102,241,0.05);
}

/* ================= BADGE ================= */

.badge-color{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:rgba(99,102,241,0.15);
    color:#c4b5fd;
}

/* ================= BUTTON ================= */

.btn-edit{
    background:rgba(99,102,241,0.2);
    color:#a5b4fc;
    border:none;
    padding:6px 12px;
    border-radius:8px;
    cursor:pointer;
    transition:0.2s;
}

.btn-edit:hover{
    background:rgba(99,102,241,0.4);
}

.btn-delete{
    background:rgba(239,68,68,0.2);
    color:#ef4444;
    border:none;
    padding:6px 12px;
    border-radius:8px;
    cursor:pointer;
    transition:0.2s;
}

.btn-delete:hover{
    background:rgba(239,68,68,0.4);
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
    backdrop-filter:blur(6px);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content{
    background:linear-gradient(180deg,#0f172a,#020617);
    padding:25px;
    border-radius:16px;
    width:360px;
    display:flex;
    flex-direction:column;
    gap:14px;
    border:1px solid rgba(255,255,255,0.05);
    box-shadow:0 20px 40px rgba(0,0,0,0.5);
}

.modal-content h3{
    margin:0;
    color:white;
}

/* INPUT */
.modal-content input{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.08);
    background:rgba(255,255,255,0.03);
    color:white;
    margin-bottom:12px;
    box-sizing:border-box;
}

.modal-content input::placeholder{
    color:#64748b;
}

/* BUTTON GROUP */
.modal-actions{
    display:flex;
    justify-content:space-between;
    margin-top:10px;
}

.btn-save{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
}

.btn-cancel{
    background:rgba(255,255,255,0.05);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:#94a3b8;
    cursor:pointer;
}

.btn-cancel:hover{
    background:rgba(255,255,255,0.1);
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>Bahan Baku</h2>

</div>

<!-- ================= ACTION ================= -->

<div class="action-bar">

    <button 
        class="btn-primary"
        onclick="openModal()">

        + Tambah Bahan

    </button>

</div>

<!-- ================= TABLE ================= -->

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama</th>
<th>Warna</th>
<th>Satuan</th>
<th>Isi / Satuan</th>
<th>Konversi</th>
<th>Stok</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($data as $d)

<tr>

<td>

    {{ $loop->iteration }}

</td>

<td>

    {{ $d->kode }}

</td>

<td>

    {{ $d->nama }}

</td>

<td>

    <span class="badge-color">

        {{ $d->warna ?? '-' }}

    </span>

</td>

<td>

    {{ $d->satuan }}

</td>

<td>

    {{ $d->isi_per_satuan ?? '-' }}

</td>

<td>

    {{ $d->satuan_konversi ?? '-' }}

</td>

<td>

    {{ $d->stok }}

</td>

<td>

<div style="display:flex; gap:8px; justify-content:center;">

    <!-- EDIT -->
    <button
        type="button"
        class="btn-edit"
        onclick="openEditModal(
            '{{ $d->id }}',
            '{{ $d->kode }}',
            '{{ $d->nama }}',
            '{{ $d->warna }}',
            '{{ $d->satuan }}',
            '{{ $d->isi_per_satuan }}',
            '{{ $d->satuan_konversi }}',
            '{{ $d->stok }}'
        )">

        Edit

    </button>

    <!-- DELETE -->
    <form 
        action="/bahan/{{ $d->id }}"
        method="POST">

        @csrf
        @method('DELETE')

        <button class="btn-delete">

            Hapus

        </button>

    </form>

</div>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<!-- ================= MODAL TAMBAH ================= -->

<div id="modal" class="modal">

    <div class="modal-content">

        <h3>

            Tambah Bahan

        </h3>

        <form method="POST" action="/bahan">

            @csrf

            <input 
                name="kode"
                placeholder="Kode Bahan">

            <input 
                name="nama"
                placeholder="Nama Bahan">

            <input 
                name="warna"
                placeholder="Warna">

            <input 
                name="satuan"
                placeholder="Satuan (ROLL/PACK/PCS)">

            <input 
                type="number"
                step="0.01"
                name="isi_per_satuan"
                placeholder="Isi per satuan">

            <input 
                name="satuan_konversi"
                placeholder="Satuan konversi (Meter/CM)">

            <input 
                type="number"
                step="0.01"
                name="stok"
                placeholder="Stok Awal">

            <div class="modal-actions">

                <button 
                    type="button"
                    class="btn-cancel"
                    onclick="closeModal()">

                    Batal

                </button>

                <button 
                    type="submit"
                    class="btn-save">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<!-- ================= MODAL EDIT ================= -->

<div id="editModal" class="modal">

    <div class="modal-content">

        <h3>Edit Bahan</h3>

        <form 
            method="POST"
            id="editForm">

            @csrf
            @method('PUT')

            <input 
                type="text"
                name="kode"
                id="editKode"
                placeholder="Kode">

            <input 
                type="text"
                name="nama"
                id="editNama"
                placeholder="Nama">

            <input 
                type="text"
                name="warna"
                id="editWarna"
                placeholder="Warna">

            <input 
                type="text"
                name="satuan"
                id="editSatuan"
                placeholder="Satuan">

            <input 
                type="number"
                step="0.01"
                name="isi_per_satuan"
                id="editIsiPerSatuan"
                placeholder="Isi per satuan">

            <input 
                type="text"
                name="satuan_konversi"
                id="editSatuanKonversi"
                placeholder="Satuan konversi">

            <input 
                type="number"
                step="0.01"
                name="stok"
                id="editStok"
                placeholder="Stok">

            <div class="modal-actions">

                <button 
                    type="button"
                    class="btn-cancel"
                    onclick="closeEditModal()">

                    Batal

                </button>

                <button 
                    type="submit"
                    class="btn-save">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openModal(){

    document.getElementById('modal')
        .style.display='flex';

}

function closeModal(){

    document.getElementById('modal')
        .style.display='none';

}

/* ================= EDIT ================= */

function openEditModal(
    id,
    kode,
    nama,
    warna,
    satuan,
    isi_per_satuan,
    satuan_konversi,
    stok
){

    document.getElementById('editModal')
        .style.display='flex';

    document.getElementById('editKode')
        .value = kode;

    document.getElementById('editNama')
        .value = nama;

    document.getElementById('editWarna')
        .value = warna;

    document.getElementById('editSatuan')
        .value = satuan;

    document.getElementById('editIsiPerSatuan')
        .value = isi_per_satuan;

    document.getElementById('editSatuanKonversi')
        .value = satuan_konversi;

    document.getElementById('editStok')
        .value = stok;

    document.getElementById('editForm')
        .action = '/bahan/' + id;

}

function closeEditModal(){

    document.getElementById('editModal')
        .style.display='none';

}

</script>

@endsection