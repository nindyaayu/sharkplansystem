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
    margin-bottom:25px;
}

.page-header h2{
    color:white;
}

/* ================= FORM ================= */

.form-box{
    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:16px;
    padding:20px;
    margin-bottom:20px;
}

.form-row{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    align-items:center;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.1);
    padding:10px 12px;
    border-radius:10px;
    color:white;
    min-width:220px;
}

.modal-content .input{
    width:100%;
    min-width:100%;
    box-sizing:border-box;
}

.modal-content select{
    width:100%;
}

.modal-content input{
    width:100%;
}

select.input option{
    background:#111827;
}

/* ================= BUTTON ================= */

.btn-primary{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
    transition:0.3s;
}

.btn-primary:hover{
    box-shadow:0 0 12px rgba(99,102,241,0.6);
}

/* ================= TABLE ================= */

.table-box{
    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);
    border-radius:16px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:rgba(255,255,255,0.03);
}

thead th{
    padding:14px;
    text-align:left;
    color:#94a3b8;
    font-size:13px;
}

tbody td{
    padding:14px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover{
    background:rgba(99,102,241,0.05);
}

/* ================= BADGE ================= */

.badge{
    background:rgba(99,102,241,0.15);
    color:#a5b4fc;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.badge-success{
    background:rgba(34,197,94,0.2);
    color:#22c55e;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.badge-danger{
    background:rgba(239,68,68,0.2);
    color:#ef4444;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.badge-warning{
    background:rgba(250,204,21,0.2);
    color:#facc15;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

/* ================= MODAL ================= */

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.6);
    backdrop-filter:blur(5px);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content{
    background:#111827;
    padding:25px;
    border-radius:16px;
    width:400px;
    border:1px solid rgba(255,255,255,0.05);
}

.form-label{
    display:block;
    margin-bottom:10px;
    color:#e5e7eb;
    font-size:16px;
    font-weight:500;
}

.form-group{
    margin-bottom:24px;
}


</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>Perhitungan BOM</h2>

</div>

<!-- ================= FORM ================= -->

<div class="form-box">

<form method="GET" action="{{ route('perhitungan-bom') }}">

<div class="form-row">

    <!-- PRODUK -->
    <select
        name="produk_id"
        class="input"
        onchange="this.form.submit()"
        required>

        <option value="">
            Pilih Produk
        </option>

        @foreach($produk as $item)

        <option 
            value="{{ $item->id }}"
            {{ request('produk_id') == $item->id ? 'selected' : '' }}>

            {{ $item->kode }} - {{ $item->nama }}

        </option>

        @endforeach

    </select>

    <!-- MODE -->
    <select 
        name="mode"
        class="input"
        id="modeSelect"
        onchange="toggleKomponen()"
        required>

        <option 
            value="full"
            {{ request('mode') == 'full' ? 'selected' : '' }}>

            Full Sett

        </option>

        <option 
            value="komponen"
            {{ request('mode') == 'komponen' ? 'selected' : '' }}>

            Per Komponen

        </option>

    </select>

    <!-- KOMPONEN -->
    <select 
        name="komponen"
        id="komponenField"
        class="input">

        <option value="">
            Pilih Komponen
        </option>

        @foreach($bom as $data)

        <option 
            value="{{ $data->nama_komponen }}"
            {{ request('komponen') == $data->nama_komponen ? 'selected' : '' }}>

            {{ $data->nama_komponen }}

        </option>

        @endforeach

    </select>

    <!-- QTY -->
    <input 
        type="number"
        name="qty_produksi"
        class="input"
        placeholder="Qty Produksi"
        value="{{ request('qty_produksi') }}"
        required>

    <!-- BUTTON -->
    <button class="btn-primary">

        Hitung Kebutuhan

    </button>

</div>

</form>

</div>

@if(count($hasil) > 0)

<div style="margin-bottom:20px;">

    <button 
        class="btn-primary"
        onclick="openProduksiModal()">

        🏭 Proses Produksi

    </button>

    <button
        class="btn-primary"
        onclick="openJobOutModal()">

        📦 Surat Jalan

    </button>

</div>

@endif

<!-- ================= TABLE ================= -->

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>Komponen</th>
<th>Bahan</th>
<th>Qty / pcs</th>
<th>Satuan Pakai</th>
<th>Total CM</th>
<th>Total Meter</th>
<th>Isi / Roll</th>
<th>Kebutuhan Roll</th>
<th>Stok</th>
<th>Status</th>

</tr>

</thead>

<tbody>

@forelse($hasil as $index => $item)

<tr>

<td>{{ $index + 1 }}</td>

<td>{{ $item['komponen'] }}</td>

<td>{{ $item['bahan'] }}</td>

<td>{{ number_format($item['qty_per_pcs'],2) }}</td>

<td>

    <span class="badge">

        {{ $item['satuan_pakai'] }}

    </span>

</td>

<td>

    @if($item['total_cm'] > 0)

        <span class="badge">

            {{ number_format($item['total_cm'],2) }} cm

        </span>

    @else

        -

    @endif

</td>

<td>

    @if($item['total_meter'] > 0)

        <span class="badge">

            {{ number_format($item['total_meter'],2) }} m

        </span>

    @else

        -

    @endif

</td>

<td>

    @if($item['isi_per_satuan'])

        {{ number_format($item['isi_per_satuan'],2) }}
        {{ strtolower($item['satuan_konversi']) }}

    @else

        -

    @endif

</td>

<td>

    <span class="badge-warning">

        {{ number_format($item['roll_dibutuhkan'],2) }}
        {{ strtolower($item['satuan']) }}

    </span>

</td>

<td>

    {{ number_format($item['stok'],2) }}
    {{ strtolower($item['satuan']) }}

</td>

<td>

    @if($item['stok'] >= $item['roll_dibutuhkan'])

        <span class="badge-success">

            Aman

        </span>

    @else

        <span class="badge-danger">

            Kurang

        </span>

    @endif

</td>

</tr>

@empty

<tr>

<td colspan="11" style="text-align:center;">

    Belum ada perhitungan

</td>

</tr>

@endforelse

</tbody>

</table>

</div>


<!-- ================= MODAL PRODUKSI ================= -->

<div class="modal" id="modalProduksi">

    <div class="modal-content">

        <h3 style="
            margin-bottom:30px;
            font-size:18px;
            font-weight:700;
            color:white;
        ">

            Proses Produksi

        </h3>

        <form 
            action="{{ route('produksi.store') }}"
            method="POST">

            @csrf

            <!-- PRODUK -->
            <input 
                type="hidden"
                name="produk_id"
                value="{{ request('produk_id') }}">

            <!-- MODE PRODUKSI -->
            <input 
                type="hidden"
                name="mode_produksi"
                value="{{ request('mode') }}">

            <!-- NAMA KOMPONEN -->
            <input 
                type="hidden"
                name="nama_komponen"
                value="{{ request('komponen') }}">

            <!-- QTY -->
            <input 
                type="hidden"
                name="qty_produksi"
                value="{{ request('qty_produksi') }}">

            <!-- INFO -->
            <div 
                style="
                    background:rgba(99,102,241,0.1);
                    padding:12px;
                    border-radius:10px;
                    margin-bottom:28px;
                    font-size:14px;
                ">

                @if(request('mode') == 'komponen')

                    Produksi Komponen:
                    <b>{{ request('komponen') }}</b>

                @else

                    Produksi Full Set

                @endif

            </div>

            <!-- TANGGAL -->
            <div class="form-group">

            <label class="form-label">
                Tanggal
            </label>

            <input
                type="date"
                name="tanggal"
                class="input"
                required
                value="{{ date('Y-m-d') }}"
                style="width:100%;">

        </div>

            <!-- JENIS -->
            <div class="form-group">

            <label class="form-label">
                Jenis Produksi
            </label>

            <select
                name="jenis_produksi"
                class="input"
                required
                style="width:100%;">

                <option value="">
                    Pilih Jenis
                </option>

                <option value="Internal">
                    Internal
                </option>

                <option value="Job Out">
                    Job Out
                </option>

            </select>
            </div>

            <!-- PELAKSANA -->
            <div class="form-group">

            <label class="form-label">
                Pelaksana
            </label>

            <input
                type="text"
                name="pelaksana"
                class="input"
                placeholder="Penjahit / Vendor"
                required
                style="width:100%;">

        </div>

            <div 
                style="
                    display:flex;
                    justify-content:flex-end;
                    gap:10px;
                    margin-top:20px;
                ">

                <button 
                    type="button"
                    class="btn-primary"
                    onclick="closeProduksiModal()">

                    Batal

                </button>

                <button 
                    type="submit"
                    class="btn-primary">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

        </form>

    </div>

</div>
<!-- ================= MODAL JOB OUT ================= -->

<div class="modal" id="modalJobOut">

    <div class="modal-content">

        <h3 style="margin-bottom:20px;">

            Form Surat Jalan

        </h3>

        <form
            action="/job-out/generate-pdf"
            method="GET">

            <input
                type="hidden"
                name="produk_id"
                value="{{ request('produk_id') }}">

            <input
                type="hidden"
                name="qty_produksi"
                value="{{ request('qty_produksi') }}">

            <input
                type="hidden"
                name="mode"
                value="{{ request('mode') }}">

            <input
                type="hidden"
                name="komponen"
                value="{{ request('komponen') }}">

            <label>Kepada</label>

            <input
                type="text"
                name="kepada"
                class="input"
                placeholder="Nama Penerima"
                style="
                    width:100%;
                    margin-top:5px;
                    margin-bottom:15px;
                ">

            <label>Alamat</label>

            <textarea
                name="alamat"
                class="input"
                placeholder="Alamat Tujuan"
                style="
                    width:100%;
                    margin-top:5px;
                    margin-bottom:15px;
                    height:80px;
                "></textarea>

            <label>No. Pol Kendaraan</label>

            <input
                type="text"
                name="no_polisi"
                class="input"
                placeholder="N 1234 XX"
                style="
                    width:100%;
                    margin-top:5px;
                    margin-bottom:15px;
                ">

            <label>Dibuat Oleh</label>

            <input
                type="text"
                name="dibuat_oleh"
                class="input"
                placeholder="Nama Pembuat"
                style="
                    width:100%;
                    margin-top:5px;
                    margin-bottom:15px;
                ">

            <div
                style="
                    display:flex;
                    justify-content:flex-end;
                    gap:10px;
                ">

                <button
                    type="button"
                    class="btn-primary"
                    onclick="closeJobOutModal()">

                    Batal

                </button>

            <button
                type="submit"
                class="btn-primary"
                onclick="closeJobOutModal()">

                Generate Surat Jalan

            </button>

            </div>

        </form>

    </div>

</div>
<!-- ================= SCRIPT ================= -->

<script>

function toggleKomponen(){

    const mode =
        document.getElementById('modeSelect').value;

    const field =
        document.getElementById('komponenField');

    if(mode === 'komponen'){

        field.style.display = 'block';

    }else{

        field.style.display = 'none';
    }
}

// auto load
toggleKomponen();

function openProduksiModal(){

    document
        .getElementById('modalProduksi')
        .style.display = 'flex';
}

function closeProduksiModal(){

    document
        .getElementById('modalProduksi')
        .style.display = 'none';
}
function openJobOutModal(){

    document
        .getElementById('modalJobOut')
        .style.display = 'flex';
}

function closeJobOutModal(){

    document
        .getElementById('modalJobOut')
        .style.display = 'none';
}
</script>

@endsection