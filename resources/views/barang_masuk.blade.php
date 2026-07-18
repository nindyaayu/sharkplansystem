@extends('layout.app')

@section('content')

<style>

.btn-edit{
    background:#F59E0B;
    color:#FFFFFF;

    border:none;

    padding:8px 14px;

    border-radius:8px;

    cursor:pointer;

    font-weight:600;

    transition:.2s;
}

.btn-edit:hover{
    background:#D97706;
}

.btn-delete{
    background:#EF4444;
    color:#FFFFFF;

    border:none;

    padding:8px 14px;

    border-radius:8px;

    cursor:pointer;

    font-weight:600;

    transition:.2s;
}

.btn-delete:hover{
    background:#DC2626;
}

.action-group{
    display:flex;
    justify-content:center;
    align-items:center;
    gap:8px;
}

.action-group form{
    margin:0;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:20px 30px;
    margin-bottom:22px;

    background:linear-gradient(135deg,#3F4F44,#556B5D);
    border-radius:20px;
}

.page-header h2{
    margin:0;
    color:#FFFFFF;
    font-size:42px;
    font-weight:700;
}
.filter-bar{
    display:flex;
    gap:15px;
    align-items:end;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.input{
    background:#FFFFFF;
    color:#374151;

    border:1px solid #D1D5DB;

    padding:12px 14px;
    border-radius:10px;
}

.input:focus{
    outline:none;
    border-color:#3F4F44;
    box-shadow:0 0 0 3px rgba(63,79,68,.15);
}

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

.table-box{
    background:#FFFFFF;
    border:1px solid #E5E7EB;
    border-radius:16px;
    overflow:hidden;

    box-shadow:0 4px 12px rgba(0,0,0,.05);
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#F3F4F6;
}

thead th{
    padding:16px;
    text-align:center;

    background:#F3F4F6;
    color:#374151;

    font-weight:700;

    border-bottom:1px solid #E5E7EB;
}

tbody td{
    padding:16px;
    color:#374151;
    vertical-align:middle;
}

tbody tr{
    border-top:1px solid #E5E7EB;
}

tbody tr:hover{
    background:#F8FAFC;
}

.badge-in{
    background:#DCFCE7;
    color:#166534;

    padding:6px 10px;
    border-radius:8px;
}

.btn-secondary{
    background:#6B7280;
    color:#FFFFFF;

    border:none;

    padding:12px 18px;
    border-radius:10px;

    font-weight:600;
    cursor:pointer;

    transition:.2s;
}

.btn-secondary:hover{
    background:#4B5563;
}

.modal{
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content{
    background:#3F4F44;

    border-radius:18px;
    border:1px solid #556B5D;

    padding:28px;
    box-shadow:0 20px 45px rgba(0,0,0,.30);
}

.modal-content .input{
    width:100%;
    box-sizing:border-box;
}
.modal-content h3{
    color:white;
    margin-bottom:20px;
}

.form-group{
    margin-bottom:15px;
}

.form-group label{
    color:#FFFFFF;
    font-weight:600;
}

.form-actions{
    display:flex;
    justify-content:end;
    gap:10px;
    margin-top:20px;
}

.stat-value{
    color:#3F4F44 !important;
    font-size:42px;
    font-weight:700;
    line-height:1.2;

    background:transparent !important;
    padding:0;
    margin-top:8px;
}

</style>

<div class="page-header">

    <h2>Barang Masuk</h2>

</div>
<!-- FILTER -->

<div class="card filter-card">

    <form method="GET"
      style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">

    <input
        type="date"
        name="tanggal_awal"
        value="{{ request('tanggal_awal') }}"
        class="input">

    <span style="color:white;">
        s/d
    </span>

    <input
        type="date"
        name="tanggal_akhir"
        value="{{ request('tanggal_akhir') }}"
        class="input">

    <button
        type="submit"
        class="btn-primary">

        🔍 Tampilkan

    </button>

    <a
        href="{{ url()->current() }}"
        class="btn-secondary">

        ♻ Reset

    </a>

    <a
        href="{{ request()->is('barang-masuk-material-utama')
            ? route('barang-masuk-material-utama-pdf',[
                'tanggal_awal'=>request('tanggal_awal'),
                'tanggal_akhir'=>request('tanggal_akhir')
            ])
            : route('barang-masuk-material-pendukung-pdf',[
                'tanggal_awal'=>request('tanggal_awal'),
                'tanggal_akhir'=>request('tanggal_akhir')
            ]) }}"
        class="btn-secondary"
        style="text-decoration:none;">

        📄 Export PDF

    </a>

</form>

</div>

<!-- STATISTIK -->

<div class="stats-grid">

    <div class="card stat-card">

        <div class="stat-title">
            Total Transaksi
        </div>

        <div class="stat-value">
            {{ number_format($totalTransaksi) }}
        </div>

    </div>

    <div class="card stat-card">

        <div class="stat-title">
            Total Qty
        </div>

        <div class="stat-value">
            {{ number_format($totalQty) }}
        </div>

    </div>

    <div class="card stat-card">

        <div class="stat-title">
            Hari Ini
        </div>

        <div class="stat-value">
            {{ $hariIni }}
        </div>

    </div>

    <div class="card stat-card">

        <div class="stat-title">
            Bulan Ini
        </div>

        <div class="stat-value">
            {{ $bulanIni }}
        </div>

    </div>

</div>

<div class="filter-bar">

    <button
        type="button"
        class="btn-primary"
        onclick="document.getElementById('modalInput').style.display='flex'">

        + Input Barang

    </button>

</div>

<div class="table-box">

<table>

<thead>

<tr>

<th>No</th>
<th>Tanggal</th>
<th>Kode</th>
<th>Nama</th>
<th>Supplier</th>

@if(request()->is('barang-masuk-material-utama'))

    <th>Roll</th>
    <th>Meter</th>

@else

    <th>Jumlah</th>

@endif

<th>Satuan</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($barangMasuks as $index => $item)

<tr>

<td>{{ $index + 1 }}</td>

<td>
{{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
</td>

<td>{{ $item->barang->kode }}</td>

<td>{{ $item->barang->nama }}</td>

<td>{{ $item->supplier }}</td>

@if(request()->is('barang-masuk-material-utama'))

    <td>

        <span class="badge-in">

            {{ $item->jumlah_roll ?? 0 }} Roll

        </span>

    </td>

    <td>

        <span class="badge-in">

            {{ $item->jumlah }} Meter

        </span>

    </td>

@else

    <td>

        <span class="badge-in">

            {{ $item->jumlah }}

        </span>

    </td>

@endif

<td>{{ $item->barang->satuan }}</td>

<td>

    <div class="action-group">

        <button
            type="button"
            class="btn-edit"
            onclick="document.getElementById('editModal{{ $item->id }}').style.display='flex'">

            ✏️ Edit

        </button>

        <form
            action="{{ route('barang-masuk.destroy', $item->id) }}"
            method="POST"
            style="display:inline;">

            @csrf
            @method('DELETE')

            <button
                type="button"
                class="btn-delete"
                onclick="openDeleteModal({{ $item->id }})">

                🗑 Hapus

            </button>

        </form>

    </div>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

<!-- ================= MODAL EDIT ================= -->

@foreach($barangMasuks as $item)

<div id="editModal{{ $item->id }}" class="modal">

<div class="modal-content">

<h3>Edit Barang Masuk</h3>

<form
    action="{{ route('barang-masuk.update', $item->id) }}"
    method="POST">

@csrf
@method('PUT')

<div class="form-group">

<label>Barang</label>

<select
    name="barang_id"
    class="input"
    style="width:100%;">

    @foreach($barangs as $barang)

        <option
            value="{{ $barang->id }}"
            {{ $item->barang_id == $barang->id ? 'selected' : '' }}>

            {{ $barang->kode }}
            -
            {{ $barang->nama }}

        </option>

    @endforeach

</select>

</div>

<div class="form-group">

<label>Supplier</label>

<input
    type="text"
    name="supplier"
    value="{{ $item->supplier }}"
    class="input"
    style="width:100%;"
    required>

</div>

@if(request()->is('barang-masuk-material-utama'))

<div class="form-group">

<label>Jumlah Roll</label>

<input
    type="number"
    name="jumlah_roll"
    value="{{ $item->jumlah_roll ?? 0 }}"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-group">

<label>Jumlah Meter</label>

<input
    type="number"
    name="jumlah"
    value="{{ $item->jumlah }}"
    class="input"
    style="width:100%;"
    required>

</div>

@else

<div class="form-group">

<label>Jumlah</label>

<input
    type="number"
    name="jumlah"
    value="{{ $item->jumlah }}"
    class="input"
    style="width:100%;"
    required>

</div>

@endif

<div class="form-group">

<label>Tanggal Masuk</label>

<input
    type="date"
    name="tanggal_masuk"
    value="{{ $item->tanggal_masuk }}"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-actions">

<button
    type="button"
    class="btn-secondary"
    onclick="document.getElementById('editModal{{ $item->id }}').style.display='none'">

    Batal

</button>

<button type="submit" class="btn-primary">

    Update

</button>

</div>

</form>

</div>
</div>

@endforeach

<div id="deleteModal" class="modal">

    <div class="modal-content" style="max-width:420px;">

        <h3>Hapus Data</h3>

        <p style="color:white;line-height:1.7;">
            Apakah Anda yakin ingin menghapus data ini?
        </p>

        <div class="form-actions">

            <button
                type="button"
                class="btn-secondary"
                onclick="closeDeleteModal()">

                Batal

            </button>

            <form
                id="deleteForm"
                method="POST">

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    class="btn-primary">

                    Hapus

                </button>

            </form>

        </div>

    </div>

</div>

<!-- ================= MODAL INPUT ================= -->

<div id="modalInput" class="modal">

<div class="modal-content">

<h3>Input Barang Masuk</h3>

<form action="{{ route('barang-masuk.store') }}" method="POST">

@csrf

<div class="form-group">

<label>Barang</label>

<input
    type="text"
    name="barang_nama"
    id="barang_search_input"
    class="input"
    style="width:100%;"
    placeholder="Cari barang..."
    autocomplete="off"
    required>

<input
    type="hidden"
    name="barang_id"
    id="barang_id_input">

</div>

<div class="form-group">

<label>Supplier</label>

<input
    type="text"
    name="supplier"
    class="input"
    style="width:100%;"
    required>

</div>

@if(request()->is('barang-masuk-material-utama'))

<div class="form-group">

<label>Jumlah Roll</label>

<input
    type="number"
    name="jumlah_roll"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-group">

<label>Jumlah Meter</label>

<input
    type="number"
    name="jumlah"
    class="input"
    style="width:100%;"
    required>

</div>

@else

<div class="form-group">

<label>Jumlah</label>

<input
    type="number"
    name="jumlah"
    class="input"
    style="width:100%;"
    required>

</div>

@endif

<div class="form-group">

<label>Tanggal Masuk</label>

<input
    type="date"
    name="tanggal_masuk"
    value="{{ date('Y-m-d') }}"
    class="input"
    style="width:100%;"
    required>

</div>

<div class="form-actions">

<button
    type="button"
    class="btn-secondary"
    onclick="document.getElementById('modalInput').style.display='none'">

    Batal

</button>

<button type="submit" class="btn-primary">

    Simpan

</button>

</div>

</form>

</div>
</div>

<script>

document.addEventListener('DOMContentLoaded', function(){

        const searchInput =
            document.getElementById('barang_search_input');

        const barangId =
            document.getElementById('barang_id_input');

    if(!searchInput) return;

    const list =
        document.createElement('datalist');

    list.id = 'barang_list';

    document.body.appendChild(list);

    searchInput.setAttribute(
        'list',
        'barang_list'
    );

    searchInput.addEventListener(
        'input',
        async function(){

            let keyword = this.value;

            if(keyword.length < 1){

                list.innerHTML = '';
                return;

            }

            let response =
                await fetch(
                    '/search-barang?q=' +
                    encodeURIComponent(keyword)
                );

            let data =
                await response.json();

            list.innerHTML = '';

            data.forEach(item => {

                let option =
                    document.createElement(
                        'option'
                    );

                option.value =
                    item.text;

                option.dataset.id =
                    item.id;

                list.appendChild(
                    option
                );

            });

            this.onchange = function(){

                let selected =
                    data.find(
                        x => x.text === this.value
                    );

                if(selected){

                    barangId.value =
                        selected.id;

                }

            };

        }
    );

});

function openDeleteModal(id){

    document.getElementById('deleteForm').action =
        "{{ url('barang-masuk') }}/" + id;

    document.getElementById('deleteModal').style.display='flex';

}

function closeDeleteModal(){

    document.getElementById('deleteModal').style.display='none';

}

</script>

@endsection