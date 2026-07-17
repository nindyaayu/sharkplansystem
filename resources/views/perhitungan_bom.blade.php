@extends('layout.app')

@section('content')

<style>

body{
    background:#F5F7F5;
    color:#374151;
}

.page-header{
    position: sticky;
    top:15px;
    z-index:999;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:20px 30px;
    margin-bottom:22px;

    background:linear-gradient(135deg,#3F4F44,#556B5D);

    border-radius:20px;

    box-shadow:0 8px 20px rgba(0,0,0,.08);
}

.page-header h2{
    margin:0;
    color:white;
    font-size:44px;
    font-weight:700;
}

/* ================= FORM ================= */

.form-box{
    background:white;
    border:1px solid #E5E7EB;
    border-radius:18px;
    padding:22px;
    margin-bottom:20px;

    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

.form-row{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    align-items:center;
}

.input{
    background:white;
    color:#374151;

    border:1px solid #D1D5DB;

    padding:12px 14px;
    border-radius:10px;

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

.modal-content input,
.modal-content select,
.modal-content textarea{

    width:100%;
    padding:13px 16px;

    border:1px solid #D1D5DB;
    border-radius:12px;

    background:#FFFFFF;
    color:#374151;

    font-size:15px;
    box-sizing:border-box;
}

select.input option{
    background:white;
    color:#374151;
}

/* ================= BUTTON ================= */

.btn-primary{
    background:#C62828;
    color:white;
    border:none;

    padding:12px 18px;
    border-radius:10px;

    font-weight:600;
}

.btn-primary:hover{

    background:#9F1D1D;

}

/* ================= TABLE ================= */

.table-box{
    overflow-x:auto;
    border-radius:16px;
    border:1px solid #E5E7EB;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead th{
    padding:16px;
    text-align:center;
    background:#F3F4F6;
    color:#374151;
    font-weight:700;
    white-space:nowrap;
}

tbody td{
    padding:16px;
    text-align:center;
    vertical-align:middle;
    border-top:1px solid #E5E7EB;
    color:#374151;
    white-space:nowrap;
}

tbody tr:hover{
    background:#F8FAFC;
}
tbody td:nth-child(2),
tbody td:nth-child(3),
thead th:nth-child(2),
thead th:nth-child(3){
    text-align:left;
}

/* ================= BADGE ================= */

.badge{

    background:#EEF2FF;
    color:#4338CA;

}

.badge-success{

    background:#DCFCE7;
    color:#166534;

}

.badge-danger{

    background:#FEE2E2;
    color:#B91C1C;

}

.badge-warning{

    background:#FEF3C7;
    color:#92400E;

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
    background:#3F4F44;
    width:560px;
    max-width:90%;
    border-radius:18px;
    padding:32px;
    border:1px solid #556B5D;
    box-shadow:0 18px 45px rgba(0,0,0,.25);
}

.modal-content h2,
.modal-content h3{
    color:#FFFFFF;
    font-size:32px;
    font-weight:700;
    margin-bottom:28px;
}

.form-label{
    display:block;
    margin-bottom:8px;
    color:#F8FAFC;
    font-size:15px;
    font-weight:600;
    letter-spacing:.3px;
}

.form-group{
    margin-bottom:24px;
}

.form-group label{
    color:#FFFFFF !important;
    font-weight:600;
}

.info-produksi{
    background:#556B5D;
    color:#FFFFFF;
    padding:14px 18px;
    border-radius:12px;
    margin-bottom:24px;
    font-size:15px;
    font-weight:500;
}

.info-produksi strong{
    color:#FFD166;
    font-weight:700;
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

                <div class="info-produksi">

            @if(request('mode') == 'komponen')

                Produksi Komponen :
                <strong>{{ request('komponen') }}</strong>

            @else

                Produksi Full Set

            @endif

            </div>

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

            <label class="form-label">Kepada</label>

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

            <label class="form-label">Alamat</label>

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

            <label class="form-label">No. Pol Kendaraan</label>

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

            <label class="form-label">Dibuat Oleh</label>

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