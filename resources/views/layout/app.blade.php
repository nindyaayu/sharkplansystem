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

/* SUBMENU */
.menu-item {
    display:flex;
    flex-direction:column;
}

.menu-link {
    display:flex;
    justify-content:space-between;
    align-items:center;
    cursor:pointer;
    padding:12px;
    border-radius:10px;
    color:#94a3b8;
}

.menu-link:hover {
    background:rgba(99,102,241,0.1);
    color:white;
}

.arrow {
    font-size:12px;
}

/* SUBMENU */
.submenu {
    display:none;
    flex-direction:column;
    margin-left:15px;
    margin-top:5px;
}

.menu-item.open .submenu {
    display:flex;
}

.submenu a {
    padding:10px;
    font-size:13px;
    color:#94a3b8;
    border-radius:8px;
}

.submenu a:hover {
    background:rgba(99,102,241,0.1);
    color:white;
}

/* DIVIDER */
.divider {
    margin:15px 0;
    border-top:1px solid rgba(255,255,255,0.1);
}
</style>
</head>

<body>

<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="logo">SHARKPLAN</div>

        <div class="menu">

            <a href="/dashboard">🏠 Dashboard</a>

            <a href="/bahan">📦 Bahan Baku</a>

            <a href="/produk">📁 Produk</a>

            <a href="/bom">🔗 BOM</a>

            <!-- INVENTORI -->
            <div class="menu-item">
                <div class="menu-link" onclick="toggleMenu(this)">
                    📊 Inventori
                    <span class="arrow">▼</span>
                </div>

                <div class="submenu">
                    <a href="/barang-masuk">Barang Masuk</a>
                    <a href="/barang-keluar">Barang Keluar</a>
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

<script>
function toggleMenu(el) {
    el.parentElement.classList.toggle('open');
}
</script>

</body>
</html>