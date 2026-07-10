@extends('layout.app')

@section('content')

<style>

.cards{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:20px;
    margin-top:20px;
}

.card-box{
    text-decoration:none;
    color:inherit;

    background:rgba(17,24,39,0.7);
    backdrop-filter:blur(10px);

    border-radius:16px;
    padding:30px;

    border:1px solid rgba(255,255,255,0.05);

    transition:.3s;
}

.card-box:hover{
    transform:translateY(-5px);
}

.card-box h3{
    color:white;
    margin-bottom:10px;
}

.card-box p{
    color:#94a3b8;
}

@media(max-width:768px){

    .cards{
        grid-template-columns:1fr;
    }

}

</style>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Laporan</h2>

        <small style="color:#94a3b8;">
            Pilih jenis laporan yang ingin ditampilkan
        </small>

    </div>

</div>

<div class="cards">

    <a
        href="{{ route('laporan-material-utama') }}"
        class="card-box"
    >

        <h3>📦 Material Utama</h3>

        <p>
            Laporan stok kain dan material utama
        </p>

    </a>

    <a
        href="{{ route('laporan-material-pendukung') }}"
        class="card-box"
    >

        <h3>📦 Material Pendukung</h3>

        <p>
            Laporan stok aksesoris dan material pendukung
        </p>

    </a>

</div>

@endsection