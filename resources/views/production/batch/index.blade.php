@extends('production.layout.app')

@section('production-content')

<div class="page-header">

    <h2>Batch Produksi</h2>

    <a
        href="{{ route('batch-production.create') }}"
        class="btn-primary">

        + Batch Produksi

    </a>

</div>

<div class="card-production">

    <form method="GET">

        <div class="form-row">

            {{-- Search --}}

            <input
                type="text"
                name="search"
                class="input"
                placeholder="Cari Batch / Produk..."
                value="{{ request('search') }}">

            {{-- Status --}}

            <select
                name="status"
                class="input">

                <option value="">
                    Semua Status
                </option>

                <option
                    value="Draft"
                    {{ request('status')=='Draft' ? 'selected':'' }}>

                    Draft

                </option>

                <option
                    value="Cutting"
                    {{ request('status')=='Cutting' ? 'selected':'' }}>

                    Cutting

                </option>

                <option
                    value="Penjahitan"
                    {{ request('status')=='Penjahitan' ? 'selected':'' }}>

                    Penjahitan

                </option>

                <option
                    value="Assembling"
                    {{ request('status')=='Assembling' ? 'selected':'' }}>

                    Assembling

                </option>

                <option
                    value="Finishing"
                    {{ request('status')=='Finishing' ? 'selected':'' }}>

                    Finishing

                </option>

                <option
                    value="Selesai"
                    {{ request('status')=='Selesai' ? 'selected':'' }}>

                    Selesai

                </option>

            </select>

            <button class="btn-primary">

                Filter

            </button>

        </div>

    </form>

</div>

<div class="card-production">

<table class="table-production">

<thead>

<tr>

    <th>No</th>

    <th>Kode Batch</th>

    <th>Produk</th>

    <th>Qty Order</th>

    <th>Tanggal</th>

    <th>Status</th>

    <th width="220">

        Aksi

    </th>

</tr>

</thead>

<tbody>

@forelse($batchProductions as $index => $item)

<tr>

<td>

{{ $batchProductions->firstItem()+$index }}

</td>

<td>

<strong>

{{ $item->kode_batch }}

</strong>

</td>

<td>

{{ $item->produk->nama }}

</td>

<td>

{{ number_format($item->qty_order) }}

</td>

<td>

{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}

</td>

<td>

@if($item->status=='Draft')

<span class="badge badge-draft">

Draft

</span>

@elseif($item->status=='Cutting')

<span class="badge badge-cutting">

Cutting

</span>

@elseif($item->status=='Selesai')

<span class="badge badge-success">

Selesai

</span>

@else

<span class="badge badge-production">

{{ $item->status }}

</span>

@endif

</td>

<td>

<a

href="{{ route('batch-production.edit',$item->id) }}"

class="btn-warning">

Edit

</a>

@if($item->status=='Draft')

<a

href="#"

class="btn-success">

Mulai Cutting

</a>

@endif

</td>

</tr>

@empty

<tr>

<td colspan="7" align="center">

Belum ada Batch Produksi

</td>

</tr>

@endforelse

</tbody>

</table>

<div style="margin-top:20px;">

{{ $batchProductions->links() }}

</div>

</div>

@endsection