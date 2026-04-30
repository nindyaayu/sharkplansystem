<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - SharkPlan</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', sans-serif;
}

body {
    background: #f1f5f9;
}

.container {
    display: flex;
    height: 100vh;
}

/* LEFT */
.left {
    width: 50%;
    background: url('{{ asset("images/bg-login.jpg") }}') no-repeat center;
    background-size: cover;
    position: relative;
    color: white;
}

.overlay { position: absolute; inset: 0; background: rgba(5, 15, 40, 0.9); display: flex; flex-direction: column; justify-content: center; padding: 240px; } /* TEXT */ .brand { margin-top: -200px; } .brand h1 { font-size: 50px; font-weight: bold; letter-spacing: 2px; margin-bottom: 10px; } .brand h2 { font-size: 20px; margin-bottom: 10px; } .brand span { color: #4da3ff; font-weight: bold; } .brand p { font-size: 14px; opacity: 0.9; line-height: 1.5; } /* LOGO */ .logo-shark { position: absolute; bottom: 180px; left: 260px; width: 170px; opacity: 0.9; filter: drop-shadow(0 0 10px rgba(0,0,0,0.5)); }

/* RIGHT */
.right {
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-box {
    width: 360px;
}

/* TITLE */
.login-box h2 {
    text-align: center;
    margin-bottom: 10px;
}

.login-box p {
    text-align: center;
    margin-bottom: 25px;
    color: #777;
}

/* LABEL */
.label {
    font-size: 14px;
    margin-bottom: 5px;
    display: block;
    color: #333;
}

/* INPUT */
.input-group {
    position: relative;
    margin-bottom: 15px;
}

.input-group span {
    position: absolute;
    left: 12px;
    top: 13px;
}

.input-group input {
    width: 100%;
    padding: 14px 40px 14px 40px;
    border-radius: 10px;
    border: 1px solid #ddd;
    background: #f1f5f9;
}

/* ICON MATA */
.eye {
    position: absolute;
    right: 12px;
    top: 13px;
    cursor: pointer;
}

/* OPTIONS */
.options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    margin-bottom: 15px;
}

.options a {
    color: #2563eb;
    text-decoration: none;
}

/* BUTTON */
.login-btn {
    width: 100%;
    padding: 14px;
    background: linear-gradient(to right, #2563eb, #3b82f6);
    border: none;
    color: white;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    margin-top: 10px;
}

/* DIVIDER */
.divider {
    margin-top: 30px;
    text-align: center;
    position: relative;
    color: #aaa;
    font-size: 12px;
}

.divider::before,
.divider::after {
    content: "";
    position: absolute;
    top: 50%;
    width: 40%;
    height: 1px;
    background: #ddd;
}

.divider::before {
    left: 0;
}

.divider::after {
    right: 0;
}

/* ERROR */
.error {
    color: red;
    text-align: center;
    margin-bottom: 10px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .left { display: none; }
    .right { width: 100%; }
}
</style>
</head>

<body>

<div class="container">

<!-- LEFT -->
<div class="left">
    <div class="overlay">
        <div class="brand">
            <h1>SHARKTEX</h1>
            <h2><span>SHARKPLAN</span> SYSTEM</h2>
            <p>
                Sistem Perencanaan dan Stok Gudang<br>
                PT. SHARKTEX
            </p>
        </div>
    </div>

    <img src="{{ asset('images/logo-shark.png') }}" class="logo-shark">
</div>

<!-- RIGHT -->
<div class="right">
    <div class="login-box">

        <h2>Selamat Datang!</h2>
        <p>Silakan masuk untuk melanjutkan ke SharkPlan System</p>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <label class="label">Username</label>
            <div class="input-group">
                <span>👤</span>
                <input type="email" name="email" placeholder="Masukkan username">
            </div>

            <label class="label">Password</label>
            <div class="input-group">
                <span>🔒</span>
                <input type="password" name="password" placeholder="Masukkan password">
                <div class="eye">👁</div>
            </div>

            <div class="options">
                <label><input type="checkbox"> Ingat saya</label>
                <a href="#">Lupa password?</a>
            </div>

            <button class="login-btn">LOGIN</button>
        </form>

        <div class="divider">
            <span>SHARKPLAN SYSTEM</span>
        </div>

    </div>
</div>

</div>

</body>
</html>