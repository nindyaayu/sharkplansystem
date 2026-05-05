@extends('layout.app')

@section('content')

<style>

/* ===== HEADER ===== */
.title {
    color:white;
    font-weight:600;
    margin-bottom:20px;
}

/* ===== CONTAINER ===== */
.container-box {
    display:flex;
    gap:20px;
    flex-wrap:wrap;
}

/* CARD */
.card {
    background:rgba(17,24,39,0.7);
    padding:20px;
    border-radius:16px;
    width:350px;
}

/* LABEL */
.label {
    color:#94a3b8;
    font-size:13px;
    margin-bottom:5px;
    display:block;
}

/* INPUT */
.input {
    width:100%;
    padding:10px;
    border-radius:10px;
    border:1px solid rgba(255,255,255,0.1);
    background:#111827;
    color:white;
    margin-bottom:15px;
}

/* BUTTON */
.btn {
    background: linear-gradient(90deg,#6366f1,#8b5cf6);
    border:none;
    padding:10px 16px;
    border-radius:10px;
    color:white;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover {
    box-shadow:0 0 12px rgba(99,102,241,0.6);
}

</style>

<h2 class="title">Pengaturan Akun</h2>

<div class="container-box">

    <!-- ===== PROFIL ===== -->
    <div class="card">
        <h4 style="color:white; margin-bottom:15px;">Profil</h4>

        <label class="label">Nama</label>
        <input type="text" class="input" value="Admin">

        <label class="label">Email</label>
        <input type="email" class="input" value="admin@gmail.com">

        <button class="btn">Simpan Profil</button>
    </div>

    <!-- ===== PASSWORD ===== -->
    <div class="card">
        <h4 style="color:white; margin-bottom:15px;">Ganti Password</h4>

        <label class="label">Password Lama</label>
        <input type="password" class="input">

        <label class="label">Password Baru</label>
        <input type="password" class="input">

        <button class="btn">Update Password</button>
    </div>

    <!-- ===== BAHASA ===== -->
    <div class="card">
        <h4 style="color:white; margin-bottom:15px;">Bahasa</h4>

        <label class="label">Pilih Bahasa</label>
        <select class="input">
            <option>Indonesia</option>
            <option>English</option>
        </select>

        <button class="btn">Simpan Bahasa</button>
    </div>

</div>

@endsection