<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>SharkPlan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
body {
    margin:0;
    font-family:'Segoe UI', sans-serif;
    background:#0f172a;
}

/* LAYOUT */
.wrapper {
    display:flex;
}

/* SIDEBAR */
.sidebar {
    width:240px;
    height:100vh;
    background:linear-gradient(180deg, #020617, #0f172a);
    color:white;
    padding:20px;
    position:fixed;
}

/* CONTENT */
.main {
    margin-left:260px;
    padding:40px;
    width:100%;
}

/* LOGO */
.logo {
    font-size:18px;
    font-weight:bold;
    margin-bottom:30px;
    letter-spacing:1px;
}

/* MENU */
.menu a {
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

/* HOVER */
.menu a:hover {
    background:rgba(99,102,241,0.1);
    color:white;
}

/* ACTIVE */
.menu a.active {
    background:linear-gradient(90deg, #6366f1, #8b5cf6);
    color:white;
    font-weight:600;
}

/* DIVIDER */
.divider {
    margin:15px 0;
    border-top:1px solid rgba(255,255,255,0.1);
}

/* ===== SUBMENU ===== */
.menu-item {
    display:flex;
    flex-direction:column;
}

/* tombol parent */
.menu-link {
    display:flex;
    align-items:center;
    justify-content:space-between;
}

/* arrow */
.arrow {
    font-size:12px;
}

/* submenu */
.submenu {
    display:none;
    flex-direction:column;
    margin-left:15px;
    margin-top:5px;
}

/* tampil saat open */
.menu-item.open .submenu {
    display:flex;
}

/* submenu item */
.submenu a {
    padding:10px;
    font-size:13px;
    color:#94a3b8;
    border-radius:8px;
}

/* hover submenu */
.submenu a:hover {
    background:rgba(99,102,241,0.1);
    color:white;
}

/* active submenu */
.submenu a.active {
    background:rgba(99,102,241,0.2);
    color:white;
}

</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">SHARKPLAN</div>

        <div class="menu">
            <a href="/dashboard" class="{{ request()->is('dashboard') ? 'active' : '' }}">🏠 Dashboard</a>
            <a href="/bahan" class="{{ request()->is('bahan') ? 'active' : '' }}">📦 Bahan Baku</a>
            <a href="/produk" class="{{ request()->is('produk') ? 'active' : '' }}">📁 Produk</a>
            <a href="/bom" class="{{ request()->is('bom') ? 'active' : '' }}">🔗 BOM</a>

            <!-- ===== INVENTORI (PARENT + SUBMENU) ===== -->
            <div class="menu-item {{ request()->is('barang-masuk') || request()->is('barang-keluar') ? 'open' : '' }}">
                <a href="#" class="menu-link" onclick="toggleMenu(event)">
                    📊 Inventori
                    <span class="arrow">▼</span>
                </a>

                <div class="submenu">
                    <a href="/barang-masuk" class="{{ request()->is('barang-masuk') ? 'active' : '' }}">
                        Barang Masuk
                    </a>
                    <a href="/barang-keluar" class="{{ request()->is('barang-keluar') ? 'active' : '' }}">
                        Barang Keluar
                    </a>
                </div>
            </div>

            <div class="divider"></div>

            <a href="/laporan">📄 Laporan</a>
            <a href="/pengguna">👤 Pengguna</a>
            <a href="/pengaturan">⚙️ Pengaturan</a>

            <div class="divider"></div>

            <a href="/logout">🚪 Logout</a>
        </div>

    </div>

    <!-- CONTENT -->
    <div class="main">
        @yield('content')
    </div>

</div>

<!-- ===== SCRIPT ===== -->
<script>
function toggleMenu(e) {
    e.preventDefault();
    const parent = e.target.closest('.menu-item');
    parent.classList.toggle('open');
}
</script>

</body>
</html>