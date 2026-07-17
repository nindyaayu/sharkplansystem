@extends('layout.app')

@section('content')

<style>

html{
    scroll-behavior:smooth;
}

/* ===== GLOBAL ===== */

body{
    background:#0f172a;
    color:#1f2937;
}

/* ===== TOPBAR ===== */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.topbar h2{
    font-weight:600;
    color:#111827;
}

.admin{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:14px;
    color:#94a3b8;
    background:rgba(255,255,255,0.05);
    padding:8px 12px;
    border-radius:10px;
}

/* ===== CARDS ===== */

.cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:20px;
    margin-bottom:25px;
}

.card-box{
    text-decoration:none;
    color:inherit;
    display:block;

    background:#ffffff;
    backdrop-filter:blur(10px);
    border-radius:16px;
    padding:20px;
    border:1px solid rgba(255,255,255,0.05);
    position:relative;
    overflow:hidden;
    transition:0.3s;
}

.card-box:hover{
    transform:translateY(-6px);
    box-shadow:0 0 25px rgba(99,102,241,0.25);
}

/* glow */

.card-box::before{
    content:"";
    position:absolute;
    width:200px;
    height:200px;
    top:-60px;
    right:-60px;
}

/* isi */

.card-box h4{
    font-size:14px;
    color:#6b7280;
}

.card-box h1{
    margin:10px 0;
    font-size:30px;
    color:#111827;
}

.card-box p{
    font-size:12px;
}

/* glow warna */

.card-box:nth-child(1)::before{
    background:
    radial-gradient(
        circle,
        rgba(34,197,94,0.2),
        transparent
    );
}

.card-box:nth-child(2)::before{
    background:
    radial-gradient(
        circle,
        rgba(99,102,241,0.2),
        transparent
    );
}

.card-box:nth-child(3)::before{
    background:
    radial-gradient(
        circle,
        rgba(245,158,11,0.2),
        transparent
    );
}

.card-box:nth-child(4)::before{
    background:
    radial-gradient(
        circle,
        rgba(239,68,68,0.2),
        transparent
    );
}

/* ===== CHART ===== */

.chart-box{
    background:#ffffff;
    /*backdrop-filter:blur(10px); */
    border-radius:16px;
    padding:20px;
    border:1px solid rgba(255,255,255,0.05);
}

.chart-title{
    margin-bottom:15px;
    font-weight:500;
    color:#111827;
}

/* ===== RESPONSIVE ===== */

@media(max-width:1000px){

    .cards{
        grid-template-columns:
        repeat(2,1fr);
    }
}

@media(max-width:600px){

    .cards{
        grid-template-columns:1fr;
    }
}

</style>

<!-- ===== TOP ===== -->

<div class="topbar">

    <div>

        <h2>Dashboard</h2>

        <p
            style="
                color:#64748b;
                font-size:13px;
            ">

            Welcome back, {{ Auth::user()->name }} 👋

        </p>

    </div>

        <div class="admin">
            👤 {{ ucfirst(Auth::user()->role) }} ({{ Auth::user()->cabang }})
        </div>

</div>

<!-- ===== CARD ===== -->

<div class="cards">

    <!-- BAHAN -->
    <a href="/bahan" class="card-box">

        <h4>Bahan Baku</h4>

        <h1>

            {{ $totalBahan }}

        </h1>

        @if($bahanBaru > 0)

            <p style="color:#22c55e;">

                ▲ +{{ $bahanBaru }}
                data baru

            </p>

        @else

            <p style="color:#64748b;">

                Tidak ada data baru

            </p>

        @endif

    </a>

    <!-- PRODUK -->
    <a href="/produk" class="card-box">

        <h4>Produk</h4>

        <h1>

            {{ $totalProduk }}

        </h1>

        <p style="color:#6366f1;">

            Total Produk

        </p>

    </a>

    <!-- STOK -->
    <a href="/laporan" class="card-box">

        <h4>Stok Bahan</h4>

        <h1>

            {{ number_format($totalStok) }}

        </h1>

        @if($stokKritis > 0)

            <p style="color:#f59e0b;">

                ⚠ {{ $stokKritis }}
                stok kritis

            </p>

        @else

            <p style="color:#22c55e;">

                ✔ Stok aman

            </p>

        @endif

    </a>

    <!-- TRANSAKSI -->
    <a href="#grafik" class="card-box">

        <h4>Transaksi</h4>

        <h1>

            {{ $totalTransaksi }}

        </h1>

        <p style="color:#22c55e;">

            Total Transaksi

        </p>

    </a>

</div>

<!-- ===== CHART ===== -->

<div class="chart-box" id="grafik">

    <div class="chart-title">

        Grafik Barang Masuk & Keluar

    </div>

    <canvas id="chart"></canvas>

</div>

<!-- ===== CHART JS ===== -->

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx =
    document
    .getElementById('chart')
    .getContext('2d');

const gradient1 =
    ctx.createLinearGradient(0,0,0,300);

gradient1.addColorStop(
    0,
    "rgba(99,102,241,0.5)"
);

gradient1.addColorStop(
    1,
    "rgba(99,102,241,0)"
);

const gradient2 =
    ctx.createLinearGradient(0,0,0,300);

gradient2.addColorStop(
    0,
    "rgba(148,163,184,0.4)"
);

gradient2.addColorStop(
    1,
    "rgba(148,163,184,0)"
);

new Chart(ctx, {

    type:'line',

    data:{

        labels:[

            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Ags',
            'Sep',
            'Okt',
            'Nov',
            'Des'

        ],

        datasets:[

            {

                label:'Barang Masuk',

                data:
                    @json($barangMasukChart),

                borderColor:'#6366f1',

                backgroundColor:
                    gradient1,

                fill:true,

                tension:0.4
            },

            {

                label:'Barang Keluar',

                data:
                    @json($barangKeluarChart),

                borderColor:'#94a3b8',

                backgroundColor:
                    gradient2,

                fill:true,

                borderDash:[6,6],

                tension:0.4
            }

        ]
    },

    options:{

        responsive:true,

        plugins:{

            legend:{

                labels:{

                    color:"#cbd5f5"

                },

                position:'bottom'
            }
        },

        scales:{

            x:{

                ticks:{

                    color:"#94a3b8"

                },

                grid:{

                    color:
                    "rgba(255,255,255,0.05)"
                }
            },

            y:{

                ticks:{

                    color:"#94a3b8"

                },

                grid:{

                    color:
                    "rgba(255,255,255,0.05)"
                }
            }
        }
    }
});

</script>

@endsection