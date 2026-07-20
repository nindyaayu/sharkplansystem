@extends('layout.app')

@section('content')

<div class="page-header">

    <div class="page-title">
        <h1>Pelacakan Barang</h1>
        <p>Riwayat barang masuk, keluar, dan penggunaan material</p>
    </div>

</div>

<div class="filter-card">

<form method="GET" id="form-pelacakan">

    <div class="filter-row">

        <input
            type="date"
            name="tgl_awal"
            value="{{ request('tgl_awal') }}"
        >

        <input
            type="date"
            name="tgl_akhir"
            value="{{ request('tgl_akhir') }}"
        >

    </div>

    <input
    type="text"
    id="barang_search_pelacakan"
    class="search-barang"
    placeholder="🔍 Cari kode, nama, warna..."
    autocomplete="off"
    required
>

    <input
        type="hidden"
        name="barang_id"
        id="barang_id_pelacakan"
        value="{{ request('barang_id') }}"
    >

    <datalist id="barang_list_pelacakan"></datalist>

    <div style="display:flex;gap:10px;">

    <button
    type="submit"
    class="btn-tampilkan"
>
        🔍 Tampilkan
    </button>

    @if(request('barang_id'))

    <a
        href="{{ route('pelacakan-barang-pdf', request()->all()) }}"
        target="_blank"
        class="btn-export"
    >
        📄 Export PDF
    </a>

    @endif

</div>

</form>

@if($barangDipilih)

<div class="result-card">

    <h3>
        INFORMASI BARANG
    </h3>

    <table style="width:100%;">

        <tr>
            <td>Kode Barang</td>
            <td>{{ $barangDipilih->kode }}</td>
        </tr>

        <tr>
            <td>Nama Barang</td>
            <td>{{ $barangDipilih->nama }}</td>
        </tr>

        <tr>
            <td>Satuan</td>
            <td>{{ strtoupper($barangDipilih->satuan) }}</td>
        </tr>

        <tr>
            <td>Stok Saat Ini</td>
            <td>{{ number_format($stokSaatIni,0) }}</td>
        </tr>

        <tr>
            <td>Total Masuk</td>
            <td>{{ number_format($riwayatMasuk->sum('jumlah'),0) }}</td>
        </tr>

        <tr>
            <td>Total Keluar</td>
            <td>{{ number_format($riwayatKeluar->sum('jumlah'),0) }}</td>
        </tr>

    </table>

    <hr style="margin:20px 0;">

    <h3>
        REKAP PEMAKAIAN PER PRODUK
    </h3>

    <table style="width:100%;">

        @foreach($rekapProduk as $item)

        <tr>

            <td>
                {{ $item->produk->nama ?? '-' }}
            </td>

            <td align="right">
                {{ number_format($item->total,0) }}
            </td>

        </tr>

        @endforeach

    </table>

    <hr style="margin:20px 0;">

    <h3>
        REKAP PEMAKAIAN PER PEMINTA
    </h3>

    <table style="width:100%;">

        @foreach($rekapPeminta as $item)

        <tr>

            <td>
                {{ $item->nama_peminta }}
            </td>

            <td align="right">
                {{ number_format($item->total,0) }}
            </td>

        </tr>

        @endforeach

    </table>

    <hr style="margin:20px 0;">

    <h3>
        REKAP PEMAKAIAN PER PENJAHIT
    </h3>

    <table style="width:100%;">

        @foreach($rekapPenjahit as $item)

        <tr>

            <td>
                {{ $item->nama_penjahit }}
            </td>

            <td align="right">
                {{ number_format($item->total,0) }}
            </td>

        </tr>

        @endforeach

    </table>

</div>

<div class="result-card">

    <h3>
        RIWAYAT BARANG MASUK
    </h3>

    <table
        style="
            width:100%;
            border-collapse:collapse;
        "
    >

        <tr>

            <th>Tanggal</th>

            <th>Supplier</th>

            <th>Qty</th>

        </tr>

        @foreach($riwayatMasuk as $item)

        <tr>

            <td>
                {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('d/m/Y') }}
            </td>

            <td>
                {{ $item->supplier }}
            </td>

            <td>
                {{ number_format($item->jumlah,0) }}
            </td>

        </tr>

        @endforeach

    </table>

</div>

<div class="result-card">

    <h3>
        RIWAYAT BARANG KELUAR
    </h3>

    <table
        style="
            width:100%;
            border-collapse:collapse;
        "
    >

        <tr>

            <th>Tanggal</th>

            <th>Produk</th>

            <th>Peminta</th>

            <th>Penjahit</th>

            <th>Qty</th>

        </tr>

        @foreach($riwayatKeluar as $item)

        <tr>

            <td>
                {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}
            </td>

            <td>
                {{ $item->produk->nama ?? '-' }}
            </td>

            <td>
                {{ $item->nama_peminta ?? '-' }}
            </td>

            <td>
                {{ $item->nama_penjahit ?? '-' }}
            </td>

            <td>
                {{ number_format($item->jumlah,0) }}
            </td>

        </tr>

        @endforeach

    </table>

</div>

@endif

</div>

<style>
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    background:linear-gradient(135deg,#3F4F44,#556B5D);
    border-radius:20px;
    padding:22px 30px;
    margin-bottom:20px;
}

.page-title h1{
    color:#fff;
    font-size:42px;
    margin:0;
    font-weight:700;
}

.page-title p{
    margin-top:8px;
    color:#e8ece8;
    font-size:15px;
}

.pelacakan-card{
    padding:30px;
    border-radius:18px;
    background:#fff;
}

.filter-row{
    display:flex;
    gap:15px;
    align-items:center;
    margin-bottom:18px;
    flex-wrap:wrap;
}

.filter-row input[type=date]{
    width:180px;
    height:45px;
    border-radius:10px;
    border:1px solid #d1d5db;
    padding:0 15px;
}

.search-barang{
    width:100%;
    height:48px;
    border-radius:12px;
    border:1px solid #d1d5db;
    padding:0 18px;
    margin-bottom:15px;
}

.btn-tampilkan{
    background:#6366f1;
    color:#fff;
    border:none;
    padding:12px 28px;
    border-radius:10px;
    font-weight:600;
}

.filter-card{
    background:#ffffff;
    padding:25px;
    border-radius:18px;
    margin-bottom:25px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
}

.result-card{
    background:#fff;
    border-radius:18px;
    padding:25px;
    margin-bottom:20px;
    box-shadow:0 5px 18px rgba(0,0,0,.08);
}

.result-card table{
    width:100%;
    border-collapse:collapse;
}

.result-card td,
.result-card th{
    padding:12px;
    border-bottom:1px solid #eee;
}

.result-card h3{
    color:#3F4F44;
    font-size:24px;
    font-weight:700;
    margin-bottom:20px;
    padding-bottom:12px;
    border-bottom:2px solid #e5e7eb;
}

.btn-export{
    background:#16a34a;
    color:#fff;
    text-decoration:none;
    padding:12px 28px;
    border-radius:10px;
    font-weight:600;
}

</style>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const searchInput =
        document.getElementById(
            'barang_search_pelacakan'
        );

    const barangId =
        document.getElementById(
            'barang_id_pelacakan'
        );

    const list =
        document.getElementById(
            'barang_list_pelacakan'
        );

    let hasilData = [];

    searchInput.setAttribute(
        'list',
        'barang_list_pelacakan'
    );

    searchInput.addEventListener(
        'input',
        async function(){

            const response =
                await fetch(
                    '/search-barang?q=' +
                    encodeURIComponent(
                        this.value
                    )
                );

            hasilData =
                await response.json();

            list.innerHTML = '';

            hasilData.forEach(item => {

                const option =
                    document.createElement(
                        'option'
                    );

                option.value =
                    item.text;

                list.appendChild(option);

            });

        }
    );

    searchInput.addEventListener(
        'change',
        function(){

            const selected =
                hasilData.find(
                    x => x.text === this.value
                );

            if(selected){

                barangId.value =
                    selected.id;

            }

        }
    );

});

</script>

@endsection
