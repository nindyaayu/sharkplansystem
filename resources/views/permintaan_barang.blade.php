@extends('layout.app')

@section('content')

<div class="card" style="padding:24px">

<div style="
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
">

    <h2 style="color:white;margin:0;">
        📋 Permintaan Barang
    </h2>

    <button onclick="openModal()" style="
    background:#2563eb;
    color:white;
    border:none;
    padding:10px 18px;
    border-radius:8px;
    cursor:pointer;
">
    + Buat Permintaan
        </button>

</div>

<div style="overflow-x:auto;">

    <table style="
        width:100%;
        border-collapse:collapse;
        color:white;
    ">

        <thead>

            <tr style="background:#1e293b;">

                <th style="padding:12px;">No Permintaan</th>
                <th style="padding:12px;">Tanggal</th>
                <th style="padding:12px;">Produk</th>
                <th style="padding:12px;">Komponen</th>
                <th style="padding:12px;">Nama Peminta</th>
                <th style="padding:12px;">Nama Penjahit</th>
                <th style="padding:12px;">Jumlah Item</th>
                <th style="padding:12px;">Status</th>
                <th style="padding:12px;">Aksi</th>

            </tr>

        </thead>

        <tbody>

            @forelse($permintaan as $item)

            <tr>

                <td style="padding:12px;text-align:center;">
                    {{ $item->nomor_permintaan }}
                </td>

                <td style="padding:12px;text-align:center;">
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                </td>

                <td style="padding:12px;text-align:center;">
                    {{ $item->produk->nama ?? '-' }}
                </td>

                <td style="padding:12px;text-align:center;">
                    {{ $item->komponen->nama_komponen ?? '-' }}
                </td>

                <td style="padding:12px;text-align:center;">
                    {{ $item->nama_peminta }}
                </td>

                <td style="padding:12px;text-align:center;">
                    {{ $item->nama_penjahit }}
                </td>

                <td style="padding:12px;text-align:center;">
                    {{ $item->details->count() }} Barang
                </td>

                <td
                    id="status-permintaan-{{ $item->id }}"
                    style="padding:12px;text-align:center;"
                >

                    @if($item->status == 'Menunggu')

                    <span style="
                        background:#f59e0b;
                        color:white;
                        padding:5px 12px;
                        border-radius:20px;
                    ">
                        ⟳ Menunggu
                    </span>

                @elseif($item->status == 'Disetujui')

                    <span style="
                        background:#10b981;
                        color:white;
                        padding:5px 12px;
                        border-radius:20px;
                    ">
                        Disetujui
                    </span>

                @elseif($item->status == 'Disetujui Sebagian')

                    <span style="
                        background:#8b5cf6;
                        color:white;
                        padding:5px 12px;
                        border-radius:20px;
                    ">
                        ∞ Disetujui Sebagian
                    </span>

                @elseif($item->status == 'Ditolak')

                    <span style="
                        background:#ef4444;
                        color:white;
                        padding:5px 12px;
                        border-radius:20px;
                    ">
                        ✘ Ditolak
                    </span>

                @elseif($item->status == 'Kosong')

                    <span style="
                        background:#f59e0b;
                        color:white;
                        padding:5px 12px;
                        border-radius:20px;
                    ">
                        Kosong
                    </span>

                @elseif($item->status == 'Sudah Diambil')

                    <span style="
                        background:#3b82f6;
                        color:white;
                        padding:5px 12px;
                        border-radius:20px;
                    ">
                        ✓ Sudah Diambil
                    </span>

                @endif

                </td>

                <td
                        id="aksi-permintaan-{{ $item->id }}"
                        style="padding:12px;text-align:center;"
                    >

                    <button
                        onclick="lihatDetail({{ $item->id }})"
                        style="
                            background:#10b981;
                            color:white;
                            border:none;
                            padding:6px 12px;
                            border-radius:6px;
                            cursor:pointer;
                            margin-right:5px;
                        "
                    >
                       ✉ Detail
                    </button>

                    

                        @if(
                            $item->status == 'Disetujui' ||
                            $item->status == 'Disetujui Sebagian'
                        )

                            <form
                                action="{{ route('permintaan-barang.update',$item->id) }}"
                                method="POST"
                                style="display:inline;"
                            >
                                @csrf
                                @method('PUT')

                                <input
                                    type="hidden"
                                    name="status"
                                    value="Sudah Diambil"
                                >

                                <button
                                    type="submit"
                                    class="btn-sudah-diambil"
                                    onclick="setTimeout(() => location.reload(), 1000)"
                                >
                                    ✓ Sudah Diambil
                                </button>

                            </form>

                        @endif


                </td>


            </tr>

            @empty

                <tr>

                <td
                    colspan="7"
                    style="
                        text-align:center;
                        padding:30px;
                        color:#94a3b8;
                    "
                >
                    Belum ada permintaan barang
                </td>

                </tr>

            @endforelse

            </tbody>

    </table>

</div>

</div>

<!-- MODAL -->

<div id="modalPermintaan" class="modal">

    <div
            class="modal-content"
            style="
                max-height:90vh;
                overflow-y:auto;
            "
        >

        <div class="modal-header">

            <h2>📋 Buat Permintaan Barang</h2>

            <button
                type="button"
                class="close-btn"
                onclick="closeModal()"
            >
                ✕
            </button>

        </div>

        <form method="POST" action="{{ route('permintaan-barang.store') }}">

        @csrf

        <label>Produk</label>

            <select
                name="produk_id"
                id="produk_id"
                class="input-dark"
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

            <label>Mode Permintaan</label>

                <select
                    name="mode_permintaan"
                    id="modePermintaan"
                    class="input-dark"
                    onchange="toggleKomponenPermintaan()">

                    <option value="full">
                        Full Set
                    </option>

                    <option value="komponen">
                        Per Komponen
                    </option>

                </select>


                <div id="komponenWrapper">

                    <label>Komponen</label>

                    <select
                        name="komponen_produk_id"
                        id="komponen_id"
                        class="input-dark">

                        <option value="">
                            Pilih Komponen
                        </option>

                    </select>

                </div>

<label>Nama Peminta</label>

            <input
                type="text"
                name="nama_peminta"
                placeholder="Masukkan nama peminta"
                class="input-dark"
                required
             >

            <label>Nama Penjahit</label>

            <input
                type="text"
                name="nama_penjahit"
                placeholder="Masukkan nama penjahit"
                class="input-dark"
                required
            >

            <div style="
                display:flex;
                justify-content:space-between;
                align-items:center;
                margin-bottom:15px;
            ">

                <h3 class="section-title" style="margin:0;">
                    Daftar Barang
                </h3>
                <button
                type="button"
                onclick="tambahBaris()"
                class="btn-add"
            >
                + Tambah Barang
            </button>


            </div>

            <table
                class="table-dark"
                id="barangTable"
            >

                <thead>

                    <tr>

                        <th>Barang</th>
                        <th width="220">Jumlah</th>
                        <th width="120">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                </tbody>

            </table>

            <div
                class="footer-button"
                style="
                    position:sticky;
                    bottom:0;
                    background:#07153d;
                    padding:15px 0;
                    margin-top:20px;
                    z-index:10;
                "
            >

                <button
                    type="button"
                    onclick="closeModal()"
                    class="btn-batal"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="btn-simpan"
                >
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<style>

.select2-search--dropdown{
    display:block !important;
}

.select2-search__field{
    background:#08132f !important;
    color:white !important;
    border:1px solid #334155 !important;
}

.modal{
    display:none;
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.75);
    backdrop-filter:blur(6px);
    z-index:9999;

    overflow-y:auto;
}

.modal-content{
    width:900px;
    max-width:95%;

    max-height:95vh;

    overflow-y:auto;
    overflow-x:hidden;

    margin:10px auto;

    background:#08132f;
    border-radius:20px;
    padding:30px;

    color:white;
    border:1px solid rgba(255,255,255,.08);
}

#detailModal .modal-content{
        width:1000px;
        max-width:95%;
        max-height:85vh;
        overflow-y:auto;
    }

#barangTable{
    width:100%;
}

.select2-container{
    width:100% !important;
}

.select2-container--open{
    z-index:999999 !important;
}

.select2-dropdown{
    z-index:999999 !important;
}

/*
#barangTable tbody{
    display:block;
    max-height:350px;
    overflow-y:auto;
}

#barangTable thead,
#barangTable tbody tr{
    display:table;
    width:100%;
    table-layout:fixed;
}

#barangTable thead{
    width:calc(100% - 8px);
}
*/
.modal-header{
    position:sticky;
    top:-30px;

    display:flex;
    justify-content:space-between;
    align-items:center;

    background:#08132f;

    z-index:999;
    padding:15px 0;

    margin-bottom:25px;
}

.modal-header h2{
    margin:0;
    font-size:38px;
}

.close-btn{
    background:none;
    border:none;
    color:#94a3b8;
    font-size:32px;
    cursor:pointer;
}

label{
    display:block;
    margin-bottom:10px;
    font-weight:600;
}

.input-dark{
    width:100%;
    padding:16px;
    margin-bottom:25px;
    background:#0f1b3f;
    border:1px solid rgba(255,255,255,.08);
    border-radius:12px;
    color:white;
    box-sizing:border-box;
}

.input-dark::placeholder{
    color:#94a3b8;
}

.section-title{
    margin-bottom:20px;
}

.table-dark{
    width:100%;
    border-collapse:collapse;
    margin-bottom:20px;
}

.table-dark thead{
    background:#0d1b3c;
}

.table-dark th{
    padding:16px;
    text-align:left;
}

.table-dark td{
    padding:12px;
    border-top:1px solid rgba(255,255,255,.05);
}

.select-dark{
    width:100%;
    padding:14px;
    background:#0f1b3f;
    border:1px solid rgba(255,255,255,.08);
    border-radius:12px;
    color:white;
}

.qty-input{
    width:100%;
    padding:14px;
    background:#0f1b3f;
    border:1px solid rgba(255,255,255,.08);
    border-radius:12px;
    color:white;
    box-sizing:border-box;
}

.btn-add{
    background:transparent;
    color:#22c55e;
    border:1px solid #22c55e;
    padding:12px 20px;
    border-radius:12px;
    cursor:pointer;
}

.btn-hapus{
    background:#ef4444;
    color:white;
    border:none;
    padding:12px 18px;
    border-radius:10px;
    cursor:pointer;
}

.footer-button{
    position:sticky;
    bottom:0;

    display:flex;
    justify-content:flex-end;
    gap:12px;

    margin-top:20px;
    padding:15px;

    background:#08132f;

    border-top:1px solid rgba(255,255,255,.08);

    z-index:9999;
}

.btn-batal{
    background:#111827;
    color:white;
    border:none;
    padding:14px 25px;
    border-radius:12px;
    cursor:pointer;
}

.btn-simpan{
    background:#5b5bf7;
    color:white;
    border:none;
    padding:14px 25px;
    border-radius:12px;
    cursor:pointer;
}

.btn-sudah-diambil{
    background:#3b82f6;
    color:white;
    border:none;
    padding:6px 12px;
    border-radius:6px;
    cursor:pointer;
    font-weight:600;
    margin-left:5px;
}

.select2-container--default .select2-selection--single{
    background:#0f1b3f !important;
    border:1px solid rgba(255,255,255,.08) !important;
    border-radius:12px !important;
    height:50px !important;
}

.select2-container--default .select2-selection__rendered{
    color:white !important;
    line-height:48px !important;
}

.select2-dropdown{
    background:#0f1b3f !important;
    border:1px solid rgba(255,255,255,.08) !important;
}

.select2-results__option{
    color:white !important;
}

.select2-search__field{
    background:#08132f !important;
    color:white !important;
}

.barang-search{
    width:100%;
    padding:14px;
    background:#0f1b3f;
    border:1px solid rgba(255,255,255,.08);
    border-radius:12px;
    color:white;
    outline:none;
    box-sizing:border-box;
}

.barang-search::placeholder{
    color:#94a3b8;
}

.barang-search:focus{
    border-color:#3b82f6;
    box-shadow:0 0 0 3px rgba(59,130,246,.15);
}

@media (max-width:1024px){

    .modal-content{

        width:98%;
        max-height:98vh;

        padding:15px;
    }

    .modal-header h2{

        font-size:28px;
    }

    .table-dark{

        min-width:700px;
    }

    .footer-button{

        position:sticky;
        bottom:0;

        padding:15px;
        margin-top:20px;

        background:#08132f;
        z-index:999;
    }

    .btn-batal,
    .btn-simpan{

        padding:14px 20px;
    }

}
</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>

    const userRole = "{{ strtolower(auth()->user()->role) }}";

function openModal(){
    document.getElementById('modalPermintaan').style.display='block';

    if(
        document.querySelectorAll(
            '#barangTable tbody tr'
        ).length === 0
    ){
        tambahBaris();
    }
}

function closeModal(){
    document.getElementById('modalPermintaan').style.display='none';
}

function tambahBaris(){

        let tbody =
            document.querySelector(
                '#barangTable tbody'
            );

        let row = `
                    <tr>

                        <td>

                            <input
                                type="text"
                                name="barang_nama[]"
                                class="barang-search"
                                placeholder="🔍 Cari barang..."
                                autocomplete="off"
                                required
                            >

                            <input
                                type="hidden"
                                name="barang_id[]"
                                class="barang-id"
                            >

                        </td>

                        <td>

                            <input
                                type="number"
                                name="jumlah[]"
                                min="1"
                                placeholder="Masukkan jumlah"
                                class="qty-input"
                                required
                            >

                        </td>

                        <td>

                            <button
                                type="button"
                                class="btn-hapus"
                                onclick="this.closest('tr').remove()"
                            >
                                Hapus
                            </button>

                        </td>

                    </tr>
                    `;

        tbody.insertAdjacentHTML(
            'beforeend',
            row
        );

        }

        function lihatDetail(id)
            {

                fetch(
                    '/permintaan-barang/' +
                    id +
                    '?time=' +
                    Date.now()
                )

                .then(response => response.json())

            .then(data => {

                let badgeColor = '#f59e0b';

                    if(data.status == 'Disetujui'){
                        badgeColor = '#10b981';
                    }

                    if(data.status == 'Disetujui Sebagian'){
                        badgeColor = '#8b5cf6';
                    }

                    if(data.status == 'Ditolak'){
                        badgeColor = '#ef4444';
                    }

                    if(data.status == 'Sudah Diambil'){
                        badgeColor = '#3b82f6';
                    }

                let html = `

                <div style="
                    background:#0f1b3f;
                    border-radius:12px;
                    padding:20px;
                    margin-bottom:20px;
                ">

                    <div style="
                        display:grid;
                        grid-template-columns:180px 1fr;
                        row-gap:12px;
                    ">

                        <div style="color:#94a3b8;">No Permintaan</div>
                        <div>${data.nomor_permintaan}</div>

                        <div style="color:#94a3b8;">Peminta</div>
                        <div>${data.nama_peminta}</div>

                        <div style="color:#94a3b8;">Penjahit</div>
                        <div>${data.nama_penjahit}</div>

                        <div style="color:#94a3b8;">Status</div>

                        <div>
                            <span style="
                                background:${badgeColor};
                                color:white;
                                padding:6px 14px;
                                border-radius:20px;
                                font-size:13px;
                                font-weight:600;
                            ">
                                ${data.status}
                            </span>
                        </div>

                    </div>

                </div>

                <h3 style="
                    margin-bottom:15px;
                    color:white;
                ">
                    Daftar Barang
                </h3>

                <table style="
                    width:100%;
                    border-collapse:collapse;
                    color:white;
                    overflow:hidden;
                    border-radius:12px;
                ">

                    <thead>

                        <tr style="
                            background:#0f1b3f;
                        ">

                            <th style="padding:14px;">Kode</th>
                            <th style="padding:14px;">Nama Barang</th>
                            <th style="padding:14px;">Warna</th>
                            <th style="padding:14px;">Jumlah</th>
                            <th style="padding:14px;">Satuan</th>
                            <th style="padding:14px;">Status</th>
                            <th style="padding:14px;">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                `;

                data.details.forEach(item => {
                    if(!item.barang){
                        return;
                    }

                    html += `

                        <tr>

                            <td style="
                                padding:14px;
                                text-align:center;
                                border-bottom:1px solid rgba(255,255,255,.08);
                            ">
                                ${item.barang.kode}
                            </td>

                            <td style="
                                padding:14px;
                                border-bottom:1px solid rgba(255,255,255,.08);
                            ">
                                ${item.barang.nama}
                            </td>

                            <td style="
                                padding:14px;
                                text-align:center;
                                border-bottom:1px solid rgba(255,255,255,.08);
                            ">
                                ${item.barang.warna}
                            </td>

                            <td style="
                                padding:14px;
                                text-align:center;
                                border-bottom:1px solid rgba(255,255,255,.08);
                            ">
                                ${item.jumlah}
                            </td>

                            <td style="
                                padding:14px;
                                text-align:center;
                                border-bottom:1px solid rgba(255,255,255,.08);
                            ">
                                ${item.barang.satuan}
                            </td>

                            <td style="
                                padding:14px;
                                text-align:center;
                                border-bottom:1px solid rgba(255,255,255,.08);
                            ">

                                ${
                                    item.status == 'ACC'
                                    ? '<span style="background:#22c55e;color:white;padding:5px 10px;border-radius:20px;">ACC</span>'

                                    : item.status == 'Kosong'
                                    ? '<span style="background:#f59e0b;color:white;padding:5px 10px;border-radius:20px;">Kosong</span>'

                                    : item.status == 'Ditolak'
                                    ? '<span style="background:#ef4444;color:white;padding:5px 10px;border-radius:20px;">Ditolak</span>'

                                    : '<span style="background:#64748b;color:white;padding:5px 10px;border-radius:20px;">Menunggu</span>'
                                }

                            </td>


                            <td style="
                                padding:14px;
                                text-align:center;
                                border-bottom:1px solid rgba(255,255,255,.08);
                            ">

                                ${
    item.status == 'Menunggu'
    ? (
        userRole == 'admin' || userRole == 'gudang'
    )
        ? `
            <button
                onclick="updateDetailStatus(${item.id},'ACC')"
                style="
                    background:#22c55e;
                    color:white;
                    border:none;
                    padding:5px 10px;
                    border-radius:8px;
                    cursor:pointer;
                ">
                ACC
            </button>

            <button
                onclick="updateDetailStatus(${item.id},'Kosong')"
                style="
                    background:#f59e0b;
                    color:white;
                    border:none;
                    padding:5px 10px;
                    border-radius:8px;
                    cursor:pointer;
                ">
                Kosong
            </button>

            <button
                onclick="updateDetailStatus(${item.id},'Ditolak')"
                style="
                    background:#ef4444;
                    color:white;
                    border:none;
                    padding:5px 10px;
                    border-radius:8px;
                    cursor:pointer;
                ">
                Tolak
            </button>
        `
        : '<span style="color:#94a3b8;">Menunggu Persetujuan</span>'
    : '<span style="color:#94a3b8;">Selesai</span>'
}

                            </td>

                            </tr>

                    `;
                });

                    html += `

                        </tbody>

                    </table>

                    <div style="
                        display:flex;
                        justify-content:flex-end;
                        margin-top:25px;
                    ">

                        <button
                            onclick="closeDetailModal()"
                            style="
                                background:#374151;
                                color:white;
                                border:none;
                                padding:10px 20px;
                                border-radius:8px;
                                cursor:pointer;
                            "
                        >
                            Tutup
                        </button>

                    </div>

                    `;

                    document.getElementById(
                        'detailContent'
                    ).innerHTML = html;

                    document.getElementById(
                        'detailModal'
                    ).style.display = 'block';

                });

                }

                function closeDetailModal(){

                    document.getElementById(
                        'detailContent'
                    ).innerHTML = '';

                    document.getElementById(
                        'detailModal'
                    ).style.display = 'none';

                }


                function updateDetailStatus(id,status){
                    fetch('/permintaan-barang-detail/' + id, {

                        method:'PUT',

                        headers:{
                            'Content-Type':'application/json',
                            'X-CSRF-TOKEN':
                                document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content
                        },

                        body:JSON.stringify({
                            status:status
                        })

                    })

                    .then(res => {

                        console.log(res);

                        return res.json();

                    })

                    .then(data => {

                        console.log('DATA RESPONSE = ', data);

                        if(data.permintaan_id){

                            setTimeout(() => {

                                lihatDetail(data.permintaan_id);

                            }, 300);

                        }
                        let badge = '';

    if(data.status == 'Disetujui'){
        badge = `
            <span style="
                background:#10b981;
                color:white;
                padding:5px 12px;
                border-radius:20px;
            ">
                Disetujui
            </span>
        `;
    }
    else if(data.status == 'Disetujui Sebagian'){
        badge = `
            <span style="
                background:#8b5cf6;
                color:white;
                padding:5px 12px;
                border-radius:20px;
            ">
                Disetujui Sebagian
            </span>
        `;
    }
    else if(data.status == 'Kosong'){
        badge = `
            <span style="
                background:#f59e0b;
                color:white;
                padding:5px 12px;
                border-radius:20px;
            ">
                Kosong
            </span>
        `;
    }
    else if(data.status == 'Ditolak'){
        badge = `
            <span style="
                background:#ef4444;
                color:white;
                padding:5px 12px;
                border-radius:20px;
            ">
                Ditolak
            </span>
        `;
    }

    const statusCell =
        document.getElementById(
            'status-permintaan-' +
            data.permintaan_id
        );

    if(statusCell){
        statusCell.innerHTML = badge;
    }

    if(
    data.status === 'Disetujui' ||
    data.status === 'Disetujui Sebagian'
){
    window.location.reload();
}

})

                    .catch(error => {

                        alert(error);

                        console.log(error);

                    });

                }

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

                            $(input)
                                .closest('td')
                                .find('.barang-id')
                                .val(barangId);

                        });

                    });

                });

                document
.getElementById('produk_id')
.addEventListener(
'change',
function(){

    let produkId =
        this.value;

    fetch(
        '/komponen-produk/' +
        produkId
    )

    .then(response => response.json())

    .then(data => {

        let komponen =
            document.getElementById(
                'komponen_id'
            );

        komponen.innerHTML =
            '<option value="">Pilih Komponen</option>';

        data.forEach(item => {

            komponen.innerHTML += `
                <option value="${item.id}">
                    ${item.nama_komponen}
                </option>
            `;

        });

    });

});

function toggleKomponenPermintaan(){

    let mode =
        document.getElementById(
            'modePermintaan'
        ).value;

    let wrapper =
        document.getElementById(
            'komponenWrapper'
        );

    if(mode === 'full'){

        wrapper.style.display = 'none';

    }else{

        wrapper.style.display = 'block';

    }

}

toggleKomponenPermintaan();

</script>


        <div id="detailModal" class="modal">

        <div class="modal-content">

            <div class="modal-header">

                <h2>📋 Detail Permintaan Barang</h2>

                <button
                    class="close-btn"
                    onclick="closeDetailModal()"
                >
                    ✕
                </button>

            </div>
            <div id="detailContent">

            </div>

        </div>
        </div>

@endsection
