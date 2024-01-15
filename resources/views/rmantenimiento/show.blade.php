@extends('tablar::page')

@section('title', __('validation.View Rmantenimiento'))

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            @if(config('tablar','display_alert'))
                @include('tablar::common.alert')
            @endif
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        @lang('View')
                    </div>
                    <h2 class="page-title">
                        {{ __('Rmantenimiento') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('rmantenimientos.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Rmantenimiento List')
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Rmantenimiento Details')</h3>
                        </div>
                        <div class="card-body">
                            
<div class="form-group">
<strong>Placa:</strong>
{{ $rmantenimiento->vsubcircuito->vehiculo->placa }}
</div>
<div class="form-group">
<strong>Fecha Inicio:</strong>
{{ $rmantenimiento->fecha_inicio }}
</div>
<div class="form-group">
<strong>Hora:</strong>
{{ $rmantenimiento->hora }}
</div>
<div class="form-group">
<strong>Kilometraje:</strong>
{{ $rmantenimiento->kilometraje }}
</div>
<div class="form-group">
<strong>Observación:</strong>
{{ $rmantenimiento->observacion }}
</div>
<div class="form-group">
<strong>Estado Mantenimiento:</strong>
{{ $rmantenimiento->emantenimiento->nombre }}
</div>

                        </div>
                    </div>
                </div>
                <div class="form-footer">
                    <div class="text-end">
                            <div class="col-12 col-md-auto ms-auto d-print-none">
                                <div class="btn-list">
                                    <a href="{{--{{ route('entregavehiculos.pdf')}} --}}" class="btn btn-primary d-none d-sm-inline-block" target="_blank">
                                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <line x1="12" y1="5" x2="12" y2="19"/>
                                            <line x1="5" y1="12" x2="19" y2="12"/>
                                        </svg>
                                        @lang('Download PDF')
                                    </a>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


