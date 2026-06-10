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
<th>Kode</th>
<th>Nama Produk</th>
<th>Model / Warna</th>
<th>Satuan</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($data as $d)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $d->kode }}</td>

<td>{{ $d->nama }}</td>

<td>{{ $d->varian }}</td>

<td>{{ $d->satuan }}</td>

<td>

<div class="action-group">

<button
class="btn-edit"
onclick="openKomponenModal(
'{{ $d->id }}',
'{{ $d->nama }}'
)">
Detail Komponen
</button>

<button
class="btn-edit"
onclick="openEditModal(
'{{ $d->id }}',
'{{ $d->nama }}',
'{{ $d->varian }}',
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
name="varian"
placeholder="Model / Warna">

<input
name="satuan"
placeholder="Satuan">

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
name="varian"
id="editVarian"
placeholder="Model / Warna">

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

<div id="komponenModal" class="modal">

<div class="modal-content"
style="
width:900px;
max-width:95%;
height:80vh;
background:#04143d;
border:1px solid rgba(255,255,255,.08);
display:flex;
flex-direction:column;
">

<div style="
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:20px;
">

<h2
id="judulProduk"
style="
color:white;
margin:0;
">
Komponen Produk
</h2>

<button
onclick="closeKomponenModal()"
style="
background:none;
border:none;
font-size:30px;
color:#94a3b8;
cursor:pointer;
">
×
</button>

</div>

<form id="formKomponen">

@csrf

<input
type="hidden"
name="produk_id"
id="produk_id">

<input
type="text"
name="nama_komponen"
id="nama_komponen"
placeholder="Nama Komponen">

<button
type="button"
id="btnSimpanKomponen"
class="btn-primary">
Simpan
</button>

</form>

<div
style="
flex:1;
overflow-y:auto;
margin-top:15px;
">

<table
style="
width:100%;
color:white;
">

<thead>

<tr>

<th>No</th>

<th>Nama Komponen</th>

<th>Aksi</th>

</tr>

</thead>

<tbody id="listKomponen">


</tbody>

</table>

</div>

</div>

<div id="subKomponenModal" class="modal">

<div class="modal-content"
style="
width:700px;
max-width:95%;
height:70vh;
background:#04143d;
display:flex;
flex-direction:column;
">

<div style="
display:flex;
justify-content:space-between;
align-items:center;
">

<h2
id="judulSubKomponen"
style="margin:0;color:white;">
Sub Komponen
</h2>

<button
onclick="closeSubKomponenModal()"
style="
background:none;
border:none;
font-size:30px;
color:white;
cursor:pointer;
">
×
</button>

</div>

<hr>

<form id="formSubKomponen">

@csrf

<input
type="hidden"
id="parent_id"
name="parent_id">

<input
type="text"
name="nama_komponen"
id="nama_sub_komponen"
placeholder="Nama Sub Komponen">

<button
type="button"
id="btnSimpanSubKomponen"
class="btn-primary">
Simpan
</button>

</form>

<div
style="
flex:1;
overflow-y:auto;
margin-top:15px;
">

<table style="width:100%;">

<thead>

<tr>

<th>No</th>
<th>Sub Komponen</th>
<th>Aksi</th>

</tr>

</thead>

<tbody id="listSubKomponen">

</tbody>

</table>

</div>

</div>

</div>

<div id="editKomponenModal"
class="modal"
style="display:none;">

<div class="modal-content"
style="
width:500px;
max-width:95%;
background:#04143d;
padding:20px;
border-radius:12px;
">

<div style="
display:flex;
justify-content:space-between;
align-items:center;
">

<h2 style="
color:white;
margin:0;
">
Edit Komponen
</h2>

<button
onclick="closeEditKomponenModal()"
style="
background:none;
border:none;
color:white;
font-size:28px;
cursor:pointer;
">
×
</button>

</div>

<input
type="hidden"
id="edit_komponen_id">

<input
type="text"
id="edit_nama_komponen"
placeholder="Nama Komponen"
style="
width:100%;
margin-top:20px;
">

<div style="
margin-top:20px;
display:flex;
justify-content:flex-end;
gap:10px;
">

<button
class="btn-delete"
onclick="closeEditKomponenModal()">
Batal
</button>

<button
class="btn-primary"
id="btnUpdateKomponen">
Simpan
</button>

</div>

</div>

</div>

@if(session('buka_komponen'))

<script>

window.onload = function(){

    openKomponenModal(
        '{{ session("buka_komponen") }}',
        'CONTOH'
    );

};

</script>

@endif

<script>

let currentEditRow = null;

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
varian,
satuan
){

document.getElementById('editVarian')
.value = varian;

document.getElementById('editModal')
.style.display='flex';

document.getElementById('editNama')
.value = nama;

document.getElementById('editSatuan')
.value = satuan;

document.getElementById('editForm')
.action = '/produk/' + id;

}

function openKomponenModal(
id,
nama
){

document.getElementById(
'komponenModal'
).style.display='flex';

document.getElementById(
'judulProduk'
).innerHTML =
'Komponen Produk - ' + nama;

document.getElementById(
'produk_id'
).value = id;

fetch(
'/komponen-produk/' + id
)
.then(response => response.json())
.then(data => {

let tbody =
document.getElementById(
'listKomponen'
);

tbody.innerHTML = '';

data.forEach((item,index)=>{

tbody.insertAdjacentHTML(
'beforeend',
`
<tr>

<td>${index + 1}</td>

<td>${item.nama_komponen}</td>

<td>

<button
class="btn-primary"
onclick="openSubKomponenModal(
'${item.id}',
'${item.nama_komponen}'
)">
Sub Komponen
</button>

<button
class="btn-edit"
onclick="editKomponen(
'${item.id}',
'${item.nama_komponen}',
this
)">
Edit
</button>

<button
class="btn-delete"
onclick="hapusKomponen(
'${item.id}',
this
)">
Hapus
</button>

</td>

</tr>
`
);

});

});

}


function closeKomponenModal(){

document.getElementById(
'komponenModal'
).style.display='none';

}

function openSubKomponenModal(
id,
nama
){

document.getElementById(
'subKomponenModal'
).style.display='flex';

document.getElementById(
'judulSubKomponen'
).innerHTML =
'Sub Komponen - ' + nama;

document.getElementById(
'parent_id'
).value = id;

fetch('/sub-komponen/' + id)

.then(response => response.json())

.then(data => {

let tbody =
document.getElementById(
'listSubKomponen'
);

tbody.innerHTML = '';

data.forEach((item,index)=>{

tbody.insertAdjacentHTML(
'beforeend',
`
<tr>

<td>${index + 1}</td>

<td>${item.nama_komponen}</td>

    <td>

    <button
    class="btn-edit"
    onclick="editSubKomponen(
    '${item.id}',
    '${item.nama_komponen}',
    this
    )">
    Edit
    </button>

    <button
    class="btn-delete"
    onclick="hapusSubKomponen(
    '${item.id}',
    this
    )">
    Hapus
    </button>

    </td>

    </tr>
    `
    );

});

});

}

function closeEditKomponenModal(){

document.getElementById(
'editKomponenModal'
).style.display='none';

}

function closeSubKomponenModal(){

document.getElementById(
'subKomponenModal'
).style.display='none';

}

function hapusKomponen(
id,
button
){

if(
!confirm(
'Hapus komponen ini?'
)
){
return;
}

fetch(
'/komponen-produk/' + id,
{

method:'DELETE',

headers:{
'X-CSRF-TOKEN':
document.querySelector(
'input[name="_token"]'
).value
}

}
)
.then(response=>response.json())
.then(data=>{

button
.closest('tr')
.remove();

});

}

function editKomponen(
id,
namaLama,
button
){

currentEditRow =
button.closest('tr');

document.getElementById(
'editKomponenModal'
).style.display='flex';

document.getElementById(
'edit_komponen_id'
).value = id;

document.getElementById(
'edit_nama_komponen'
).value = namaLama;

}

function closeEditModal(){

document.getElementById('editModal')
.style.display='none';

}
    
document
.getElementById('btnSimpanKomponen')
.addEventListener('click', function(){

    let form =
        document.getElementById(
            'formKomponen'
        );

    let formData =
        new FormData(form);

    fetch('/komponen-produk', {

        method:'POST',

        headers:{
            'X-CSRF-TOKEN':
            document.querySelector(
                'input[name="_token"]'
            ).value
        },

        body:formData

    })
    .then(response => response.json())
    .then(data => {
        console.log(data);

    let namaKomponen =
        document.getElementById(
            'nama_komponen'
        ).value;

    let tbody =
        document.getElementById(
            'listKomponen'
        );

    let nomor =
        tbody.querySelectorAll('tr').length + 1;

    tbody.insertAdjacentHTML(
        'beforeend',
        `
        <tr>

        <td>${nomor}</td>

        <td>${namaKomponen}</td>

        <td>

        <button
        class="btn-primary"
        onclick="openSubKomponenModal(
        ${data.id},
        '${namaKomponen}'
        )">
        Sub Komponen
        </button>

        <button
            class="btn-edit"
            onclick="editKomponen(
            '${data.id}',
            '${namaKomponen}',
            this
            )">
            Edit
            </button>

            <button
            class="btn-delete"
            onclick="hapusKomponen(
            '${data.id}',
            this
            )">
            Hapus
            </button>

        </td>

        </tr>
        `
        );

    document.getElementById(
        'nama_komponen'
    ).value='';

});

});

document
.getElementById(
'btnSimpanSubKomponen'
)
.addEventListener(
'click',
function(){

let form =
document.getElementById(
'formSubKomponen'
);

let formData =
new FormData(form);

fetch('/sub-komponen',{

method:'POST',

headers:{
'X-CSRF-TOKEN':
document.querySelector(
'input[name="_token"]'
).value
},

body:formData

})
.then(response=>response.json())
.then(data=>{

let nama =
document.getElementById(
'nama_sub_komponen'
).value;

let tbody =
document.getElementById(
'listSubKomponen'
);

let nomor =
tbody.querySelectorAll(
'tr'
).length + 1;

tbody.insertAdjacentHTML(
'beforeend',
`
<tr>
<td>${nomor}</td>
<td>${nama}</td>
</tr>
`
);

document.getElementById(
'nama_sub_komponen'
).value='';

});

});

document
.getElementById(
'btnUpdateKomponen'
)
.addEventListener(
'click',
function(){

let id =
document.getElementById(
'edit_komponen_id'
).value;

let nama =
document.getElementById(
'edit_nama_komponen'
).value;

fetch(
'/komponen-produk/' + id,
{
method:'PUT',

headers:{
'Content-Type':'application/json',

'X-CSRF-TOKEN':
document.querySelector(
'input[name="_token"]'
).value
},

body:JSON.stringify({
nama_komponen:nama
})
}
)
.then(response=>response.json())
.then(data=>{

currentEditRow
.querySelectorAll('td')[1]
.innerHTML = nama;

closeEditKomponenModal();

});

});

function hapusSubKomponen(
id,
button
){

if(
!confirm(
'Hapus sub komponen ini?'
)
){
return;
}

fetch(
'/komponen-produk/' + id,
{
method:'DELETE',

headers:{
'X-CSRF-TOKEN':
document.querySelector(
'input[name="_token"]'
).value
}
}
)

.then(response=>response.json())

.then(data=>{

button
.closest('tr')
.remove();

});

}

function editSubKomponen(
id,
namaLama,
button
){

let namaBaru =
prompt(
'Nama Sub Komponen',
namaLama
);

if(
!namaBaru
){
return;
}

fetch(
'/komponen-produk/' + id,
{

method:'PUT',

headers:{
'Content-Type':
'application/json',

'X-CSRF-TOKEN':
document.querySelector(
'input[name="_token"]'
).value
},

body:JSON.stringify({

nama_komponen:
namaBaru

})

}

)

.then(response=>response.json())

.then(data=>{

button
.closest('tr')
.children[1]
.innerHTML =
namaBaru;

});

}
</script>

@endsection