@extends('tablar::page')

@section('title', __('validation.View Vehirecepcione'))

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
                        {{ __('Vehirecepcione') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('vehirecepciones.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Vehirecepcione List')
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
                            <h3 class="card-title">@lang('Vehirecepcione Details')</h3>
                        </div>
                        <div class="card-body">
                            
<div class="form-group">
<strong>Orden:</strong>
{{ $vehirecepcione->mantenimiento->orden }}
</div>
                            
<div class="form-group">
<strong>Orden:</strong>
{{ $vehirecepcione->mantenimiento->vehiculo->placa }}
</div>
<div class="form-group">
<strong>Fecha Ingreso:</strong>
{{ $vehirecepcione->fecha_ingreso }}
</div>
<div class="form-group">
<strong>Hora Ingreso:</strong>
{{ $vehirecepcione->hora_ingreso }}
</div>
<div class="form-group">
<strong>Kilometraje:</strong>
{{ $vehirecepcione->kilometraje }}
</div>
<div class="form-group">
<strong>Asunto:</strong>
{{ $vehirecepcione->asunto }}
</div>
<div class="form-group">
<strong>Detalle:</strong>
{{ $vehirecepcione->detalle }}
</div>
<div class="form-group">
<strong>Tipo Mantenimiento:</strong>
{{ $vehirecepcione->mantetipo->nombre }}
</div>
<div class="form-group">
<strong>Detalle Mantenimiento:</strong>
{{ $vehirecepcione->mantetipo->descripcion }}
</div>
<div class="form-group">
<strong>Detalle Mantenimiento: </strong>
{{ $vehirecepcione->mantetipo->valor }} $
</div>
<div class="form-group">
    <strong>Parte Policial:</strong><br>
    <a href="{{ asset($vehirecepcione->imagen) }}" target="_blank"> 
        <!-- Abrir la imagen en una nueva pestaña -->
        <img src="{{ asset($vehirecepcione->imagen) }}" alt="Parte Policial" style="max-width: 100px; max-height: 100px;">
    </a>
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


