@extends('layout.app')

@section('content')

<div class="container">

    <h2>
        Komponen Produk
    </h2>

    <h3>
        {{ $produk->nama }}
    </h3>

    <table class="table">

        <thead>

        <tr>

            <th>No</th>

            <th>Komponen</th>

        </tr>

        </thead>

        <tbody>

        @foreach($komponen as $k)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td>
                {{ $k->nama_komponen }}
            </td>

        </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection