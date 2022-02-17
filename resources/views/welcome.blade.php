@extends('layouts.app')

@section('content')

<div>

    <div id="home-header">
        <div class="text-center">
            <h1>Ongi etorri Zimmer-era!</h1>
        </div>
        <busqueda></busqueda>
    </div>

    <div class="container text-center mx-auto my-5" id="prb">
        <h2>Probintzia</h2>
    </div>
    <div class="destinations container d-flex justify-content-around flex-wrap my-5">
        <div>
            <span class="text-center mb-2 d-block fw-bold">Araba</span>
            <a href="/hoteles?probintzia=araba">
                <img src="img/gasteiz.jpg" width="300px" class="shadow-sm">
            </a>
        </div>
        <div>
            <span class="text-center mb-2 d-block fw-bold">Bizkaia</span>
            <a href="/hoteles?probintzia=bizkaia">
                <img src="img/bilbo.jpg" width="300px" class="shadow-sm">
            </a>
        </div>
        <div>
            <span class="text-center mb-2 d-block fw-bold">Gipuzkoa</span>
            <a href="/hoteles?probintzia=gipuzkoa">
                <img src="img/donosti.jpg" width="300px" class="shadow-sm">
            </a>
        </div>
    </div>

    <div class="container text-center mx-auto" id="mota">
        <h2>Ostatze mota</h2>
    </div>

    <div class="motak container d-flex justify-content-around flex-wrap my-5" id="motak">
        <div>
            <span class="text-center mb-2 d-block fw-bold">Hotel</span>
            <a href="/hoteles?mota=Hoteles">
                <img src="img/hotel.jpg" width="300px" class="shadow-sm">
            </a>
        </div>
        <div>
            <span class="text-center mb-2 d-block fw-bold">Apartamento</span>
            <a href="/hoteles?mota=Apartamentos">
                <img src="img/APARTAMENTO.jpg" width="300px" class="shadow-sm">
            </a>
        </div>
        <div>
            <span class="text-center mb-2 d-block fw-bold">Apartahotel</span>
            <a href="/hoteles?mota=Hotel-Apartamento">
                <img src="img/apartahotel.jpg" width="300px" class="shadow-sm">
            </a>
        </div>
        <div>
            <span class="text-center mb-2 d-block fw-bold">Pension</span>
            <a href="/hoteles?mota=Pensiones">
                <img src="img/pennsion.jpg" width="300px" class="shadow-sm">
            </a>
        </div>
    </div>

</div>

@endsection
