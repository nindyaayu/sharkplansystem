@extends('layout.app')

@section('content')

<style>

.page-title{
    color:white;
    font-size:32px;
    font-weight:bold;
    margin-bottom:25px;
}

.top-bar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.btn{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    color:white;
    border:none;
    padding:12px 20px;
    border-radius:10px;
    cursor:pointer;
    font-weight:600;
}

.table-box{
    background:rgba(255,255,255,0.03);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:20px;
    overflow:hidden;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:rgba(255,255,255,0.04);
    color:#cbd5e1;
    padding:16px;
    text-align:left;
    font-size:14px;
}

td{
    padding:16px;
    border-top:1px solid rgba(255,255,255,0.05);
    color:white;
    font-size:14px;
}

.badge{
    padding:6px 10px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
    display:inline-block;
}

.badge-danger{
    background:rgba(239,68,68,0.2);
    color:#f87171;
}

.action{
    display:flex;
    gap:8px;
}

.btn-edit{
    background:#1e293b;
    color:#f97316;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
}

.btn-delete{
    background:#1e293b;
    color:#ef4444;
    border:none;
    padding:8px 12px;
    border-radius:8px;
    cursor:pointer;
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
    background:#0f172a;
    padding:30px;
    border-radius:20px;
    width:420px;
    border:1px solid rgba(255,255,255,0.08);
}

.modal-title{
    color:white;
    font-size:22px;
    font-weight:bold;
    margin-bottom:20px;
}

.input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.1);
    background:#111827;
    color:white;
}

.modal-footer{
    display:flex;
    justify-content:flex-end;
    gap:10px;
}

.btn-secondary{
    background:#1e293b;
    color:white;
    border:none;
    padding:10px 16px;
    border-radius:10px;
    cursor:pointer;
}

</style>

<div class="page-title">

    Barang Keluar

</div>

    <div class="top-bar">

        <button class="btn" onclick="openModal()">

            + Barang Keluar

        </button>

    </div>

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
            class="input"
            style="width:auto;"
        >

        <span style="color:white;">
            s/d
        </span>

        <input
            type="date"
            name="tanggal_akhir"
            value="{{ request('tanggal_akhir') }}"
            class="input"
            style="width:auto;"
        >

        <button
            type="submit"
            class="btn"
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

@if(session('success'))

    <script>

        alert("{{ session('success') }}")

    </script>

@endif

@if(session('error'))

    <script>

        alert("{{ session('error') }}")

    </script>

@endif

<div class="table-box">

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>Kode</th>
                <th>Nama</th>
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

                                ✏️

                            </button>

                            <form
                                action="/barang-keluar/{{ $item->id }}"
                                method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn-delete"
                                    onclick="return confirm('Hapus data?')">

                                    🗑️

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

            <select
                name="barang_id"
                class="input"
                required>

                <option value="">

                    Pilih Barang

                </option>

                @foreach($barangs as $barang)

                    <option value="{{ $barang->id }}">

                        {{ $barang->kode }} - {{ $barang->nama }}

                    </option>

                @endforeach

            </select>

            <input
                type="text"
                name="tujuan"
                class="input"
                placeholder="Tujuan"
                required>

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

                <button type="submit" class="btn">

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

                <button type="submit" class="btn">

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

@endsection