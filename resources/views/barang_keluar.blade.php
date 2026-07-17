@extends('layout.app')

@section('content')

<style>
.filter-card input[type="date"]{
    width:130px;
    height:40px;
    padding:0 12px;
    border:1px solid #D1D5DB;
    border-radius:10px;
    box-sizing:border-box;
}

.btn-edit,
.btn-delete{

    min-width:90px;

}

.form-group{

    margin-bottom:16px;

}

.modal-content{

    width:650px;
    max-width:95%;
}

.filter-card{
    background:#fff;
    border:1px solid #E5E7EB;
    border-radius:20px;
    padding:20px;
    margin-bottom:24px;
    box-shadow:0 4px 12px rgba(0,0,0,.05);
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
    color:#fff;
    font-size:42px;
    font-weight:700;
}

.filter-bar{
    display:flex;
    align-items:center;
    margin-bottom:18px;
}

.btn-primary{
    background:#C62828;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    font-weight:600;
    cursor:pointer;
    transition:.2s;
}

.btn-primary:hover{
    background:#9F1D1D;
}

.btn-secondary{
    background:#6B7280;
    color:#fff;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
}

.btn-secondary:hover{
    background:#4B5563;
}

.table-box{
    background:#fff;
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
    color:#374151;
    font-weight:700;
    border-bottom:1px solid #E5E7EB;
}

tbody td{
    padding:16px;
    color:#374151;
    text-align:center;
}

tbody tr{
    border-top:1px solid #E5E7EB;
}

tbody tr:hover{
    background:#F8FAFC;
}

.badge{
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

.badge-danger{
    background:#FEE2E2;
    color:#DC2626;
    padding:6px 10px;
    border-radius:8px;
}

.action{
    display:flex;
    justify-content:center;
    gap:8px;
}

.btn-edit{
    background:#F59E0B;
    color:#fff;
    border:none;
    padding:8px 14px;
    border-radius:8px;
    font-weight:600;
}

.btn-edit:hover{
    background:#D97706;
}

.btn-delete{
    background:#EF4444;
    color:#fff;
    border:none;
    padding:8px 14px;
    border-radius:8px;
    font-weight:600;
}

.btn-delete:hover{
    background:#DC2626;
}

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,0.7);
    justify-content:center;
    align-items:center;
    z-index:999;
}

.modal-content{
    background:#3F4F44;
    border:1px solid #556B5D;
    border-radius:18px;
    padding:28px;
    box-shadow:0 20px 45px rgba(0,0,0,.30);
}

.modal-title{
    color:white;
    font-size:28px;
    font-weight:700;
}

.input{
    background:#fff;
    color:#374151;
    border:1px solid #D1D5DB;
    border-radius:10px;
}
.modal-content .input{

    width:100%;
    height:44px;
    margin-bottom:14px;
    padding:0 14px;
    border-radius:10px;
    border:1px solid #D1D5DB;
    box-sizing:border-box;

}

.input:focus{
    border-color:#3F4F44;
    box-shadow:0 0 0 3px rgba(63,79,68,.15);
}

.input,
select.input,
input.input{
    width:100%;
    box-sizing:border-box;
}

.modal-footer{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}


</style>

<div class="page-header">
    <h2>Barang Keluar</h2>
</div>

    <div class="filter-bar">

        <button class="btn-primary" onclick="openModal()">

            + Barang Keluar

        </button>

    </div>

    <div class="card filter-card">
        
    <form
        method="GET"
        style="
            display:flex;
            gap:10px;
            align-items:center;
            margin-bottom:20px;
            flex-wrap:wrap;
        "
    >

        <input
            type="date"
            name="tanggal_awal"
            value="{{ request('tanggal_awal') }}"
            class="input">

        <input
            type="date"
            name="tanggal_akhir"
            value="{{ request('tanggal_akhir') }}"
            class="input">

        <button
            type="submit"
            class="btn-primary"
        >
            🔍 Tampilkan
        </button>

        <a
            href="{{ url()->current() }}"
            class="btn-secondary"
            style="text-decoration:none;"
        >
            ♻ Reset
        </a>

        <a
            href="{{
                request()->is('barang-keluar-material-utama')
                ?
                route('barang-keluar-material-utama-pdf',[
                    'tanggal_awal'=>request('tanggal_awal'),
                    'tanggal_akhir'=>request('tanggal_akhir')
                ])
                :
                route('barang-keluar-material-pendukung-pdf',[
                    'tanggal_awal'=>request('tanggal_awal'),
                    'tanggal_akhir'=>request('tanggal_akhir')
                ])
            }}"
            class="btn-secondary"
            style="text-decoration:none;"
        >
            📄 Export PDF
        </a>

    </form>
    </div> 

<div class="table-box">

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Produk</th>
                <th>Tujuan</th>

                @if(request()->is('barang-keluar-material-utama'))

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

            @forelse($barangKeluars as $item)

                <tr>

                    <td>

                        {{ $loop->iteration }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}

                    </td>

                    <td>

                        {{ $item->barang->kode ?? '-' }}

                    </td>

                    <td>

                        {{ $item->barang->nama ?? '-' }}

                    </td>

                    <td>

                        {{ $item->produk->nama ?? '-' }}

                    </td>

                    <td>

                        {{ $item->tujuan }}

                    </td>

                    @if(request()->is('barang-keluar-material-utama'))

                        <td>

                            <span class="badge badge-danger">

                                {{ $item->jumlah_roll ?? 0 }} Roll

                            </span>

                        </td>

                        <td>

                            <span class="badge badge-danger">

                                {{ $item->jumlah ?? 0 }} Meter

                            </span>

                        </td>

                    @else

                        <td>

                            <span class="badge badge-danger">
                                @if($item->jumlah_roll > 0)

                                    {{ number_format($item->jumlah_roll,0) }}

                                @else

                                    {{ number_format($item->jumlah,0) }}

                                @endif
                            </span>

                        </td>

                    @endif

                    <td>

                        {{ $item->barang->satuan ?? '-' }}

                    </td>

                    <td>

                        <div class="action">

                            <button
                                class="btn-edit"
                                onclick="openEditModal(
                                    '{{ $item->id }}',
                                    '{{ $item->barang_id }}',
                                    '{{ $item->jumlah_roll ?? 0 }}',
                                    '{{ $item->jumlah }}',
                                    '{{ $item->tanggal_keluar }}',
                                    '{{ $item->tujuan }}'
                                )">

                                ✏️ Edit

                            </button>

                            <form
                                action="/barang-keluar/{{ $item->id }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn-delete"
                                    onclick="return confirm('Hapus data?')">

                                    🗑 Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="9" style="text-align:center;">

                        Tidak ada data

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

<!-- ================= MODAL TAMBAH ================= -->

<div class="modal" id="modalTambah">

    <div class="modal-content">

        <div class="modal-title">

            Tambah Barang Keluar

        </div>

        <form action="/barang-keluar" method="POST">

            @csrf

            <!-- <label>Barang</label> -->

                <input
                    type="text"
                    id="barang_search_keluar"
                    class="input"
                    placeholder="Cari barang..."
                    autocomplete="off"
                    required>

                <input
                    type="hidden"
                    name="barang_id"
                    id="barang_id_keluar">

            <select
                name="mode"
                class="input"
            >
                <option value="INTERNAL">
                    INTERNAL
                </option>

                <option value="EKSTERNAL">
                    EKSTERNAL
                </option>
            </select>

            <select
                name="produk_id"
                class="input"
            >
                <option value="">
                    Pilih Produk (Opsional)
                </option>

                @foreach($produks as $produk)

                    <option value="{{ $produk->id }}">
                        {{ $produk->nama }}
                    </option>

                @endforeach
            </select>

            <input
                type="text"
                name="nama_peminta"
                class="input"
                placeholder="Nama Peminta (OPSIONAL)"
            >

            <input
                type="text"
                name="nama_penjahit"
                class="input"
                placeholder="Nama Penjahit (OPSIONAL)"
            >

            @if(request()->is('barang-keluar-material-utama'))

                <input
                    type="number"
                    name="jumlah_roll"
                    class="input"
                    placeholder="Jumlah Roll"
                    required>

                <input
                    type="number"
                    name="jumlah"
                    class="input"
                    placeholder="Jumlah Meter"
                    required>

            @else

                <input
                    type="number"
                    name="jumlah"
                    class="input"
                    placeholder="Jumlah"
                    required>

            @endif

            <input
                type="date"
                name="tanggal_keluar"
                value="{{ date('Y-m-d') }}"
                class="input"
                required>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="closeModal()">

                    Batal

                </button>

                <button type="submit" class="btn-primary">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<!-- ================= MODAL EDIT ================= -->

<div class="modal" id="modalEdit">

    <div class="modal-content">

        <div class="modal-title">

            Edit Barang Keluar

        </div>

        <form id="formEdit" method="POST">

            @csrf
            @method('PUT')

            <select
                name="barang_id"
                id="edit_barang"
                class="input"
                required>

                @foreach($barangs as $barang)

                    <option value="{{ $barang->id }}">
                        {{ $barang->kode }} - {{ $barang->nama }}
                    </option>

                @endforeach

            </select>

            <input
                type="text"
                name="tujuan"
                id="edit_tujuan"
                class="input"
                required>

            @if(request()->is('barang-keluar-material-utama'))

                <input
                    type="number"
                    name="jumlah_roll"
                    id="edit_roll"
                    class="input"
                    placeholder="Jumlah Roll"
                    required>

                <input
                    type="number"
                    name="jumlah"
                    id="edit_jumlah"
                    class="input"
                    placeholder="Jumlah Meter"
                    required>

            @else

                <input
                    type="number"
                    name="jumlah"
                    id="edit_jumlah"
                    class="input"
                    placeholder="Jumlah"
                    required>

            @endif

            <input
                type="date"
                name="tanggal_keluar"
                id="edit_tanggal"
                class="input"
                required>

            <div class="modal-footer">

                <button
                    type="button"
                    class="btn-secondary"
                    onclick="closeEditModal()">

                    Batal

                </button>

                <button type="submit" class="btn-primary">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

<script>

function openModal(){

    document.getElementById('modalTambah')
        .style.display = 'flex';

}

function closeModal(){

    document.getElementById('modalTambah')
        .style.display = 'none';

}

function openEditModal(
    id,
    barang,
    roll,
    jumlah,
    tanggal,
    tujuan
){

    document.getElementById('modalEdit')
        .style.display = 'flex';

    document.getElementById('formEdit')
        .action = '/barang-keluar/' + id;

    document.getElementById('edit_barang')
        .value = barang;

    if(document.getElementById('edit_roll')){

        document.getElementById('edit_roll')
            .value = roll;

    }

    document.getElementById('edit_jumlah')
        .value = jumlah;

    document.getElementById('edit_tanggal')
        .value = tanggal;

    document.getElementById('edit_tujuan')
        .value = tujuan;

}

function closeEditModal(){

    document.getElementById('modalEdit')
        .style.display = 'none';

}

</script>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const searchInput =
        document.getElementById(
            'barang_search_keluar'
        );

    const barangId =
        document.getElementById(
            'barang_id_keluar'
        );

    if(!searchInput) return;

    const list =
        document.createElement('datalist');

    list.id = 'barang_list_keluar';

    document.body.appendChild(list);

    searchInput.setAttribute(
        'list',
        'barang_list_keluar'
    );

    searchInput.addEventListener(
        'input',
        async function(){

            let response =
                await fetch(
                    '/search-barang?q=' +
                    encodeURIComponent(this.value)
                );

            let data =
                await response.json();

            list.innerHTML = '';

            data.forEach(item => {

                let option =
                    document.createElement('option');

                option.value =
                    item.text;

                list.appendChild(option);

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

</script>

@endsection