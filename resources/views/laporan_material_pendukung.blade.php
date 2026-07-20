@extends('layout.app')

@section('content')

<style>

.page-title{
    margin:0;
    color:#3F4F44;   
    font-size:52px;
    font-weight:700;
    line-height:1.2;
    text-shadow:0 2px 8px rgba(0,0,0,.15);
}

.page-title h1{
    margin:0;
    color:#FFFFFF;
    font-size:52px;
    font-weight:700;
}

.page-title p{
    margin-top:15px;
    color:rgba(255,255,255,.85);
    font-size:17px;
}

.top-box{
    background:linear-gradient(135deg,#3F4F44,#556B5D);
    box-shadow:0 8px 20px rgba(0,0,0,.10);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:18px;
    padding:20px;
    margin-bottom:20px;
}

.filter-box{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
}

.input{
    background:#FFFFFF;
    border:1px solid #D1D5DB;
    color:#374151;
    padding:12px 14px;
    border-radius:12px;
    min-width:220px;
}

.btn{
    padding:12px 18px;
    border:none;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
    color:white;
}

.btn-primary{
    background:#3F4F44;
}

.btn-primary:hover{
    background:#556B5D;
}

.btn-dark{
    background:#6B7280;
}

.btn-dark:hover{
    background:#4B5563;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:16px;
    margin-bottom:25px;
}

.stat-card{
    background:#fff;
    border:1px solid #E5E7EB;
    border-radius:18px;
    padding:22px;
}

.stat-title{
    color:#6B7280;
    font-size:14px;
    margin-bottom:10px;
}

.stat-value{
    color:#3F4F44;
    font-size:40px;
    font-weight:700;
}

.table-box{
    background:#fff;
    border-radius:18px;
    overflow:hidden;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#3F4F44;
}

thead th{
    padding:16px;
    color:#fff;
    text-align:left;
    font-size:13px;
}

tbody td{
    padding:16px;
    color:#374151;
    border-top:1px solid #E5E7EB;
}

.badge-stock{
    background:#EEF2FF;
    color:#4F46E5;
    padding:7px 12px;
    border-radius:10px;
    display:inline-block;
    font-weight:600;
}

.badge-safe{
    background:#DCFCE7;
    color:#166534;
    padding:6px 12px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
}

.badge-warning{
    background:#FEF3C7;
    color:#B45309;
    padding:6px 12px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
}

.badge-danger{
    background:#FEE2E2;
    color:#B91C1C;
    padding:6px 12px;
    border-radius:10px;
    font-size:12px;
    font-weight:600;
}
.filter-input{
    width:100%;
    padding:6px;
    border-radius:6px;
    border:1px solid #D1D5DB;
    background:#FFFFFF;
    color:#374151;
    box-sizing:border-box;
}

.filter-row th{
    padding:8px;
}
</style>

<div class="page-title">
    <div class="title">Laporan Material Pendukung</div>
</div>

<!-- FILTER -->

<div class="top-box">

    <form method="GET">

        <div class="filter-box">

    <input
        type="date"
        name="tanggal"
        value="{{ request('tanggal') }}"
        class="input">

    <button
        type="submit"
        class="btn btn-primary">

        🔍 Tampilkan

    </button>

    <a
        href="/laporan-material-pendukung"
        class="btn btn-dark"
        style="text-decoration:none; display:flex; align-items:center;">

        ♻ Reset

    </a>

    <button
    type="button"
    onclick="exportPdfFilter()"
    class="btn btn-dark">

    📄 Export PDF

</button>

</div>

    </form>

</div>

<!-- STATISTIK -->

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-title">

            Total Barang

        </div>

        <div class="stat-value">

            {{ $data->count() }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Total Stok

        </div>

        <div class="stat-value">

            {{ number_format($data->sum('stok')) }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Stok Aman

        </div>

        <div class="stat-value">

            {{ $data->where('stok','>',50)->count() }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Stok Habis

        </div>

        <div class="stat-value">

            {{ $data->where('stok',0)->count() }}

        </div>

    </div>

</div>

<!-- TABEL -->

<div class="table-box">

<table id="laporanTable">

<thead>

<tr>
    <th>No</th>
    <th>Kode</th>
    <th>Nama Barang</th>
    <th>Warna</th>
    <th>Stok</th>
    <th>Satuan</th>
    <th>Status</th>
</tr>

<tr class="filter-row">

    <th></th>

    <th>
    <input
        id="filterKode"
        type="text"
        class="filter-input"
        onkeyup="filterTable(1,this.value)"
        placeholder="Cari Kode">
</th>

    <th>
    <input
        id="filterNama"
        type="text"
        class="filter-input"
        onkeyup="filterTable(2,this.value)"
        placeholder="Cari Nama">
</th>

    <th>
    <input
        id="filterWarna"
        type="text"
        class="filter-input"
        onkeyup="filterTable(3,this.value)"
        placeholder="Cari Warna">
</th>

    <th></th>

    <th>
    <input
        id="filterSatuan"
        type="text"
        class="filter-input"
        onkeyup="filterTable(5,this.value)"
        placeholder="Cari Satuan">
</th>

    <th>
        <select
    id="filterStatus"
    class="filter-input"
    onchange="filterTable(6,this.value)">

            <option value="">Semua</option>
            <option value="Aman">Aman</option>
            <option value="Menipis">Menipis</option>
            <option value="Habis">Habis</option>

        </select>
    </th>

</tr>

</thead>

<tbody>

@forelse($data as $item)

<tr>

<td>{{ $loop->iteration }}</td>

<td>{{ $item->kode }}</td>

<td>{{ $item->nama }}</td>

<td>{{ $item->warna ?? '-' }}</td>

<td>

    <span class="badge-stock">

        {{ number_format($item->stok) }}

    </span>

</td>

<td>{{ $item->satuan }}</td>

<td>

    @if($item->stok == 0)

        <span class="badge-danger">

            Habis

        </span>

    @elseif($item->stok <= 50)

        <span class="badge-warning">

            Menipis

        </span>

    @else

        <span class="badge-safe">

            Aman

        </span>

    @endif

</td>

</tr>

@empty

<tr>

<td colspan="7" style="text-align:center;">

    Tidak ada data

</td>

</tr>

@endforelse

</tbody>

</table>

</div>
<script>

function filterTable(columnIndex, value){

    value = value.toUpperCase();

    const table =
        document.querySelector("table");

    const rows =
        table.getElementsByTagName("tr");

    for(let i=2;i<rows.length;i++){

        let show = true;

        const filters =
            document.querySelectorAll(
                '.filter-row input, .filter-row select'
            );

        filters.forEach(function(filter){

            const col =
                filter.parentElement.cellIndex;

            const cell =
                rows[i].cells[col];

            if(cell){

                const text =
                    cell.innerText.toUpperCase();

                if(
                    filter.value &&
                    !text.includes(
                        filter.value.toUpperCase()
                    )
                ){
                    show = false;
                }
            }

        });

        rows[i].style.display =
            show ? '' : 'none';
    }
}

</script>
<script>

function exportPdfFilter(){

    let kode =
        document.getElementById('filterKode').value;

    let nama =
        document.getElementById('filterNama').value;

    let warna =
        document.getElementById('filterWarna').value;

    let satuan =
        document.getElementById('filterSatuan').value;

    let status =
        document.getElementById('filterStatus').value;

    let tanggal =
        document.querySelector(
            'input[name="tanggal"]'
        ).value;

    window.location =
        '/laporan-material-pendukung-pdf'
        + '?tanggal=' + encodeURIComponent(tanggal)
        + '&kode=' + encodeURIComponent(kode)
        + '&nama=' + encodeURIComponent(nama)
        + '&warna=' + encodeURIComponent(warna)
        + '&satuan=' + encodeURIComponent(satuan)
        + '&status=' + encodeURIComponent(status);
}

</script>
@endsection