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

/* ===== FORM BOX ===== */
.form-box {
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin-bottom:20px;
}

/* INPUT & SELECT */
.input {
    background: #111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:white;
    min-width:200px;
}

/* FIX DROPDOWN */
select.input {
    appearance: none;
    background-image: url("data:image/svg+xml;utf8,<svg fill='white' height='20' viewBox='0 0 20 20' width='20'><path d='M5 7l5 5 5-5H5z'/></svg>");
    background-repeat: no-repeat;
    background-position: right 10px center;
    background-size: 16px;
}

select.input option {
    background: #111827;
    color: #ffffff;
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

/* TOTAL */
.total-box {
    margin-top:15px;
    text-align:right;
    color:#94a3b8;
    font-size:14px;
}

.total-box span {
    color:white;
    font-weight:600;
}

</style>

<!-- ===== HEADER ===== -->
<div class="page-header">
    <h2>BOM</h2>

    <div class="admin">
        👤 Admin
    </div>
</div>

<!-- ===== FORM ===== -->
<div class="form-box">
    <select class="input">
        <option>Pilih Produk</option>
        <option>P001 - Meja Produksi</option>
        <option>P002 - Rak Penyimpanan</option>
    </select>

    <input type="date" class="input">

    <button class="btn-primary">+ Tambah BOM</button>
</div>

<!-- ===== TABLE ===== -->
<div class="table-box">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Bahan</th>
                <th>Nama Bahan</th>
                <th>Satuan</th>
                <th>Jumlah</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>1</td>
                <td>BB001</td>
                <td>Besi Hollow 4x4</td>
                <td>Kg</td>
                <td>20</td>
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
                <td>4</td>
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
                <td>16</td>
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
                <td>1</td>
                <td>
                    <button class="action-btn">✏</button>
                    <button class="action-btn">🗑</button>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="total-box">
        Total Komponen: <span>4</span>
    </div>
</div>

@endsection