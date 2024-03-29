@extends('tablar::page')

@section('title', __('validation.View Vehientrega'))

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
                        {{ __('Vehientrega') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('vehientregas.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Vehientrega List')
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
                            <h3 class="card-title">@lang('Vehientrega Details')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group text-center">
                                <h1>Informe de Mantenimiento</h1>
                            </div>
                            <div class="form-group text-center">
                                <h3>Orden # {{ $vehientrega->vehirecepcione->mantenimiento->orden }} </h3>
                            </div>                        
<div class="form-group">
<strong>Tipo Vehículo:</strong>
{{ $vehientrega->vehirecepcione->mantenimiento->vehiculo->tvehiculo->nombre }}
</div>
<div class="form-group">
<strong>Marca:</strong>
{{ $vehientrega->vehirecepcione->mantenimiento->vehiculo->marca->nombre }}
</div>
<div class="form-group">
<strong>Modelo:</strong>
{{ $vehientrega->vehirecepcione->mantenimiento->vehiculo->modelo->nombre }}
</div>
<div class="form-group">
<strong>Fecha Solicitud:</strong>
{{ $vehientrega->vehirecepcione->mantenimiento->fecha }}
</div>
<div class="form-group">
<strong>Fecha Registro:</strong>
{{ $vehientrega->vehirecepcione->fecha_ingreso }}
</div>
<div class="form-group">
<strong>Fecha Entrega:</strong>
{{ $vehientrega->fecha_entrega }}
</div>
<div class="form-group">
<strong>Responsable del vehículo:</strong>
{{ $vehientrega->vehirecepcione->mantenimiento->user->name }} 
{{ $vehientrega->vehirecepcione->mantenimiento->user->lastname }}
</div>    
<div class="form-group">
<strong>Nombre de la persona que retira vehículo:</strong>
{{ $vehientrega->p_retiro }}
</div>
<div class="form-group">
<strong>Km Actual:</strong>
{{ $vehientrega->km_actual }}
</div>
<div class="form-group">
<strong>Km Proximo:</strong>
{{ $vehientrega->km_proximo }}
</div>
<div class="form-group">
<strong>Tipo de mantenimiento:</strong>
{{ $vehientrega->vehirecepcione->mantetipo->nombre }}
</div>
<div class="form-group">
<strong>Descripción del mantenimiento:</strong>
{{ $vehientrega->vehirecepcione->mantetipo->descripcion }}
</div>
<div class="form-group">
<strong>Valor del mantenimiento: </strong>
{{ $vehientrega->vehirecepcione->mantetipo->valor }} $
</div>
<div class="form-group">
<strong>Observaciones:</strong>
{{ $vehientrega->observaciones }}
</div>
<div class="form-group">
<strong>Estado mantenimiento:</strong>
{{ $vehientrega->vehirecepcione->mantenimiento->mantestado->nombre }}
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Agregar los botones aquí -->
        <div class="d-flex justify-content-center mt-5">
            <a href="{{ route('vehientregas.index') }}" class="btn btn-primary me-3">
                @lang('Return')
            </a>
            <a href="{{ route('vehientregas.pdf', ['id' => $vehientrega->id]) }}" class="btn btn-success me-3" target="_blank">
                @lang('Generar PDF')
            </a>
            <button type="button" class="btn btn-secondary" onclick="window.print();">
                @lang('Print')
            </button>
        </div>
@endsection


