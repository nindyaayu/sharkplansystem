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
}

.table-box{
    background:rgba(17,24,39,0.7);
    border-radius:16px;
    padding:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead th{
    padding:12px;
    color:#94a3b8;
    text-align:left;
}

tbody td{
    padding:12px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover{
    background:rgba(99,102,241,0.05);
}

.badge-color{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    background:rgba(99,102,241,0.15);
    color:#c4b5fd;
}

.badge-kain{
    background:rgba(34,197,94,0.15);
    color:#4ade80;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-aksesoris{
    background:rgba(99,102,241,0.15);
    color:#c4b5fd;
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
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
    border:1px solid rgba(255,255,255,0.05);
}

.modal-content h3{
    color:white;
    margin-bottom:15px;
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

@if(request()->is('material-utama'))

<h2>Material Utama</h2>

@elseif(request()->is('material-pendukung'))

<h2>Material Pendukung</h2>

@else

<h2>Bahan Baku</h2>

@endif

</div>

<div class="action-bar">

<button 
class="btn-primary"
onclick="openModal()">

+ Tambah Bahan

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
<th>Kategori</th>
<th>Warna</th>
<th>Satuan</th>

@if(request()->is('material-utama'))

<th>Jumlah Roll</th>
<th>Jumlah Meter</th>

@else

<th>Isi / Satuan</th>
<th>Konversi</th>
<th>Stok</th>

@endif

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

<td>

@if($d->kategori == 'Kain')

<span class="badge-kain">
Material Utama
</span>

@else

<span class="badge-aksesoris">
Material Pendukung
</span>

@endif

</td>

<td>

<span class="badge-color">

{{ $d->warna ?? '-' }}

</span>

</td>

<td>{{ $d->satuan }}</td>

@if($d->kategori == 'Kain')

<td>{{ $d->jumlah_roll ?? 0 }}</td>

<td>{{ $d->jumlah_meter ?? 0 }} Meter</td>

@else

<td>{{ $d->isi_per_satuan ?? '-' }}</td>

<td>{{ $d->satuan_konversi ?? '-' }}</td>

<td>{{ $d->stok ?? 0 }}</td>

@endif

<td>

<div style="display:flex; gap:8px;">

<button
type="button"
class="btn-edit"
onclick="openEditModal(
'{{ $d->id }}',
'{{ $d->kode }}',
'{{ $d->nama }}',
'{{ $d->kategori }}',
'{{ $d->warna }}',
'{{ $d->satuan }}',
'{{ $d->isi_per_satuan }}',
'{{ $d->satuan_konversi }}',
'{{ $d->stok }}',
'{{ $d->jumlah_roll }}',
'{{ $d->jumlah_meter }}'
)">

Edit

</button>

<form action="/bahan/{{ $d->id }}" method="POST">

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

<h3>Tambah Bahan</h3>

<form method="POST" action="/bahan">

@csrf

<input 
name="nama"
placeholder="Nama Bahan">

@if(request()->is('material-utama'))

<input 
type="hidden"
name="kategori"
value="Kain">

@elseif(request()->is('material-pendukung'))

<input 
type="hidden"
name="kategori"
value="Aksesoris">

@endif

<input 
name="warna"
placeholder="Warna">

<input 
name="satuan"
placeholder="Satuan">

@if(request()->is('material-utama'))

<input 
type="number"
name="jumlah_roll"
placeholder="Jumlah Roll">

<input 
type="number"
step="0.01"
name="jumlah_meter"
placeholder="Jumlah Meter">

<input 
type="date"
name="tanggal_input"
value="{{ date('Y-m-d') }}">
@else

<input 
type="number"
step="0.01"
name="isi_per_satuan"
placeholder="Isi per satuan">
<input 
type="date"
name="created_at"
value="{{ date('Y-m-d') }}">
<input 
name="satuan_konversi"
placeholder="Satuan konversi">

<input 
type="number"
step="0.01"
name="stok"
placeholder="Stok">

@endif

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

<h3>Edit Bahan</h3>

<form method="POST" id="editForm">

@csrf
@method('PUT')

<input 
type="hidden"
name="kategori"
value="{{ request()->is('material-utama') ? 'Kain' : 'Aksesoris' }}">

<input 
type="text"
name="kode"
id="editKode">

<input 
type="text"
name="nama"
id="editNama">

<input 
type="text"
name="warna"
id="editWarna">

<input 
type="text"
name="satuan"
id="editSatuan">

@if(request()->is('material-utama'))

<input 
type="number"
name="jumlah_roll"
id="editJumlahRoll"
placeholder="Jumlah Roll">

<input 
type="number"
step="0.01"
name="jumlah_meter"
id="editJumlahMeter"
placeholder="Jumlah Meter">

@else

<input 
type="number"
step="0.01"
name="isi_per_satuan"
id="editIsiPerSatuan">

<input 
type="text"
name="satuan_konversi"
id="editSatuanKonversi">

<input 
type="number"
step="0.01"
name="stok"
id="editStok">

@endif

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
kode,
nama,
kategori,
warna,
satuan,
isi_per_satuan,
satuan_konversi,
stok,
jumlah_roll,
jumlah_meter
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

@if(request()->is('material-utama'))

document.getElementById('editJumlahRoll')
.value = jumlah_roll;

document.getElementById('editJumlahMeter')
.value = jumlah_meter;

@else

document.getElementById('editIsiPerSatuan')
.value = isi_per_satuan;

document.getElementById('editSatuanKonversi')
.value = satuan_konversi;

document.getElementById('editStok')
.value = stok;

@endif

document.getElementById('editForm')
.action = '/bahan/' + id;

}

function closeEditModal(){

document.getElementById('editModal')
.style.display='none';

}

</script>

@endsection