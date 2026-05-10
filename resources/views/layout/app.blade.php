<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SharkPlan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#0f172a;
}

/* ================= LAYOUT ================= */

.wrapper{
    display:flex;
}

/* ================= SIDEBAR ================= */

.sidebar{
    width:240px;
    height:100vh;
    background:linear-gradient(180deg,#020617,#0f172a);
    color:white;
    padding:20px;
    position:fixed;
    overflow-y:auto;
}

/* ================= CONTENT ================= */

.main{
    margin-left:260px;
    padding:40px;
    width:100%;
}

/* ================= LOGO ================= */

.logo{
    font-size:18px;
    font-weight:bold;
    margin-bottom:30px;
}

/* ================= MENU ================= */

.menu a{
    display:flex;
    align-items:center;
    gap:10px;
    padding:12px;
    border-radius:10px;
    color:#94a3b8;
    text-decoration:none;
    margin-bottom:6px;
    font-size:14px;
    transition:0.2s;
}

/* ================= HOVER ================= */

.menu a:hover{
    background:rgba(99,102,241,0.1);
    color:white;
}

/* ================= ACTIVE ================= */

.menu a.active{
    background:linear-gradient(90deg,#6366f1,#8b5cf6);
    color:white;
    font-weight:600;
}

/* ================= MENU ITEM ================= */

.menu-item{
    display:flex;
    flex-direction:column;
    margin-bottom:5px;
}

/* ================= MENU LINK ================= */

.menu-link{
    display:flex;
    justify-content:space-between;
    align-items:center;
    cursor:pointer;
    padding:12px;
    border-radius:10px;
    color:#94a3b8;
    transition:0.2s;
}

.menu-link:hover{
    background:rgba(99,102,241,0.1);
    color:white;
}

/* ================= ARROW ================= */

.arrow{
    font-size:12px;
    transition:0.2s;
}

.menu-item.open .arrow{
    transform:rotate(180deg);
}

/* ================= SUBMENU ================= */

.submenu{
    display:none;
    flex-direction:column;
    margin-left:15px;
    margin-top:5px;
}

.menu-item.open .submenu{
    display:flex;
}

/* ================= SUBMENU LINK ================= */

.submenu a{
    padding:10px;
    font-size:13px;
    color:#94a3b8;
    border-radius:8px;
    text-decoration:none;
    transition:0.2s;
}

.submenu a:hover{
    background:rgba(99,102,241,0.1);
    color:white;
}

/* ================= DIVIDER ================= */

.divider{
    margin:15px 0;
    border-top:1px solid rgba(255,255,255,0.1);
}

</style>
</head>

<body>

<div class="wrapper">

    <!-- ================= SIDEBAR ================= -->

    <div class="sidebar">

        <div class="logo">

            SHARKPLAN

        </div>

        <div class="menu">

            <!-- ================= ADMIN ================= -->

            @if(auth()->user()->role == 'admin')

                <!-- DASHBOARD -->

                <a href="/dashboard">

                    🏠 Dashboard

                </a>

                <!-- BAHAN BAKU -->

                <div class="menu-item">

                    <div class="menu-link" onclick="toggleMenu(this)">

                        📦 Bahan Baku

                        <span class="arrow">

                            ▼

                        </span>

                    </div>

                    <div class="submenu">

                        <a href="/material-utama">

                            Material Utama

                        </a>

                        <a href="/material-pendukung">

                            Material Pendukung

                        </a>

                    </div>

                </div>

                <!-- PRODUK -->

                <a href="/produk">

                    📁 Produk

                </a>

                <!-- BOM -->

                <div class="menu-item">

                    <div class="menu-link" onclick="toggleMenu(this)">

                        🔗 BOM

                        <span class="arrow">

                            ▼

                        </span>

                    </div>

                    <div class="submenu">

                        <a href="/master-bom">

                            Master BOM

                        </a>

                        <a href="/perhitungan-bom">

                            Perhitungan BOM

                        </a>

                    </div>

                </div>

                <!-- INVENTORI -->

                <div class="menu-item">

                    <div class="menu-link" onclick="toggleMenu(this)">

                        📊 Inventori

                        <span class="arrow">

                            ▼

                        </span>

                    </div>

                    <div class="submenu">

                        <!-- BARANG MASUK -->

                        <div class="menu-item">

                            <div class="menu-link" onclick="toggleMenu(this)">

                                📥 Barang Masuk

                                <span class="arrow">
                                    ▼
                                </span>

                            </div>

                            <div class="submenu">

                                <a href="/barang-masuk-material-utama">

                                    Material Utama

                                </a>

                                <a href="/barang-masuk-material-pendukung">

                                    Material Pendukung

                                </a>

                            </div>

                        </div>

                        <!-- BARANG KELUAR -->

                        <div class="menu-item">

                            <div class="menu-link" onclick="toggleMenu(this)">

                                📤 Barang Keluar

                                <span class="arrow">
                                    ▼
                                </span>

                            </div>

                            <div class="submenu">

                                <a href="/barang-keluar-material-utama">

                                    Material Utama

                                </a>

                                <a href="/barang-keluar-material-pendukung">

                                    Material Pendukung

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="divider"></div>
<!-- ================= LAPORAN ================= -->

<div class="menu-item">

    <div class="menu-link" onclick="toggleMenu(this)">

        📄 Laporan

        <span class="arrow">

            ▼

        </span>

    </div>

    <div class="submenu">

        <a href="/laporan-material-utama">

            Material Utama

        </a>

        <a href="/laporan-material-pendukung">

            Material Pendukung

        </a>

    </div>

</div>

                <a href="/laporan-produksi">

                    🏭 Laporan Produksi

                </a>
                <a href="/surat-jalan">
                    📦 Surat Jalan
                </a>

            @endif


            <!-- ================= GUDANG ================= -->

            @if(auth()->user()->role == 'gudang')

                <!-- DASHBOARD -->

                <a href="/dashboard">

                    🏠 Dashboard

                </a>

                <!-- BAHAN BAKU -->

                <div class="menu-item">

                    <div class="menu-link" onclick="toggleMenu(this)">

                        📦 Bahan Baku

                        <span class="arrow">

                            ▼

                        </span>

                    </div>

                    <div class="submenu">

                        <a href="/material-utama">

                            Material Utama

                        </a>

                        <a href="/material-pendukung">

                            Material Pendukung

                        </a>

                    </div>

                </div>

                <!-- INVENTORI -->

                <div class="menu-item">

                    <div class="menu-link" onclick="toggleMenu(this)">

                        📊 Inventori

                        <span class="arrow">

                            ▼

                        </span>

                    </div>

                    <div class="submenu">

                        <!-- BARANG MASUK -->

                        <div class="menu-item">

                            <div class="menu-link" onclick="toggleMenu(this)">

                                📥 Barang Masuk

                                <span class="arrow">
                                    ▼
                                </span>

                            </div>

                            <div class="submenu">

                                <a href="/barang-masuk-material-utama">

                                    Material Utama

                                </a>

                                <a href="/barang-masuk-material-pendukung">

                                    Material Pendukung

                                </a>

                            </div>

                        </div>

                        <!-- BARANG KELUAR -->

                        <div class="menu-item">

                            <div class="menu-link" onclick="toggleMenu(this)">

                                📤 Barang Keluar

                                <span class="arrow">
                                    ▼
                                </span>

                            </div>

                            <div class="submenu">

                                <a href="/barang-keluar-material-utama">

                                    Material Utama

                                </a>

                                <a href="/barang-keluar-material-pendukung">

                                    Material Pendukung

                                </a>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- BOM -->

                <a href="/perhitungan-bom">

                    🔗 Perhitungan BOM

                </a>
<!-- ================= LAPORAN ================= -->

<div class="menu-item">

    <div class="menu-link" onclick="toggleMenu(this)">

        📄 Laporan

        <span class="arrow">

            ▼

        </span>

    </div>

    <div class="submenu">

        <a href="/laporan-material-utama">

            Material Utama

        </a>

        <a href="/laporan-material-pendukung">

            Material Pendukung

        </a>

    </div>

</div>

            @endif


            <!-- ================= PKT ================= -->

            @if(auth()->user()->role == 'pkt')

                <!-- DASHBOARD -->

                <a href="/dashboard">

                    🏠 Dashboard

                </a>

                <!-- BOM -->

                <a href="/perhitungan-bom">

                    🔗 Perhitungan BOM

                </a>

                <!-- PRODUKSI -->

                <a href="/laporan-produksi">

                    🏭 Produksi

                </a>

            @endif

            <div class="divider"></div>

            <!-- LOGOUT -->

            <a href="/logout">

                🚪 Logout

            </a>

        </div>

    </div>

    <!-- ================= CONTENT ================= -->

    <div class="main">

        @yield('content')

    </div>

</div>

<script>

// =========================
// TOGGLE DROPDOWN
// =========================

function toggleMenu(el){

    el.parentElement.classList.toggle('open');

}

// =========================
// AUTO OPEN MENU
// =========================

window.onload = function(){

    const currentUrl = window.location.pathname;

    const menu =
        document.querySelectorAll('.menu-item');

    // ================= BAHAN =================

    if(
        currentUrl.includes('material-utama') ||
        currentUrl.includes('material-pendukung')
    ){

        if(menu[0]){

            menu[0].classList.add('open');

        }
    }

    // ================= BOM =================

    if(
        currentUrl.includes('master-bom') ||
        currentUrl.includes('perhitungan-bom')
    ){

        if(menu[1]){

            menu[1].classList.add('open');

        }
    }

    // ================= INVENTORI =================

    if(
        currentUrl.includes('barang-masuk') ||
        currentUrl.includes('barang-keluar')
    ){

        if(menu[2]){

            menu[2].classList.add('open');

        }
    }

}

</script>

</body>
</html>