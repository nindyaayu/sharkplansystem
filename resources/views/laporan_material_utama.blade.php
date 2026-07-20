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

.top-box{
    background:#ffffff;
    border:1px solid #E5E7EB;
    border-radius:18px;
    padding:20px;
    margin-bottom:22px;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

.filter-box{
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
}

.input{
    background:#ffffff;
    color:#374151;
    border:1px solid #D1D5DB;
    padding:12px 15px;
    border-radius:12px;
    min-width:220px;
    transition:.25s;
}

.input:focus{
    outline:none;
    border-color:#6B8E6B;
    box-shadow:0 0 0 3px rgba(63,79,68,.18);
}

.btn{
    padding:12px 18px;
    border:none;
    border-radius:12px;
    font-weight:600;
    cursor:pointer;
    color:#fff;
    transition:.25s;
}

.btn:hover{
    transform:translateY(-2px);
}

.btn-primary{
    background:linear-gradient(135deg,#3F4F44,#556B5D);
}

.btn-primary:hover{
    background:linear-gradient(135deg,#556B5D,#3F4F44);
}

.btn-dark{
    background:#475569;
}

.btn-dark:hover{
    background:#334155;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:18px;
    margin-bottom:25px;
}

.stat-card{
    background:#ffffff;
    border:1px solid #E5E7EB;
    border-radius:18px;
    padding:22px;
    transition:.25s;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

.stat-card:hover{
    transform:translateY(-3px);
}

.stat-title{
    color:#6B7280;
    font-size:14px;
    margin-bottom:12px;
}

.stat-value{
    color:#3F4F44;
    font-size:42px;
    font-weight:700;
}

.table-box{
    background:#ffffff;
    border-radius:18px;
    overflow:hidden;
    border:1px solid #E5E7EB;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#F8FAFC;
}

thead th{
    padding:16px;
    color:#3F4F44;
    text-align:left;
    font-size:13px;
    font-weight:600;
    border-bottom:1px solid rgba(255,255,255,.05);
}

tbody td{
    padding:16px;
    border-top:1px solid #E5E7EB;
    color:#374151;
    transition:.2s;
}

tbody tr:hover{
    background:#F8FAFC;
}

.badge-stock{
    background:#EEF2FF;
    color:#4F46E5;
    padding:8px 14px;
    border-radius:10px;
    font-weight:600;
    min-width:75px;
    display:inline-block;
    text-align:center;
}

.badge-safe{
    background:rgba(34,197,94,.18);
    color:#4ADE80;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-warning{
    background:rgba(250,204,21,.18);
    color:#FACC15;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-danger{
    background:rgba(239,68,68,.18);
    color:#F87171;
    padding:7px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.filter-input{
    width:100%;
    padding:8px 10px;
    border-radius:8px;
    border:1px solid #D1D5DB;
    background:#ffffff;
    color:#374151;
    box-sizing:border-box;
    transition:.25s;
}

.filter-input:focus{
    outline:none;
    border-color:#6B8E6B;
    box-shadow:0 0 0 2px rgba(63,79,68,.18);
}

.filter-row th{
    padding:8px;
}

::placeholder{
    color:#94A3B8;
}

select{
    cursor:pointer;
}

</style>

<div class="page-title">

    Laporan Material Utama

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
        href="/laporan-material-utama"
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

            Total Kain

        </div>

        <div class="stat-value">

            {{ $data->count() }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Total Roll

        </div>

        <div class="stat-value">

            {{ number_format($data->sum('jumlah_roll')) }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Total Meter

        </div>

        <div class="stat-value">

            {{ number_format($data->sum('jumlah_meter')) }}

        </div>

    </div>

    <div class="stat-card">

        <div class="stat-title">

            Stok Habis

        </div>

        <div class="stat-value">

            {{ $data->where('jumlah_roll',0)->count() }}

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
    <th>Jumlah Roll</th>
    <th>Jumlah Meter</th>
    <th>Status</th>
</tr>

<tr class="filter-row">
    <th></th>

    <th>
        <input type="text"
       id="filterKode"
       class="filter-input"
       onkeyup="filterTable(1,this.value)"
       placeholder="Cari Kode">
    </th>

    <th>
        <input type="text"
       id="filterNama"
       class="filter-input"
       onkeyup="filterTable(2,this.value)"
       placeholder="Cari Nama">
    </th>

    <th>
        <input type="text"
       id="filterWarna"
       class="filter-input"
       onkeyup="filterTable(3,this.value)"
       placeholder="Cari Warna">
    </th>

    <th></th>
    <th></th>

    <th>
        <select id="filterStatus"
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

        {{ number_format($item->jumlah_roll) }} Roll

    </span>

</td>

<td>

    <span class="badge-stock">

        {{ number_format($item->jumlah_meter) }} Meter

    </span>

</td>

<td>

    @if($item->jumlah_roll == 0 && $item->jumlah_meter == 0)

        <span class="badge-danger">
            Habis
        </span>

    @elseif($item->jumlah_roll <= 5 || $item->jumlah_meter <= 500)

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
        document.getElementById("laporanTable");

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

    let status =
        document.getElementById('filterStatus').value;

    let tanggal =
        document.querySelector(
            'input[name="tanggal"]'
        ).value;

    window.location =
        '/laporan-material-utama-pdf'
        + '?tanggal=' + encodeURIComponent(tanggal)
        + '&kode=' + encodeURIComponent(kode)
        + '&nama=' + encodeURIComponent(nama)
        + '&warna=' + encodeURIComponent(warna)
        + '&status=' + encodeURIComponent(status);
}

</script>
@endsection