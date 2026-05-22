@extends('layout.app')

@section('content')

<style>

.page-title{
    color:white;
    font-size:32px;
    font-weight:700;
    margin-bottom:25px;
}

.form-box{
    background:rgba(17,24,39,0.7);
    border:1px solid rgba(255,255,255,0.05);
    border-radius:18px;
    padding:20px;
    margin-bottom:20px;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:12px;
}

.input{
    background:#111827;
    border:1px solid rgba(255,255,255,0.08);
    padding:12px 14px;
    border-radius:12px;
    color:white;
    width:100%;
    box-sizing:border-box;
}

.btn{
    margin-top:15px;
    padding:12px 18px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-weight:600;
    color:white;
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
}

.table-box{
    background:rgba(17,24,39,0.7);
    border-radius:18px;
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
    padding:16px;
    color:#94a3b8;
    text-align:left;
    font-size:13px;
}

tbody td{
    padding:16px;
    border-top:1px solid rgba(255,255,255,0.05);
    color:#f8fafc;
}

.badge-pot{
    background:rgba(99,102,241,0.2);
    color:#c4b5fd;
    padding:7px 12px;
    border-radius:10px;
    display:inline-block;
    font-weight:600;
}

.empty{
    text-align:center;
    color:#94a3b8;
}

</style>

<div class="page-title">

    Hasil Cutting

</div>

<!-- FORM INPUT -->

<div class="form-box">

    <form action="/hasil-cutting/store" method="POST">

        @csrf

        <div class="form-grid">

            <input
                type="date"
                name="tanggal"
                class="input"
                required>

            <select
    name="produk"
    class="input"
    required>

    <option value="">
        Pilih Produk
    </option>

    @foreach($produk as $item)

        <option
    value="{{ $item->nama }}">

    {{ $item->kode }}
    -
    {{ $item->nama }}

</option>

    @endforeach

</select>

            <input
                type="text"
                name="komponen"
                class="input"
                placeholder="Komponen"
                required>

            <input
                type="number"
                name="hasil_pot"
                class="input"
                placeholder="Hasil Pot"
                required>

            <input
                type="text"
                name="keterangan"
                class="input"
                placeholder="Keterangan">

        </div>

        <button
            type="submit"
            class="btn">

            💾 Simpan Data

        </button>

    </form>

</div>

<!-- TABEL -->

<div class="table-box">

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Komponen</th>
                <th>Hasil Pot</th>
                <th>Keterangan</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($data as $item)

                <tr>

                    <td>{{ $loop->iteration }}</td>

                    <td>{{ $item->tanggal }}</td>

                    <td>{{ $item->produk }}</td>

                    <td>{{ $item->komponen }}</td>

                    <td>

                        <span class="badge-pot">

                            {{ number_format($item->hasil_pot) }}

                        </span>

                    </td>

                    <td>

                        {{ $item->keterangan ?? '-' }}

                    </td>
                    <td>

                    <button
    type="button"
    onclick="openEditModal(
        '{{ $item->id }}',
        '{{ $item->tanggal }}',
        '{{ $item->produk }}',
        '{{ $item->komponen }}',
        '{{ $item->hasil_pot }}',
        '{{ $item->keterangan }}'
    )"
    class="btn-edit">

    Edit

</button>

                    <a
                        href="/hasil-cutting/delete/{{ $item->id }}"
                        onclick="return confirm('Hapus data ini?')"
                        style="
                        background:#dc2626;
                        color:white;
                        padding:8px 12px;
                        border-radius:8px;
                        text-decoration:none;
                        ">

                        Hapus

                    </a>

                </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="empty">

                        Belum ada data hasil cutting

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>
<!-- MODAL EDIT -->

<div
    id="editModal"
    style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,.7);
    justify-content:center;
    align-items:center;
    z-index:9999;
">

    <div style="
    background:#111827;
    padding:25px;
    border-radius:15px;
    width:600px;
    max-width:95%;
    ">

        <h3 style="color:white;margin-bottom:20px;">
            Edit Hasil Cutting
        </h3>

        <form
            id="editForm"
            method="POST">

            @csrf

            <input
                type="date"
                name="tanggal"
                id="editTanggal"
                class="input"
                required>

            <br><br>

            <input
                type="text"
                name="produk"
                id="editProduk"
                class="input"
                required>

            <br><br>

            <input
                type="text"
                name="komponen"
                id="editKomponen"
                class="input"
                required>

            <br><br>

            <input
                type="number"
                name="hasil_pot"
                id="editHasilPot"
                class="input"
                required>

            <br><br>

            <input
                type="text"
                name="keterangan"
                id="editKeterangan"
                class="input">

            <br><br>

            <button
                type="submit"
                class="btn">

                Update

            </button>

            <button
                type="button"
                onclick="closeEditModal()"
                class="btn"
                style="background:#dc2626;">

                Batal

            </button>

        </form>

    </div>

</div>

<script>

function openEditModal(
    id,
    tanggal,
    produk,
    komponen,
    hasil_pot,
    keterangan
){

    document.getElementById('editModal')
        .style.display='flex';

    document.getElementById('editForm')
        .action='/hasil-cutting/update/'+id;

    document.getElementById('editTanggal')
        .value=tanggal;

    document.getElementById('editProduk')
        .value=produk;

    document.getElementById('editKomponen')
        .value=komponen;

    document.getElementById('editHasilPot')
        .value=hasil_pot;

    document.getElementById('editKeterangan')
        .value=keterangan;

}

function closeEditModal(){

    document.getElementById('editModal')
        .style.display='none';

}

</script>
@endsection