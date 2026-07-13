@extends('production.layout.app')

@section('production-content')

<div class="page-header">

    <h2>Tambah Batch Produksi</h2>

    <a
        href="{{ route('batch-production.index') }}"
        class="btn-warning">

        ← Kembali

    </a>

</div>

@if ($errors->any())

<div class="alert-danger">

    <ul style="margin:0;padding-left:18px;">

        @foreach ($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </ul>

</div>

@endif

<div class="card-production">

<form
    action="{{ route('batch-production.store') }}"
    method="POST">

@csrf

<div class="form-row">

    {{-- Produk --}}

    <div>

        <label>Produk</label>

        <br>

        <select
            name="produk_id"
            class="input"
            required>

            <option value="">

                Pilih Produk

            </option>

            @foreach($produk as $item)

            <option
                value="{{ $item->id }}"
                {{ old('produk_id')==$item->id?'selected':'' }}>

                {{ $item->kode }}

                -

                {{ $item->nama }}

            </option>

            @endforeach

        </select>

    </div>

    {{-- Qty Order --}}

    <div>

        <label>Qty Order</label>

        <br>

        <input
            type="number"
            name="qty_order"
            class="input"
            value="{{ old('qty_order') }}"
            required>

    </div>

    {{-- Tanggal --}}

    <div>

        <label>Tanggal Produksi</label>

        <br>

        <input
            type="date"
            name="tanggal"
            class="input"
            value="{{ old('tanggal',date('Y-m-d')) }}"
            required>

    </div>

</div>

<br>

<div>

    <label>Keterangan</label>

    <br>

    <textarea
        name="keterangan"
        rows="4"
        class="input"
        style="width:100%;">

{{ old('keterangan') }}

</textarea>

</div>

<br>

<button
    type="submit"
    class="btn-primary">

    Simpan Batch Produksi

</button>

</form>

</div>

@endsection