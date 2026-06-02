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
    margin-bottom:20px;
}

.page-header h2{
    color:white;
}

.action-bar{
    margin-bottom:20px;
}

.btn-primary{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
}

.table-box{
    background:rgba(17,24,39,0.7);
    border-radius:16px;
    padding:15px;
    overflow:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead th{
    padding:12px;
    color:#94a3b8;
    text-align:left;
    font-size:13px;
}

tbody td{
    padding:12px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover{
    background:rgba(99,102,241,0.05);
}

.badge-status{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.status-belum{
    background:rgba(239,68,68,0.2);
    color:#ef4444;
}

.status-proses{
    background:rgba(250,204,21,0.2);
    color:#facc15;
}

.status-selesai{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
}

.action-group{
    display:flex;
    gap:8px;
}

.btn-edit{
    background:rgba(99,102,241,0.2);
    color:#a5b4fc;
    border:none;
    padding:6px 12px;
    border-radius:8px;
    cursor:pointer;
}

.btn-delete{
    background:rgba(239,68,68,0.2);
    color:#ef4444;
    border:none;
    padding:6px 12px;
    border-radius:8px;
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
    width:420px;
}

.modal-content h3{
    color:white;
    margin-bottom:20px;
}

.modal-content input,
.modal-content select{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.08);
    background:rgba(255,255,255,0.03);
    color:white;
    margin-bottom:12px;
    box-sizing:border-box;
}

.modal-actions{
    display:flex;
    justify-content:space-between;
    margin-top:15px;
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

</style>

<div class="page-header">

    <h2>Produk</h2>

</div>

<div class="action-bar">

    <input
        type="text"
        id="searchProduk"
        placeholder="🔍 Cari kode, nama produk, client, no PO..."
        style="
            padding:10px 15px;
            width:350px;
            border:none;
            border-radius:8px;
            background:#1e293b;
            color:white;
        "
    >

    <button
        class="btn-primary"
        onclick="openModal()"
    >
        + Tambah Produk
    </button>

</div>

<div class="table-box">

<table id="tabelProduk">

<thead>

<tr>

<th>No</th>
<th>Tanggal</th>
<th>Kode</th>
<th>Nama Produk</th>
<th>Client</th>
<th>No PO</th>
<th>Qty Order</th>
<th>Qty Kirim</th>
<th>Progress</th>
<th>Status</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($data as $d)

<tr>

<td>{{ $loop->iteration }}</td>

<td>

    {{ $d->created_at->format('d/m/Y') }}

</td>

<td>{{ $d->kode }}</td>

<td>{{ $d->nama }}</td>

<td>{{ $d->client ?? '-' }}</td>

<td>{{ $d->no_po ?? '-' }}</td>

<td>{{ $d->qty_order }}</td>

<td>{{ $d->qty_kirim }}</td>

<td>

    @if($d->qty_order > 0)

        {{ round(($d->qty_kirim / $d->qty_order) * 100) }}%

    @else

        0%

    @endif

</td>

<td>

    <span class="badge-status

    @if($d->status == 'Belum')
        status-belum
    @elseif($d->status == 'Proses')
        status-proses
    @else
        status-selesai
    @endif

    ">

        {{ $d->status }}

    </span>

</td>

<td>

<div class="action-group">

<button
class="btn-edit"
onclick="openEditModal(

'{{ $d->id }}',
'{{ $d->nama }}',
'{{ $d->client }}',
'{{ $d->no_po }}',
'{{ $d->qty_order }}',
'{{ $d->qty_kirim }}',
'{{ $d->tahap }}',
'{{ $d->satuan }}'

)">

Edit

</button>

<form
action="/produk/{{ $d->id }}"
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

<!-- MODAL TAMBAH -->

<div id="modal" class="modal">

<div class="modal-content">

<h3>Tambah Produk</h3>

<form method="POST" action="/produk">

@csrf

<input
name="prefix"
placeholder="Prefix Kode (R/T/P)">

<input
name="nama"
placeholder="Nama Produk">

<input
name="client"
placeholder="Client">

<input
name="no_po"
placeholder="No PO">

<input
type="number"
name="qty_order"
placeholder="Qty Order">

<input
type="number"
name="qty_kirim"
value="0"
placeholder="Qty Kirim">

<select name="tahap">

<option value="Cutting">

    Cutting

</option>

<option value="Sewing">

    Sewing

</option>

<option value="Finishing">

    Finishing

</option>

<option value="Packing">

    Packing

</option>

</select>

<input
name="satuan"
placeholder="Satuan">

<input
type="date"
name="tanggal_input"
value="{{ date('Y-m-d') }}">

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

<!-- MODAL EDIT -->

<div id="editModal" class="modal">

<div class="modal-content">

<h3>Edit Produk</h3>

<form
method="POST"
id="editForm">

@csrf
@method('PUT')

<input
type="text"
name="nama"
id="editNama"
placeholder="Nama Produk">

<input
type="text"
name="client"
id="editClient"
placeholder="Client">

<input
type="text"
name="no_po"
id="editNoPo"
placeholder="No PO">

<input
type="number"
name="qty_order"
id="editQtyOrder"
placeholder="Qty Order">

<input
type="number"
name="qty_kirim"
id="editQtyKirim"
placeholder="Qty Kirim">

<select
name="tahap"
id="editTahap">

<option value="Cutting">

    Cutting

</option>

<option value="Sewing">

    Sewing

</option>

<option value="Finishing">

    Finishing

</option>

<option value="Packing">

    Packing

</option>

</select>

<input
type="text"
name="satuan"
id="editSatuan"
placeholder="Satuan">

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

function openEditModal(
id,
nama,
client,
no_po,
qty_order,
qty_kirim,
tahap,
satuan
){

document.getElementById('editModal')
.style.display='flex';

document.getElementById('editNama')
.value = nama;

document.getElementById('editClient')
.value = client;

document.getElementById('editNoPo')
.value = no_po;

document.getElementById('editQtyOrder')
.value = qty_order;

document.getElementById('editQtyKirim')
.value = qty_kirim;

document.getElementById('editTahap')
.value = tahap;

document.getElementById('editSatuan')
.value = satuan;

document.getElementById('editForm')
.action = '/produk/' + id;

}

function closeEditModal(){

document.getElementById('editModal')
.style.display='none';

}

document
    .getElementById('searchProduk')
    .addEventListener('keyup', function () {

        let keyword =
            this.value.toLowerCase();

        let rows =
            document.querySelectorAll(
                '#tabelProduk tbody tr'
            );

        rows.forEach(row => {

            let text =
                row.innerText.toLowerCase();

            row.style.display =
                text.includes(keyword)
                ? ''
                : 'none';

        });

    });
    
</script>

@endsection