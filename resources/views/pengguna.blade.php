@extends('layout.app')

@section('content')

<style>

/* ===== HEADER ===== */
.page-header {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-header h2 {
    color:white;
    font-weight:600;
}

/* BUTTON */
.btn-primary {
    background: linear-gradient(90deg,#6366f1,#8b5cf6);
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

/* TABLE */
.table-box {
    background:rgba(17,24,39,0.7);
    backdrop-filter: blur(10px);
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
}

table {
    width:100%;
    border-collapse:collapse;
}

thead {
    background:rgba(255,255,255,0.03);
}

thead th {
    padding:14px;
    text-align:left;
    color:#e2e8f0;
    font-size:13px;
}

tbody td {
    padding:14px;
    color:#f1f5f9;
}

tbody tr {
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover {
    background:rgba(99,102,241,0.08);
}

/* ROLE BADGE */
.role-admin {
    background:#22c55e;
    color:white;
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
}

.role-staff {
    background:#f59e0b;
    color:white;
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
}

/* ACTION */
.action-btn {
    background:rgba(255,255,255,0.05);
    border:none;
    padding:6px 10px;
    border-radius:8px;
    color:white;
    cursor:pointer;
}

.action-btn:hover {
    background:rgba(99,102,241,0.4);
}

</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h2>Manajemen Pengguna</h2>
    <button class="btn-primary">+ Tambah User</button>
</div>

<!-- ===== TABLE ===== -->
<div class="table-box">
<table>
<thead>
<tr>
<th>No</th>
<th>Nama</th>
<th>Email</th>
<th>Role</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<tr>
<td>1</td>
<td>Admin</td>
<td>admin@gmail.com</td>
<td><span class="role-admin">Admin</span></td>
<td>
<button class="action-btn">✏</button>
<button class="action-btn">🗑</button>
</td>
</tr>

<tr>
<td>2</td>
<td>Staff Gudang</td>
<td>staff@gmail.com</td>
<td><span class="role-staff">Staff</span></td>
<td>
<button class="action-btn">✏</button>
<button class="action-btn">🗑</button>
</td>
</tr>

</tbody>
</table>
</div>

@endsection