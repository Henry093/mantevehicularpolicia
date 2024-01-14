@extends('tablar::page')

@section('title', 'View Evehiculo')

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        View
                    </div>
                    <h2 class="page-title">
                        {{ __('Evehiculo ') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('evehiculos.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            Evehiculo List
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
                            <h3 class="card-title">Evehiculo Details</h3>
                        </div>
                        <div class="card-body">
                            
<div class="form-group">
<strong>Rmantenimiento Id:</strong>
{{ $evehiculo->rmantenimiento_id }}
</div>
<div class="form-group">
<strong>Rvehiculo Id:</strong>
{{ $evehiculo->rvehiculo_id }}
</div>
<div class="form-group">
<strong>Fecha Entrega:</strong>
{{ $evehiculo->fecha_entrega }}
</div>
<div class="form-group">
<strong>P Retiro:</strong>
{{ $evehiculo->p_retiro }}
</div>
<div class="form-group">
<strong>Km Actual:</strong>
{{ $evehiculo->km_actual }}
</div>
<div class="form-group">
<strong>Km Proximo:</strong>
{{ $evehiculo->km_proximo }}
</div>
<div class="form-group">
<strong>Observaciones:</strong>
{{ $evehiculo->observaciones }}
</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


