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

/* ===== FILTER BAR ===== */
.filter-bar {
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    align-items:center;
    margin-bottom:15px;
}

/* INPUT */
.input {
    background: #111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:white;
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

/* ===== TABLE BOX ===== */
.table-box {
    background: rgba(17,24,39,0.7);
    backdrop-filter: blur(10px);
    border-radius:16px;
    padding:15px;
    border:1px solid rgba(255,255,255,0.05);
}

/* TABLE */
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

/* hover */
tbody tr:hover {
    background: rgba(99,102,241,0.05);
}

/* ACTION BUTTON */
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

/* BADGE */
.badge {
    padding:4px 10px;
    border-radius:8px;
    font-size:12px;
}

.badge-in {
    background: rgba(34,197,94,0.2);
    color:#22c55e;
}

/* PAGINATION */
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
    <h2>Barang Masuk</h2>

    <div class="admin">
        👤 Admin
    </div>
</div>

<!-- ===== FILTER ===== -->
<div class="filter-bar">
    <button class="btn-primary">+ Input Barang Masuk</button>

    <input type="date" class="input" value="2024-05-01">
    <input type="date" class="input" value="2024-05-31">
</div>

<!-- ===== TABLE ===== -->
<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Nama Bahan</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>22/05/2024</td>
                <td>BB001</td>
                <td>Besi Hollow 4x4</td>
                <td><span class="badge badge-in">100</span></td>
                <td>Kg</td>
                <td>Pembelian</td>
                <td>
                    <button class="action-btn">👁</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>21/05/2024</td>
                <td>BB003</td>
                <td>Baut M10</td>
                <td><span class="badge badge-in">500</span></td>
                <td>Pcs</td>
                <td>Pembelian</td>
                <td>
                    <button class="action-btn">👁</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>3</td>
                <td>20/05/2024</td>
                <td>BB002</td>
                <td>Plat Besi 2mm</td>
                <td><span class="badge badge-in">50</span></td>
                <td>Lembar</td>
                <td>Pembelian</td>
                <td>
                    <button class="action-btn">👁</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>

            <tr>
                <td>4</td>
                <td>20/05/2024</td>
                <td>BB004</td>
                <td>Cat Hitam</td>
                <td><span class="badge badge-in">10</span></td>
                <td>Liter</td>
                <td>Pembelian</td>
                <td>
                    <button class="action-btn">👁</button>
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