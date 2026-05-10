@extends('layout.app')

@section('content')

<style>

.page-title{
    color:white;
    font-size:28px;
    font-weight:700;
    margin-bottom:25px;
}

.form-box,
.table-box{
    background:rgba(17,24,39,0.7);
    border-radius:18px;
    padding:20px;
    border:1px solid rgba(255,255,255,0.05);
    margin-bottom:20px;
}

.form-row{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.08);
    padding:12px;
    border-radius:10px;
    color:white;
    min-width:220px;
}

.input option{
    background:#111827;
}

.btn-primary{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:12px 18px;
    border-radius:10px;
    color:white;
    cursor:pointer;
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
    color:#f1f5f9;
}

.badge{
    background:rgba(99,102,241,0.2);
    color:#c4b5fd;
    padding:6px 10px;
    border-radius:8px;
    font-size:13px;
}

.btn-pdf{
    background:rgba(239,68,68,0.15);
    color:#ef4444;
    padding:8px 12px;
    border-radius:8px;
    text-decoration:none;
}

</style>

<div class="page-title">

    Job Out

</div>

<!-- ========================= -->
<!-- FORM JOB OUT -->
<!-- ========================= -->

<div class="form-box">

<form
action="{{ route('job-out.store') }}"
method="POST">

@csrf

<div class="form-row">

<select
name="produk_id"
class="input"
required>

<option value="">
    Pilih Produk
</option>

@foreach($produk as $item)

<option value="{{ $item->id }}">

    {{ $item->kode }}
    -
    {{ $item->nama }}

</option>

@endforeach

</select>

<input
type="text"
name="vendor"
class="input"
placeholder="Vendor"
required>

<input
type="text"
name="ekspedisi"
class="input"
placeholder="Ekspedisi">

<input
type="date"
name="tanggal"
class="input"
value="{{ date('Y-m-d') }}"
required>

<input
type="text"
name="catatan"
class="input"
placeholder="Catatan">

<button
type="submit"
class="btn-primary">

    + Buat Surat Jalan

</button>

</div>

</form>

</div>

<!-- ========================= -->
<!-- TABLE -->
<!-- ========================= -->

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>No Surat</th>
<th>Tanggal</th>
<th>Produk</th>
<th>Vendor</th>
<th>Ekspedisi</th>
<th>Status</th>
<th>PDF</th>

</tr>

</thead>

<tbody>

@forelse($jobOut as $item)

<tr>

<td>

    {{ $loop->iteration }}

</td>

<td>

    {{ $item->no_surat }}

</td>

<td>

    {{ date('d/m/Y', strtotime($item->tanggal)) }}

</td>

<td>

    {{ $item->produk->nama }}

</td>

<td>

    {{ $item->vendor }}

</td>

<td>

    {{ $item->ekspedisi ?? '-' }}

</td>

<td>

    <span class="badge">

        {{ $item->status }}

    </span>

</td>

<td>

<a
href="{{ route('job-out.pdf', $item->id) }}"
class="btn-pdf">

    Download PDF

</a>

</td>

</tr>

@empty

<tr>

<td colspan="8" style="text-align:center;">

    Belum ada data Job Out

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

@endsection