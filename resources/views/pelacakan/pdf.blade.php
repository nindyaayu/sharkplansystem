<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
        }

        h1,h2,h3{
            margin:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
            margin-bottom:20px;
        }

        th,td{
            border:1px solid #000;
            padding:6px;
        }

        th{
            background:#e5e5e5;
        }

        .section{
            margin-top:20px;
        }

        body{
    font-family: DejaVu Sans;
    font-size:12px;
    color:#1e293b;
}

.section h3{
    background:#1e40af;
    color:white;
    padding:8px;
}

    </style>
</head>
<body>

    <table style="width:100%; border:none; margin-bottom:20px;">
    <tr>

        <td style="border:none; width:90px;">

            <img
                src="{{ public_path('images/logo-shark.png') }}"
                width="70">

        </td>

        <td style="border:none;">

            <div style="
                font-size:28px;
                font-weight:bold;
                color:#1e3a8a;
            ">
                SHARKPLAN
            </div>

            <div style="
                font-size:14px;
                color:#475569;
            ">
                Inventory & Production System
            </div>

            <div style="
                font-size:18px;
                font-weight:bold;
                margin-top:8px;
            ">
                LAPORAN PELACAKAN BARANG
            </div>

        </td>

        <td
            align="right"
            style="border:none; font-size:11px;">

            <b>Tanggal Cetak</b><br>
            {{ now()->format('d/m/Y H:i') }}

            <br><br>

            <b>Periode</b><br>

            @if(request('tgl_awal') && request('tgl_akhir'))
                {{ \Carbon\Carbon::parse(request('tgl_awal'))->format('d/m/Y') }}
                s/d
                {{ \Carbon\Carbon::parse(request('tgl_akhir'))->format('d/m/Y') }}
            @elseif(request('tgl_awal'))
                Mulai {{ \Carbon\Carbon::parse(request('tgl_awal'))->format('d/m/Y') }}
            @elseif(request('tgl_akhir'))
                Sampai {{ \Carbon\Carbon::parse(request('tgl_akhir'))->format('d/m/Y') }}
            @else
                Semua Periode
            @endif

            <br><br>

            <b>Cabang</b><br>

            {{ auth()->user()->cabang ?? 'PUSAT' }}

        </td>

    </tr>
</table>

<hr style="
    border:none;
    border-top:3px solid #1e40af;
    margin-bottom:20px;
">

    <div class="section">

        <h3>Informasi Barang</h3>

        <table>

            <tr>
                <td width="30%">Kode Barang</td>
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

    </div>

    <div class="section">

        <h3>Rekap Pemakaian Per Produk</h3>

        <table>

            <tr>
                <th>Produk</th>
                <th>Total</th>
            </tr>

            @foreach($rekapProduk as $item)

            <tr>
                <td>{{ $item->produk->nama ?? '-' }}</td>
                <td>{{ number_format($item->total,0) }}</td>
            </tr>

            @endforeach

        </table>

    </div>

    <div class="section">

        <h3>Riwayat Barang Masuk</h3>

        <table>

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

    <div class="section">

        <h3>Riwayat Barang Keluar</h3>

        <table>

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

<br><br>

<div style="
    text-align:center;
    font-size:10px;
    color:#64748b;
">

    Dicetak dari sistem SHARKPLAN -
    Inventory & Production System

</div>

</body>
</html>