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

/* ===== ACTION BAR ===== */
.action-bar {
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

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

/* SEARCH */
.search-box {
    background: rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.1);
    padding:8px 12px;
    border-radius:10px;
    color:white;
}

/* ===== TABLE CONTAINER ===== */
.table-box {
    background: rgba(17,24,39,0.7);
    backdrop-filter: blur(10px);
    border-radius:16px;
    padding:15px;
    border:1px solid rgba(255,255,255,0.05);
}

/* ===== TABLE ===== */
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
    font-size:14px;
}

/* hover row */
tbody tr:hover {
    background: rgba(99,102,241,0.05);
}

/* ===== BADGE STOK ===== */
.badge {
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
}

.badge-safe {
    background: rgba(34,197,94,0.2);
    color:#22c55e;
}

.badge-low {
    background: rgba(245,158,11,0.2);
    color:#f59e0b;
}

.badge-danger {
    background: rgba(239,68,68,0.2);
    color:#ef4444;
}

/* ===== ACTION BUTTON ===== */
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

/* ===== PAGINATION ===== */
.pagination {
    margin-top:20px;
    display:flex;
    justify-content:center;
    gap:8px;
}

.page-item {
    padding:6px 10px;
    border-radius:8px;
    background: rgba(255,255,255,0.05);
    cursor:pointer;
}

.page-item.active {
    background: linear-gradient(90deg, #6366f1, #8b5cf6);
}

</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h2>Bahan Baku</h2>

    <div class="admin">
        👤 Admin
    </div>
</div>

<!-- ===== ACTION ===== -->
<div class="action-bar">
    <button class="btn-primary">+ Tambah Bahan</button>

    <input type="text" class="search-box" placeholder="Cari bahan...">
</div>

<!-- ===== TABLE ===== -->
<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Satuan</th>
                <th>Stok</th>
                <th>Min</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>BB001</td>
                <td>Besi Hollow 4x4</td>
                <td>Kg</td>
                <td><span class="badge badge-safe">350</span></td>
                <td>50</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>BB002</td>
                <td>Plat Besi 2mm</td>
                <td>Lembar</td>
                <td><span class="badge badge-safe">200</span></td>
                <td>30</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>BB003</td>
                <td>Baut M10</td>
                <td>Pcs</td>
                <td><span class="badge badge-safe">1000</span></td>
                <td>100</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>4</td>
                <td>BB004</td>
                <td>Cat Hitam</td>
                <td>Liter</td>
                <td><span class="badge badge-low">50</span></td>
                <td>10</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>5</td>
                <td>BB005</td>
                <td>Amplas</td>
                <td>Lembar</td>
                <td><span class="badge badge-danger">120</span></td>
                <td>200</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- ===== PAGINATION ===== -->
<div class="pagination">
    <div class="page-item">‹</div>
    <div class="page-item active">1</div>
    <div class="page-item">2</div>
    <div class="page-item">3</div>
    <div class="page-item">›</div>
</div>

@endsection