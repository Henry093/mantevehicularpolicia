@extends('tablar::page')

@section('title', __('Report'))

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        @lang('List')
                    </div>
                    <h2 class="page-title">
                        Reportes Polía Nacional Sub Zona 7 - Loja
                    </h2>
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
                            <h3 class="card-title">Reportes</h3>
                        </div>

                        <div class="card-body border-bottom py-3">
                            <div class="row">
                                <form id="exportForm" action="{{ route('reportes.export') }}" method="POST" class="text-end" >
                                    @csrf
                                    <input type="hidden" name="view" value="{{ $view }}">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <button type="button" class="btn btn-secondary" onclick="exportData('pdf')">Exportar a PDF</button>
                                    <button type="button" class="btn btn-success" onclick="exportData('excel')">Exportar a Excel</button>
                                </form>
                                <script>
                                    function exportData(format) {
                                        // Cambiar el método del formulario a GET
                                        $('#exportForm').attr('method', 'GET');
                                        // Agregar un campo oculto para el formato seleccionado
                                        $('#exportForm').append('<input type="hidden" name="format" value="' + format + '">');
                                        // Enviar el formulario
                                        $('#exportForm').submit();
                                    }
                                </script>
                            </div>
                            <form action="{{ route('reportes.index') }}" method="GET">
                                <div class="form-group mb-3">                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="view">Seleccionar Categoría:</label>
                                            <select name="view" id="view" class="form-select" onchange="this.form.submit()">
                                                <option value="default" {{ !$view || $view == 'default' ? 'selected' : '' }}>Dependencias</option>
                                                <option value="personas" {{ $view == 'personas' ? 'selected' : '' }}>Personal</option>
                                                <option value="vehiculos" {{ $view == 'vehiculos' ? 'selected' : '' }}>Flota Vehicular</option>
                                                <option value="mantenimientos" {{ $view == 'mantenimientos' ? 'selected' : '' }}>Registro de Mantenimientos</option>
                                                <option value="recepciones" {{ $view == 'recepciones' ? 'selected' : '' }}>Recepción de Vehículos</option>
                                                <option value="entregas" {{ $view == 'entregas' ? 'selected' : '' }}>Entrega de Vehículos</option>
                                                <option value="subcircuitos" {{ $view == 'subcircuitos' ? 'selected' : '' }}>Subcircuitos</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <label for="view"></label>
                                            <div class="d-flex">
                                                <div class="ms-auto text-muted">
                                                    @lang('Search:')
                                                    <div class="ms-2 d-inline-block">
                                                        <form action="{{ route('subcircuitos.index') }}" method="GET" class="form-inline">
                                                            <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        @if($view == 'personas')
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-sm text-dark icon-thick" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <polyline points="6 15 12 9 18 15"/>
                                            </svg>
                                        </th>
                                        <th>Nombre</th>
                                        <th>Cédula</th>
                                        <th>Tipo de Sangre</th>
                                        <th>Ciudad de Nacimiento</th>
                                        <th>Fecha de Nacimiento</th>
                                        <th>Teléfono</th>
                                        <th>Grado</th>
                                        <th>Rango</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->name }} {{ $item->lastname }}</td>
                                            <td>{{ $item->cedula }}</td>
                                            <td>{{ $item->sangre->nombre }}</td>
                                            <td>{{ $item->parroquia->nombre }}</td>
                                            <td>{{ $item->fecha_nacimiento }}</td>
                                            <td>{{ $item->telefono }}</td>
                                            <td>{{ $item->grado->nombre }}</td>
                                            <td>{{ $item->rango->nombre }}</td>
                                            <td>{{ $item->estado->nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $data->links('tablar::pagination') !!}
                        </div>
                        @elseif($view == 'vehiculos')
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-sm text-dark icon-thick" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <polyline points="6 15 12 9 18 15"/>
                                            </svg>
                                        </th>
                                        <th>Tipo de Vehículo</th>
                                        <th>Placa</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Kilometraje</th>
                                        <th>Capacidad de Carga</th>
                                        <th>Capacidad de Pasajeros</th>
                                        <th>Estado</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->tvehiculo->nombre }}</td>
                                            <td>{{ $item->placa }}</td>
                                            <td>{{ $item->marca->nombre }}</td>
                                            <td>{{ $item->modelo->nombre }}</td>
                                            <td>{{ $item->kilometraje }}</td>
                                            <td>{{ $item->vcarga->nombre }}</td>
                                            <td>{{ $item->vpasajero->nombre }}</td>
                                            <td>{{ $item->estado->nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $data->links('tablar::pagination') !!}
                        </div>
                        @elseif($view == 'mantenimientos')
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-sm text-dark icon-thick" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <polyline points="6 15 12 9 18 15"/>
                                            </svg>
                                        </th>
                                        <th>Orden Mantenimiento</th>
                                        <th>Persona Asignada</th>
                                        <th>Placa</th>
                                        <th>Fecha Solicitud</th>
                                        <th>Hora Solicitud</th>
                                        <th>Kilometraje</th>
                                        <th>Observaciones</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->orden }}</td>
                                            <td>{{ $item->user->name }} {{ $item->user->lastname }}</td>
                                            <td>{{ $item->vehiculo->placa }}</td>
                                            <td>{{ $item->fecha }}</td>
                                            <td>{{ $item->hora }}</td>
                                            <td>{{ $item->kilometraje }}</td>
                                            <td>{{ $item->observaciones }}</td>
                                            <td>{{ $item->mantestado->nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $data->links('tablar::pagination') !!}
                        </div>
                        @elseif($view == 'recepciones')
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select all invoices"></th>
                                        <th class="w-1">No.
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-sm text-dark icon-thick" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <polyline points="6 15 12 9 18 15"/>
                                            </svg>
                                        </th>
                                        <th>Orden Mantenimiento</th>
                                        <th>Fecha Ingreso</th>
                                        <th>Hora Ingreso</th>
                                        <th>Kilometraje Ingreso</th>
                                        <th>Asunto</th>
                                        <th>Detalle</th>
                                        <th>Tipo Mantenimiento</th>
                                        <th>Estado</th>
                                        <th class="w-1"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                    aria-label="Select subcircuito"></td>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->mantenimientos_id }}</td>
                                            <td>{{ $item->fecha_ingreso }}</td>
                                            <td>{{ $item->hora_ingreso }}</td>
                                            <td>{{ $item->kilometraje }}</td>
                                            <td>{{ $item->asunto }}</td>
                                            <td>{{ $item->detalle }}</td>
                                            <td>{{ $item->mantetipo->nombre }}</td>
                                            <td>{{ $item->mantenimiento->mantestado->nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $data->links('tablar::pagination') !!}
                        </div>
                        @elseif($view == 'entregas')
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-sm text-dark icon-thick" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <polyline points="6 15 12 9 18 15"/>
                                            </svg>
                                        </th>
                                        <th>Orden Mantenimiento</th>
                                        <th>Fecha Entrega</th>
                                        <th>Persona Retiro</th>
                                        <th>KM Actual</th>
                                        <th>KM Próximo</th>
                                        <th>Observaciones</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->vehirecepciones_id }}</td>
                                            <td>{{ $item->fecha_entrega }}</td>
                                            <td>{{ $item->p_retiro }}</td>
                                            <td>{{ $item->km_actual }}</td>
                                            <td>{{ $item->km_proximo }}</td>
                                            <td>{{ $item->observaciones }}</td>
                                            <td>{{ $item->vehirecepcione->mantenimiento->mantestado->nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $data->links('tablar::pagination') !!}
                        </div>
                        @elseif($view == 'subcircuitos')
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-sm text-dark icon-thick" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <polyline points="6 15 12 9 18 15"/>
                                            </svg>
                                        </th>
                                        <th>Provincia</th>
                                        <th>Cantón</th>
                                        <th>Parroquia</th>
                                        <th>Distrito</th>
                                        <th>Circuito</th>
                                        <th>Subcircuito</th>
                                        <th>Cod. Subcircuito</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->provincia->nombre }}</td>
                                            <td>{{ $item->canton->nombre }}</td>
                                            <td>{{ $item->parroquia->nombre }}</td>
                                            <td>{{ $item->distrito->nombre }}</td>
                                            <td>{{ $item->circuito->nombre }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->estado->nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $data->links('tablar::pagination') !!}
                        </div>
                        @else
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th class="w-1">No.
                                            <!-- Download SVG icon from http://tabler-icons.io/i/chevron-up -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-sm text-dark icon-thick" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <polyline points="6 15 12 9 18 15"/>
                                            </svg>
                                        </th>
                                        <th>Provincia</th>
                                        <th>Cantón</th>
                                        <th>Parroquia</th>
                                        <th>Distrito</th>
                                        <th>Cod. Distrito</th>
                                        <th>Circuito</th>
                                        <th>Cod. Circuito</th>
                                        <th>Subcircuito</th>
                                        <th>Cod. Subcircuito</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $item)
                                        <tr>
                                            <td>{{ ++$loop->index }}</td>
                                            <td>{{ $item->provincia->nombre }}</td>
                                            <td>{{ $item->canton->nombre }}</td>
                                            <td>{{ $item->parroquia->nombre }}</td>
                                            <td>{{ $item->distrito->nombre }}</td>
                                            <td>{{ $item->distrito->codigo }}</td>
                                            <td>{{ $item->circuito->nombre }}</td>
                                            <td>{{ $item->circuito->codigo }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->codigo }}</td>
                                            <td>{{ $item->estado->nombre }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10">@lang('No Data Found')</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $data->links('tablar::pagination') !!}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection