@extends('layout.app')

@section('content')

<style>

body{
    background:#F5F7F5;
    color:#374151;
}

.page-header{
    position: sticky;
    top: 15px;
    z-index: 999;

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:22px 30px;
    margin-bottom:20px;

    background:linear-gradient(135deg,#3F4F44,#556B5D);

    border-radius:20px;

    box-shadow:0 8px 20px rgba(0,0,0,.10);
}

.form-box{
    position:sticky;
    top:90px; /* sesuaikan tinggi header */
    z-index:999;

    background:#111827;
}

.page-header h2{
    color:white;
}

/* ================= FORM ================= */

.form-box{
    position:sticky;
    top:90px;
    z-index:998;

    background:white;
    backdrop-filter:blur(10px);

    border:1px solid #E5E7EB;
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
    background:white;
    color:#374151;
    border:1px solid #D1D5DB;
    padding:10px 12px;
    border-radius:10px;
    min-width:180px;
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

.action-btn{
    background:#3F4F44;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

.action-btn:hover{
    background:#556B5D;
}

.btn-delete{
    background:rgba(239,68,68,0.15);
    color:#ef4444;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

/* ================= TABLE ================= */

.table-box{
    background:white;
    border:1px solid #E5E7EB;
    border-radius:16px;
    backdrop-filter:blur(10px);
    overflow:hidden;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#F3F4F6;
}

thead th{
    padding:14px;
    text-align:left;
    font-size:13px;
    color:#94a3b8;
}

tbody td{
    padding:14px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr:hover{
    background:#F5F7F5;
}

.badge{
    background:#E8F5E9;
    color:#2E7D32;
    padding:5px 10px;
    border-radius:8px;
    font-size:13px;
}

.title-section{
    color:#2C3E33;
    font-size:18px;
    font-weight:700;
}

.component-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:20px;
    border-bottom:1px solid rgba(255,255,255,0.05);
}

.component-title{
    font-size:18px;
    color:#2C3E33;
    font-weight:600;
    margin-bottom:5px;
}

.component-subtitle{
    color:#6B7280;
}

.select2-container{
    min-width:335px !important;
}

.select2-container--default
.select2-selection--single{

    background:white !important;
    border:1px solid #D1D5DB !important;
    border-radius:10px !important;
    height:45px !important;

}

.select2-selection__rendered{

    color:#374151 !important;
    line-height:45px !important;

}

.select2-dropdown{

    background:white !important;
    border:1px solid #D1D5DB !important;

}

.select2-results__option{

    color:#374151 !important;

}

.select2-search__field{

    background:white !important;
    color:#374151 !important;

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
    padding:25px;
    border-radius:16px;
    width:400px;
    border:1px solid #E5E7EB;
}

.modal-title{
    font-size:18px;
    margin-bottom:20px;
    color:white;
}

.modal-actions{
    display:flex;
    justify-content:flex-end;
    gap:10px;
    margin-top:20px;
}


.page-header h2{
    margin:0;
    color:white;
    font-size:38px;
    font-weight:700;
}

.search-box{
    width:320px;
    padding:12px 18px;
    border-radius:12px;
    border:1px solid #D1D5DB;
    background:white;
    color:#374151;
    outline:none;
    font-size:14px;
}

.search-box input{
    width:320px;
    padding:12px 16px;
    border:none;
    background:transparent;
    color:white;
    outline:none;
}

.barang-search{
    background:white;
    border:1px solid #D1D5DB;
    color:#374151;
    width:280px;
    min-width:280px;
    padding:14px;
    border-radius:12px;
    outline:none;
}

.barang-search::placeholder{
    color:#94a3b8;
}

.barang-search:focus{
    border-color:#60a5fa;
    box-shadow:0 0 0 3px rgba(59,130,246,.15);
}

</style>

<!-- ================= HEADER ================= -->

<div class="page-header">

    <h2>Master BOM</h2>

<input
    type="text"
    id="searchBom"
    class="search-box"
    placeholder="🔍 Cari produk atau komponen..."
>

</div>

<!-- ================================================= -->
<!-- FORM TAMBAH KOMPONEN -->
<!-- ================================================= -->

<div class="form-box">

<div class="title-section">

    Tambah Komponen

</div>

<form action="{{ route('master-bom.store') }}" method="POST">

@csrf

<div class="form-row">

    <!-- PRODUK -->
    <select
        name="produk_id"
        id="produk_id"
        class="input"
        required>

        <option value="">
            Pilih Produk
        </option>

        @foreach($produk as $item)

        <option value="{{ $item->id }}">
            {{ $item->kode }} - {{ $item->nama }}
        </option>

        @endforeach

    </select>

    <!-- NAMA KOMPONEN -->
    <select
        name="nama_komponen"
        id="nama_komponen"
        class="input"
        required>

        <option value="">
        Pilih Komponen
        </option>

        </select>

    <!-- TANGGAL -->
    <input 
        type="date"
        name="tanggal"
        value="{{ date('Y-m-d') }}"
        class="input"
        required>

    <button 
        type="submit"
        class="btn-primary">

        + Buat Komponen

    </button>

</div>

</form>

</div>

<!-- ================================================= -->
<!-- LIST KOMPONEN -->
<!-- ================================================= -->

@foreach($bom as $item)

<div class="table-box bom-card">

<!-- ================= HEADER KOMPONEN ================= -->

<div class="component-header">

    <div>

        <div class="component-title">
            {{ $item->produk->nama }}
        </div>

        <div class="component-subtitle">
            Komponen:
            {{ $item->nama_komponen }}
        </div>

        <div
            style="
            margin-top:6px;
            font-size:13px;
            color:#94a3b8;
            ">

                Tanggal :
                {{ $item->created_at->format('d/m/Y') }}

            </div>
    </div>
    <!-- EDIT KOMPONEN -->
<div
style="
display:flex;
flex-direction:column;
gap:10px;
align-items:flex-end;
">

    <!-- DETAIL BAHAN -->
     <button
    type="button"
    class="action-btn"
    onclick="toggleBom({{ $item->id }})"
>
    👁 Detail
</button>

    <!-- EDIT KOMPONEN -->

    <button
    type="button"
    class="action-btn"

    onclick="openKomponenModal(

    '{{ $item->id }}',

    '{{ $item->nama_komponen }}'

    )">

    ✏️ Edit Komponen

    </button>

    <!-- HAPUS KOMPONEN -->
    <form 
        action="{{ route('master-bom.destroy', $item->id) }}"
        method="POST">

        @csrf
        @method('DELETE')

        <button 
            type="submit"
            class="btn-delete"
            onclick="return confirm('Hapus komponen ini?')">

            🗑 Hapus Komponen

        </button>

    </form>

</div>

</div>

<!-- ================= FORM TAMBAH BAHAN ================= -->

<div
    id="bom-detail-{{ $item->id }}"
    style="display:none;"
>

<div style="padding:20px;">

<form action="{{ route('bom-detail.store') }}" method="POST">

@csrf

<input 
    type="hidden"
    name="bom_id"
    value="{{ $item->id }}">

<div class="form-row">

    <!-- BAHAN -->
    <td>

<input
    type="text"
    class="barang-search"
    placeholder="Cari bahan..."
    autocomplete="off">

<input
    type="hidden"
    name="barang_id"
    class="barang-id">

</td>

    <!-- QTY -->
    <input 
        type="number"
        step="0.01"
        name="qty"
        class="input"
        placeholder="Qty per 1 pcs"
        required>

    <!-- SATUAN PAKAI -->
    <select 
        name="satuan_pakai"
        class="input"
        required>

        <option value="">
            Satuan Pakai
        </option>

        <option value="CM">
            CM
        </option>

        <option value="METER">
            METER
        </option>

        <option value="PCS">
            PCS
        </option>

        <option value="ROLL">
            ROLL
        </option>

    </select>

    <button 
        type="submit"
        class="btn-primary">

        + Tambah Bahan

    </button>

</div>

</form>

</div>

<!-- ================= TABLE DETAIL ================= -->

<table id="tabelBom">

<thead>

<tr>

<th>No</th>
<th>Kode</th>
<th>Nama Bahan</th>
<th>Satuan Gudang</th>
<th>Qty / pcs</th>
<th>Satuan Pakai</th>
<th>Aksi</th>

</tr>

</thead>

<tbody>

@forelse($item->details as $index => $detail)

<tr>

<td>

    {{ $index + 1 }}

</td>

<td>

    {{ $detail->barang->kode }}

</td>

<td>

    {{ $detail->barang->nama }}

</td>

<td>

    {{ $detail->barang->satuan }}

</td>

<td>

    {{ number_format($detail->qty,2) }}

</td>

<td>

    <span class="badge">

        {{ $detail->satuan_pakai }}

    </span>

</td>

<!-- ================= AKSI ================= -->

<td style="display:flex; gap:8px;">

    <!-- EDIT -->
    <button 
        type="button"
        class="action-btn"

        onclick="openEditModal(

            '{{ $detail->id }}',

            '{{ $detail->qty }}',

            '{{ $detail->satuan_pakai }}'

        )">

        ✏️

    </button>

    <!-- HAPUS -->
    <form 
        action="{{ route('bom-detail.destroy', $detail->id) }}"
        method="POST">

        @csrf
        @method('DELETE')

        <button 
            type="submit"
            class="action-btn"
            onclick="return confirm('Hapus bahan ini?')">

            🗑️

        </button>

    </form>

</td>

</tr>

@empty

<tr>

<td colspan="7" style="text-align:center;">

    Belum ada bahan

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

@endforeach
<!-- ================= MODAL EDIT KOMPONEN ================= -->

        <div class="modal" id="komponenModal">

        <div class="modal-content">

        <div class="modal-title">

            Edit Komponen

        </div>

        <form
        method="POST"
        id="komponenForm">

        @csrf
        @method('PUT')

        <input
        type="text"
        name="nama_komponen"
        id="editKomponen"
        class="input"
        placeholder="Nama Komponen"
        required>

        <div class="modal-actions">

        <button
        type="button"
        class="action-btn"
        onclick="closeKomponenModal()">

        Batal

        </button>

        <button
        type="submit"
        class="btn-primary">

        Update

        </button>

        </div>

        </form>

        </div>

</div>

<!-- ================= MODAL EDIT ================= -->

<div class="modal" id="editModal">

    <div class="modal-content">

        <div class="modal-title">

            Edit BOM Detail

        </div>

        <form 
            method="POST"
            id="editForm">

            @csrf
            @method('PUT')

            <!-- QTY -->
            <input 
                type="number"
                step="0.01"
                name="qty"
                id="editQty"
                class="input"
                placeholder="Qty"
                required>

            <br><br>

            <!-- SATUAN -->
            <select 
                name="satuan_pakai"
                id="editSatuan"
                class="input"
                required>

                <option value="CM">CM</option>

                <option value="METER">METER</option>

                <option value="PCS">PCS</option>

                <option value="ROLL">ROLL</option>

            </select>

            <div class="modal-actions">

                <button 
                    type="button"
                    class="action-btn"
                    onclick="closeEditModal()">

                    Batal

                </button>

                <button 
                    type="submit"
                    class="btn-primary">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

function openEditModal(id, qty, satuan){

    document
        .getElementById('editModal')
        .style.display = 'flex';

    document
        .getElementById('editQty')
        .value = qty;

    document
        .getElementById('editSatuan')
        .value = satuan;

    document
        .getElementById('editForm')
        .action = '/bom-detail/' + id;
}

function closeEditModal(){

    document
        .getElementById('editModal')
        .style.display = 'none';
}
function openKomponenModal(
id,
nama
){

    document
        .getElementById('komponenModal')
        .style.display = 'flex';

    document
        .getElementById('editKomponen')
        .value = nama;

    document
        .getElementById('komponenForm')
        .action = '/master-bom/' + id;

}

function closeKomponenModal(){

    document
        .getElementById('komponenModal')
        .style.display = 'none';

}

document
.getElementById('searchBom')
.addEventListener('keyup', function(){

    let keyword = this.value.toLowerCase();

    document
    .querySelectorAll('.table-box')
    .forEach(card => {

        let produk =
            card.querySelector('.component-title')
                .innerText
                .toLowerCase();

        let komponen =
            card.querySelector('.component-subtitle')
                .innerText
                .toLowerCase();

        if(
            produk.includes(keyword) ||
            komponen.includes(keyword)
        ){
            card.style.display = '';
        }else{
            card.style.display = 'none';
        }

    });

});

function toggleBom(id){

    localStorage.setItem(
        'openBom',
        id
    );

    const detail =
        document.getElementById(
            'bom-detail-' + id
        );

    if(detail.style.display === 'none'){

        detail.style.display = 'block';

    }else{

        detail.style.display = 'none';

        localStorage.removeItem(
            'openBom'
        );

    }

}

document
.getElementById('produk_id')
.addEventListener('change', function(){

    let produkId = this.value;

    fetch('/komponen-produk/' + produkId)

    .then(response => response.json())

    .then(data => {

        let komponen =
        document.getElementById(
            'nama_komponen'
        );

        komponen.innerHTML =
        '<option value="">Pilih Komponen</option>';

        data.forEach(item => {

            komponen.innerHTML += `
                <option value="${item.nama_komponen}">
                    ${item.nama_komponen}
                </option>
            `;

        });

    });

});

$(document).ready(function(){

    $('.select-bahan').select2({

        placeholder:'Pilih Bahan',
        width:'100%'

    });

});

$(document).on('input', '.barang-search', function(){

    let input = $(this);

    let keyword = input.val();

    if(keyword.length < 1){
        return;
    }

    $.get('/search-barang?q=' + keyword, function(data){

        let listId =
            'list-' +
            Math.random()
                .toString(36)
                .substring(2,8);

        let datalist =
            '<datalist id="' + listId + '">';

        data.forEach(function(item){

            datalist += `
                <option
                    value="${item.text}"
                    data-id="${item.id}">
                </option>
            `;

        });

        datalist += '</datalist>';

        $('datalist.temp-list').remove();

        $('body').append(
            $(datalist)
            .addClass('temp-list')
        );

        input.attr('list', listId);

        input.off('change').on('change', function(){

            let val = $(this).val();

            let barangId = '';

            data.forEach(function(item){

                if(item.text === val){

                    barangId = item.id;

                }

            });

            input
            .closest('form')
            .find('.barang-id')
            .val(barangId);

        });

    });

});

window.addEventListener(
'load',
function(){

    let openBom =
        localStorage.getItem(
            'openBom'
        );

    if(openBom){

        let detail =
            document.getElementById(
                'bom-detail-' + openBom
            );

        if(detail){

            detail.style.display =
                'block';

        }

    }

});

</script>
@endsection