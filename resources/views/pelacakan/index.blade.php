@extends('layout.app')

@section('content')

<div class="card" style="padding:30px;">

```
<h1 style="color:white;margin-bottom:20px;">
    Pelacakan Barang
</h1>

<form method="GET" id="form-pelacakan">

    <div
        style="
            display:flex;
            gap:15px;
            flex-wrap:wrap;
            margin-bottom:15px;
        "
    >

        <input
            type="date"
            name="tgl_awal"
            value="{{ request('tgl_awal') }}"
            style="
                padding:10px;
                border-radius:10px;
            "
        >

        <input
            type="date"
            name="tgl_akhir"
            value="{{ request('tgl_akhir') }}"
            style="
                padding:10px;
                border-radius:10px;
            "
        >

    </div>

    <input
        type="text"
        id="barang_search_pelacakan"
        placeholder="🔍 Cari kode, nama, warna..."
        autocomplete="off"
        style="
            width:100%;
            padding:14px;
            border-radius:12px;
            border:1px solid #334155;
            background:#0f1b3f;
            color:white;
            margin-bottom:15px;
        "
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
        style="
            background:#6366f1;
            color:white;
            border:none;
            padding:10px 20px;
            border-radius:10px;
            cursor:pointer;
        "
    >
        🔍 Tampilkan
    </button>

    @if(request('barang_id'))

    <a
        href="{{ route('pelacakan-barang-pdf', request()->all()) }}"
        target="_blank"
        style="
            background:#16a34a;
            color:white;
            text-decoration:none;
            padding:10px 20px;
            border-radius:10px;
        "
    >
        📄 Export PDF
    </a>

    @endif

</div>

</form>

@if($barangDipilih)

<div
    style="
        background:#111827;
        padding:20px;
        border-radius:12px;
        margin-top:20px;
        color:white;
    "
>

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

<div
    style="
        margin-top:20px;
        background:#111827;
        padding:20px;
        border-radius:12px;
        color:white;
    "
>

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

<div
    style="
        margin-top:20px;
        background:#111827;
        padding:20px;
        border-radius:12px;
        color:white;
    "
>

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
```

</div>

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
