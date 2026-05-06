@extends('layout.app')

@section('content')

<style>

/* ===== GLOBAL ===== */
body {
    background: #0f172a;
    color: #e5e7eb;
}

/* HEADER */
.page-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}
.page-header h2 { color:white; }

/* ACTION */
.action-bar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
}

/* TABLE */
.table-box {
    background: rgba(17,24,39,0.7);
    border-radius:16px;
    padding:15px;
}

/* TABLE */
table {
    width:100%;
    border-collapse:collapse;
}

thead th {
    padding:12px;
    color:#94a3b8;
}

tbody td {
    padding:12px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover {
    background: rgba(99,102,241,0.05);
}

/* ACTION BTN */
.action-btn {
    background: rgba(255,255,255,0.05);
    border:none;
    padding:6px 10px;
    border-radius:8px;
    cursor:pointer;
    color:white;
}

/* DELETE */
.btn-delete {
    background:rgba(239,68,68,0.2);
    color:#ef4444;
}

/* MODAL */
.modal {
    display:none;
    position:fixed;
    top:0; left:0;
    width:100%; height:100%;
    background:rgba(0,0,0,0.7);
    backdrop-filter: blur(6px);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content {
    background: linear-gradient(180deg,#0f172a,#020617);
    padding:25px;
    border-radius:16px;
    width:320px;
    display:flex;
    flex-direction:column;
    gap:14px;
    border:1px solid rgba(255,255,255,0.05);
    box-shadow:0 20px 40px rgba(0,0,0,0.5);
    animation:fadeIn 0.2s ease;
}

.modal-content h3 {
    margin:0;
    color:white;
    font-size:18px;
}

/* INPUT DARK */
.modal-content input {
    padding:12px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.08);
    background: rgba(255,255,255,0.03);
    color:white;
    outline:none;
}

.modal-content input:focus {
    border:1px solid #6366f1;
}

/* BUTTON GROUP */
.modal-actions {
    display:flex;
    justify-content:space-between;
    margin-top:10px;
}

/* SAVE */
.btn-save {
    background: linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
    transition:0.2s;
}

.btn-save:hover {
    box-shadow:0 0 10px rgba(99,102,241,0.6);
}

/* CANCEL */
.btn-cancel {
    background: rgba(255,255,255,0.05);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:#94a3b8;
    cursor:pointer;
}

.btn-cancel:hover {
    background: rgba(255,255,255,0.1);
}

/* ANIMATION */
@keyframes fadeIn {
    from { transform:scale(0.9); opacity:0; }
    to { transform:scale(1); opacity:1; }
}
/* ===== FIX TABLE PRODUK ===== */
table th, 
table td {
    text-align:left;
}

th:nth-child(1),
td:nth-child(1){
    width:60px;
    text-align:center;
}

th:nth-child(2),
td:nth-child(2){
    width:140px;
}

th:nth-child(3),
td:nth-child(3){
    width:40%;
}

th:nth-child(4),
td:nth-child(4){
    width:120px;
    text-align:center;
}

th:nth-child(5),
td:nth-child(5){
    width:120px;
    text-align:center;
}
</style>

<!-- HEADER -->
<div class="page-header">
    <h2>Produk</h2>
    <div class="admin">👤 Admin</div>
</div>

<!-- ACTION -->
<div class="action-bar">
    <button class="btn-primary" onclick="openModal()">+ Tambah Produk</button>
</div>

<!-- TABLE -->
<div class="table-box">
<table>
<thead>
<tr>
<th>No</th>
<th>Kode</th>
<th>Nama</th>
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
<td>{{ $d->satuan }}</td>
<td>
<form action="/produk/{{ $d->id }}" method="POST">
@csrf
@method('DELETE')
<button class="action-btn btn-delete">🗑</button>
</form>
</td>
</tr>
@endforeach
</tbody>

</table>
</div>

<!-- MODAL -->
<!-- MODAL -->
<div id="modal" class="modal">
    <div class="modal-content">

        <h3>Tambah Produk</h3>

        <form method="POST" action="/produk">
            @csrf

            <input name="kode" placeholder="Kode Produk">
            <input name="nama" placeholder="Nama Produk">
            <input name="satuan" placeholder="Satuan (Unit/Pcs)">

            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Batal</button>
                <button type="submit" class="btn-save">Simpan</button>
            </div>

        </form>

    </div>
</div>

<script>
function openModal(){
    document.getElementById('modal').style.display='flex';
}
function closeModal(){
    document.getElementById('modal').style.display='none';
}
</script>

@endsection