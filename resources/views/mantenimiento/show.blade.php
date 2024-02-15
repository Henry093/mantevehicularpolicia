@extends('tablar::page')

@section('title', __('validation.View Mantenimiento'))

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        @lang('View')
                    </div>
                    <h2 class="page-title">
                        {{ __('Mantenimiento') }}
                    </h2>
                </div>

                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('mantenimientos.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Mantenimiento List')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
                    
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">        
            @if(config('tablar','display_alert'))
            @include('tablar::common.alert')
            @endif
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Mantenimiento Details')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group text-center">
                                <h1>Parte Policial</h1>
                            </div>
                            <div class="form-group text-center">
                                <h3>Orden # {{ $mantenimiento->orden }}</h3>
                            </div>
<div class="form-group">
<strong>Nombre:</strong>
{{ $mantenimiento->user->name }} {{ $mantenimiento->user->lastname }}
</div>
<div class="form-group">
<strong>Vehiculo:</strong>
{{ $mantenimiento->vehiculo->placa }}
</div>
<div class="form-group">
<strong>Fecha Inicio:</strong>
{{ $mantenimiento->fecha }}
</div>
<div class="form-group">
<strong>Hora Inicio:</strong>
{{ $mantenimiento->hora }}
</div>
<div class="form-group">
<strong>Kilometraje:</strong>
{{ $mantenimiento->kilometraje }}
</div>
<div class="form-group">
<strong>Observaciones:</strong>
{{ $mantenimiento->observaciones }}
</div>
<div class="form-group">
<strong>Estado Mantenimiento:</strong>
{{ $mantenimiento->mantestado->nombre }}
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    
    <!-- Agregar los botones aquí -->
    <div class="d-flex justify-content-center mt-5">
        <a href="{{ route('mantenimientos.index') }}" class="btn btn-primary me-3">
            @lang('Return')
        </a>
        <a href="{{ route('mantenimientos.pdf', ['id' => $mantenimiento->id]) }}" class="btn btn-success me-3" target="_blank">
            @lang('Imprimir PDF')
        </a>
        <button type="button" class="btn btn-secondary" onclick="window.print();">
            @lang('Print')
        </button>
    </div>
@endsection


