@extends('layout.app')

@section('content')

<style>

/* =========================
   PAGE
========================= */

body{
    background:#0f172a;
    color:#e5e7eb;
}

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-header h2{
    color:#fff;
    font-weight:600;
}

/* =========================
   CARD
========================= */

.card-production{

    background:rgba(17,24,39,.70);

    backdrop-filter:blur(10px);

    border:1px solid rgba(255,255,255,.05);

    border-radius:16px;

    padding:20px;

    margin-bottom:20px;

}

/* =========================
   FORM
========================= */

.form-row{

    display:flex;

    gap:15px;

    flex-wrap:wrap;

}

.input{

    background:#111827;

    border:1px solid rgba(255,255,255,.08);

    color:#fff;

    border-radius:10px;

    padding:10px 12px;

    min-width:220px;

}

textarea.input{

    min-width:300px;

}

select.input option{

    background:#111827;

}

/* =========================
   BUTTON
========================= */

.btn-primary{

    background:linear-gradient(90deg,#6366f1,#8b5cf6);

    color:#fff;

    border:none;

    padding:10px 18px;

    border-radius:10px;

    cursor:pointer;

    transition:.3s;

}

.btn-primary:hover{

    box-shadow:0 0 15px rgba(99,102,241,.5);

}

.btn-success{

    background:#16a34a;

    color:white;

    border:none;

    border-radius:8px;

    padding:8px 14px;

    cursor:pointer;

}

.btn-warning{

    background:#f59e0b;

    color:white;

    border:none;

    border-radius:8px;

    padding:8px 14px;

    cursor:pointer;

}

.btn-danger{

    background:#dc2626;

    color:white;

    border:none;

    border-radius:8px;

    padding:8px 14px;

    cursor:pointer;

}

/* =========================
   TABLE
========================= */

.table-production{

    width:100%;

    border-collapse:collapse;

}

.table-production thead{

    background:rgba(255,255,255,.03);

}

.table-production thead th{

    padding:14px;

    color:#94a3b8;

    text-align:left;

    font-size:13px;

}

.table-production tbody td{

    padding:14px;

    border-top:1px solid rgba(255,255,255,.05);

}

.table-production tbody tr:hover{

    background:rgba(99,102,241,.05);

}

/* =========================
   BADGE
========================= */

.badge{

    padding:6px 10px;

    border-radius:8px;

    font-size:13px;

}

.badge-draft{

    background:rgba(250,204,21,.20);

    color:#facc15;

}

.badge-cutting{

    background:rgba(59,130,246,.20);

    color:#60a5fa;

}

.badge-production{

    background:rgba(168,85,247,.20);

    color:#c084fc;

}

.badge-success{

    background:rgba(34,197,94,.20);

    color:#22c55e;

}

/* =========================
   ALERT
========================= */

.alert-success{

    background:rgba(34,197,94,.15);

    border:1px solid rgba(34,197,94,.30);

    color:#22c55e;

    padding:12px;

    border-radius:10px;

    margin-bottom:15px;

}

.alert-danger{

    background:rgba(220,38,38,.15);

    border:1px solid rgba(220,38,38,.30);

    color:#ef4444;

    padding:12px;

    border-radius:10px;

    margin-bottom:15px;

}

</style>

@if(session('success'))

<div class="alert-success">

    {{ session('success') }}

</div>

@endif

@if(session('error'))

<div class="alert-danger">

    {{ session('error') }}

</div>

@endif

@yield('production-content')

@endsection