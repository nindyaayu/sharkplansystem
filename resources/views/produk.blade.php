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

/* SEARCH */
.search-box {
    background: rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.1);
    padding:8px 12px;
    border-radius:10px;
    color:white;
}

/* ===== TABLE BOX ===== */
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
    <h2>Produk</h2>

    <div class="admin">
        👤 Admin
    </div>
</div>

<!-- ===== ACTION ===== -->
<div class="action-bar">
    <button class="btn-primary">+ Tambah Produk</button>

    <input type="text" class="search-box" placeholder="Cari produk...">
</div>

<!-- ===== TABLE ===== -->
<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Produk</th>
                <th>Nama Produk</th>
                <th>Satuan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>P001</td>
                <td>Meja Produksi</td>
                <td>Unit</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>P002</td>
                <td>Rak Penyimpanan</td>
                <td>Unit</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>P003</td>
                <td>Gerobak Dorong</td>
                <td>Unit</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>4</td>
                <td>P004</td>
                <td>Rak Besi 4 Tingkat</td>
                <td>Unit</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>5</td>
                <td>P005</td>
                <td>Meja Kerja</td>
                <td>Unit</td>
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
    <div class="page-item">›</div>
</div>

@endsection