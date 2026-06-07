@extends('layout.app')

@section('content')

<div class="card" style="padding:30px;">

    <h1 style="color:white;margin-bottom:20px;">
        Pelacakan Barang
    </h1>

    <form method="GET">

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
                box-sizing:border-box;
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

            <h3 style="margin-bottom:15px;">

                {{ $barangDipilih->kode }}
                -
                {{ $barangDipilih->nama }}

            </h3>

            <p>

                <b>Stok Saat Ini :</b>

                {{ $barangDipilih->stok }}

            </p>

            <p>

                <b>Total Keluar :</b>

                {{ $riwayatKeluar->sum('jumlah') }}

            </p>

        </div>

        <div
            style="
                margin-top:20px;
                background:#111827;
                border-radius:12px;
                overflow:hidden;
            "
        >

            <table
                style="
                    width:100%;
                    border-collapse:collapse;
                    color:white;
                "
            >

                <thead>

                    <tr style="background:#1f2937;">

                        <th style="padding:12px;">
                            Tanggal
                        </th>

                        <th style="padding:12px;">
                            Produk
                        </th>

                        <th style="padding:12px;">
                            Tujuan
                        </th>

                        <th style="padding:12px;">
                            Qty
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($riwayatKeluar as $item)

                        <tr>

                            <td style="padding:12px;">

                                {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d/m/Y') }}

                            </td>

                            <td style="padding:12px;">

                                {{ $item->produk->nama ?? '-' }}

                            </td>

                            <td style="padding:12px;">

                                {{ $item->tujuan }}

                            </td>

                            <td style="padding:12px;">

                                {{ number_format($item->jumlah,0) }}

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="4"
                                style="
                                    text-align:center;
                                    padding:20px;
                                "
                            >

                                Belum ada riwayat keluar

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @endif

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

    searchInput.setAttribute(
        'list',
        'barang_list_pelacakan'
    );

    let hasilData = [];

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