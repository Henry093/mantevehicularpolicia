@extends('tablar::page')

@section('title', 'Create Treclamo')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Registro
                    </div>
                    <h2 class="page-title">
                        {{ __('Registro Reclamos') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            @if (config('tablar', 'display_alert'))
                @include('tablar::common.alert')
            @endif
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <form method="GET" action="/filtro">
                            <div class="card-body border-bottom py-3">
                                <div class="d-flex">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-5">
                                                <p>Fecha Inicio</p>
                                                <input required class="form-control" type="date" name="fechaIni">
                                            </div>
                                            <div class="col-5">
                                                <p>Fecha Fin</p>
                                                <input required class="form-control" type="date" name="fechaFin">
                                            </div>
                                            <div class="col-2">
                                                <br>
                                                <p></p>
                                                <button class="btn btn-primary" type="submit">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th># Total</th>
                                        <th>Circuito</th>
                                        <th>Subcircuito</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($reclamos as $reclamo)
                                        <tr>
                                            <tr>
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $reclamo->treclamo->nombre }}</td>
                                                <td>{{ $reclamo->total }}</td>
                                                <td>{{ $reclamo->circuito->nombre }}</td>
                                                <td>{{ $reclamo->subcircuito->nombre }}</td>
                                            </tr>
                                        </tr>
                                    @empty
                                        <td>@lang('No Data Found')</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $reclamos->links('tablar::pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
