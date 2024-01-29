@extends('tablar::page')

@section('title', __('validation.View Vehiregistro'))

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
                        {{ __('Vehiregistro') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('vehiregistros.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Vehiregistro List')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    @if(config('tablar','display_alert'))
                        @include('tablar::common.alert')
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Vehiregistro Details')</h3>
                        </div>
                        <div class="card-body">
                            
<div class="form-group">
<strong>Placa:</strong>
{{ $vehiregistro->mantenimiento->vehiculo->placa }}
</div>
<div class="form-group">
<strong>Fecha Ingreso:</strong>
{{ $vehiregistro->fecha_ingreso }}
</div>
<div class="form-group">
<strong>Hora Ingreso:</strong>
{{ $vehiregistro->hora_ingreso }}
</div>
<div class="form-group">
<strong>Kilometraje:</strong>
{{ $vehiregistro->kilometraje }}
</div>
<div class="form-group">
<strong>Asunto:</strong>
{{ $vehiregistro->asunto }}
</div>
<div class="form-group">
<strong>Detalle:</strong>
{{ $vehiregistro->detalle }}
</div>
<div class="form-group">
<strong>Tipo Mantenimiento:</strong>
{{ $vehiregistro->mantetipo->nombre }}
</div>
<div class="form-group">
<strong>Detalle Mantenimiento:</strong>
{{ $vehiregistro->mantetipo->descripcion }}
</div>
<div class="form-group">
<strong>Valor Mantenimiento:</strong>
{{ $vehiregistro->mantetipo->valor }}
</div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-center mt-5">
        <a href="{{ route('mantenimientos.create') }}" class="btn btn-primary me-3">
            @lang('Return')
        </a>
        <button type="button" class="btn btn-secondary" onclick="window.print();">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
             stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M8 7h11a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-3l-3 3v-11a2 2 0 0 1 2 -2z"/>
            <path d="M8 11v-4a4 4 0 0 1 8 0v4"/>
        </svg>
            @lang('Print')
        </button>
    </div>

@endsection


