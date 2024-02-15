@extends('tablar::page')
@section('title')
    @lang('Dashboard')
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col text-center">
                    <h2 class="page-title">
                        Policía Nacional del Ecuador Sub Zona 7 Loja
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <!-- Carousel -->
            <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="assets/escudo.png" class="d-block mx-auto" style="width: 200px;"
                            alt="Imagen 1">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/escudo.png" class="d-block mx-auto" style="width: 200px;"
                            alt="Imagen 2">
                    </div>
                    <div class="carousel-item">
                        <img src="assets/escudo.png" class="d-block mx-auto" style="width: 200px;"
                            alt="Imagen 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <!-- Message -->
            <div class="row mt-5">
                <div class="col text-center">
                    <p>Policia Nacional del Ecuador - Loja Sub Zona 7 le da la bienvenida</p>
                </div>
            </div>
        </div>
    </div>
@endsection
