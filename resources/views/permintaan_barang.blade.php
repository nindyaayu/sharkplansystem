@extends('layout.app')

@section('content')

<div class="card" style="padding:24px">

```
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

                <td style="padding:12px;text-align:center;">

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

                    

                        @if($item->status == 'Disetujui')

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

    height:auto;
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

.modal-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
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

                    <select
                        name="barang_id[]"
                        class="select-dark"
                        required
                    >

                        @foreach($barang as $item)

                            <option value="{{ $item->id }}">

                                {{ $item->kode }}
                                |
                                {{ $item->nama }}
                                |
                                {{ $item->warna }}

                            </option>

                        @endforeach

                    </select>

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
            fetch('/permintaan-barang/' + id)

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

                function closeDetailModal()
                {
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
                                document
                                .querySelector(
                                    'meta[name="csrf-token"]'
                                )
                                .content
                        },

                        body:JSON.stringify({
                            status:status
                        })

                    })
                    .then(res => res.json())
                    .then(data => {

                        lihatDetail(data.permintaan_id);

                            fetch('/permintaan-barang/' + data.permintaan_id)
                            .then(res => res.json())
                            .then(permintaan => {

                                let badge = '';

                                if(permintaan.status == 'Menunggu'){
                                    badge = `
                                        <span style="
                                            background:#f59e0b;
                                            color:white;
                                            padding:5px 12px;
                                            border-radius:20px;
                                        ">
                                            ⟳ Menunggu
                                        </span>
                                    `;
                                }

                                if(permintaan.status == 'Disetujui'){
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

                                if(permintaan.status == 'Disetujui Sebagian'){
                                    badge = `
                                        <span style="
                                            background:#8b5cf6;
                                            color:white;
                                            padding:5px 12px;
                                            border-radius:20px;
                                        ">
                                            ∞ Disetujui Sebagian
                                        </span>
                                    `;
                                }

                                if(permintaan.status == 'Ditolak'){
                                    badge = `
                                        <span style="
                                            background:#ef4444;
                                            color:white;
                                            padding:5px 12px;
                                            border-radius:20px;
                                        ">
                                            ✘ Ditolak
                                        </span>
                                    `;
                                }

                                if(permintaan.status == 'Sudah Diambil'){
                                    badge = `
                                        <span style="
                                            background:#3b82f6;
                                            color:white;
                                            padding:5px 12px;
                                            border-radius:20px;
                                        ">
                                            ✓ Sudah Diambil
                                        </span>
                                    `;
                                }

                                document.getElementById(
                                    'status-permintaan-' + permintaan.id
                                ).innerHTML = badge;

                            });

                    });

                }

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
