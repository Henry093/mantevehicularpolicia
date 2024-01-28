@extends('tablar::page')

@section('title')
    @lang('Vehisubcircuito')
@endsection

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
                        {{ __('Vehisubcircuito') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            @if (config('tablar', 'display_alert'))
                @include('tablar::common.alert')
            @endif
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Vehisubcircuito')</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    @lang('Show')
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" value="10"
                                            size="3" aria-label="Invoices count">
                                    </div>
                                    @lang('entries')
                                </div>
                                <div class="ms-auto text-muted">
                                    @lang('Search:')
                                    <div class="ms-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm"
                                            aria-label="Search invoice">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive min-vh-100">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>

                                        <th>Placa</th>
                                        <th>Tipo Vehículo</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Subcircuito</th>
                                        <th>Usuario 1</th>
                                        <th>Usuario 2</th>
                                        <th>Usuario 3</th>
                                        <th>Usuario 4</th>

                                        <th class="w-1"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($d_vehiculo as $vehisubcircuito)
                                        <tr>
                                            

                                            <td>{{ $vehisubcircuito->vehiculo->placa }}</td>
                                            <td>{{ $vehisubcircuito->vehiculo->tvehiculo->nombre }}</td>
                                            <td>{{ $vehisubcircuito->vehiculo->marca->nombre }}</td>
                                            <td>{{ $vehisubcircuito->vehiculo->modelo->nombre }}</td>
                                            <td>
                                                @if ($vehisubcircuito->subcircuito)
                                                    {{ $vehisubcircuito->subcircuito->nombre }}
                                                @else
                                                    No Asignado
                                                @endif
                                            </td>
                                            
                                            @if ($vehisubcircuito->asignar)
                                                @foreach ($vehisubcircuito->asignar->take(4) as $index => $asignar)
                                                    <td>{{ $asignar->user->name }} {{ $asignar->user->lastname }}</td>
                                                @endforeach
                                                <!-- Si hay menos de 4 usuarios asignados, completar las celdas restantes -->
                                                @for ($i = count($vehisubcircuito->asignar); $i < 4; $i++)
                                                    <td style="color: red;">No Asignado</td>
                                                @endfor
                                            @else
                                                <!-- Si no hay usuarios asignados, completar todas las celdas -->
                                                @for ($i = 0; $i < 4; $i++)
                                                    <td style="color: red;">No Asignado</td>
                                                @endfor
                                            @endif 

                                            <td>
                                                <button type="button" class="btn btn-pill" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $vehisubcircuito->id }}">
                                                    Asignar 
                                                </button>
                                                <button type="button" class="btn btn-pill" data-bs-toggle="modal" data-bs-target="#desasignarModal{{ $vehisubcircuito->id }}">
                                                    Desasignar
                                                </button>
                                            </td>
                                        <div class="modal" id="exampleModal{{ $vehisubcircuito->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Asignar Personal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="page-body">
                                                            <div class="container-xl">
                                                                <div class="row row-deck row-cards">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">@lang('Vehisubcircuito Details')</h3>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <div class="form-group">
                                                                                    <strong>Placa del Vehículo:</strong>
                                                                                    {{ $vehisubcircuito->vehiculo->id }}
                                                                                </div>
                                                                                    <div class="form-group">
                                                                                        <strong>Placa del Vehículo:</strong>
                                                                                        {{ $vehisubcircuito->vehiculo->placa }}
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <strong>Tipo Vehículo:</strong>
                                                                                        {{ $vehisubcircuito->vehiculo->tvehiculo->nombre }}
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <strong>Marca:</strong>
                                                                                        {{ $vehisubcircuito->vehiculo->marca->nombre }}
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <strong>Modelo:</strong>
                                                                                        {{ $vehisubcircuito->vehiculo->modelo->nombre }}
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <strong>Distrito:</strong>
                                                                                        {{ $vehisubcircuito->distrito ? $vehisubcircuito->distrito->nombre : 'No Asignado'}}
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <strong>Subcircuito:</strong>
                                                                                        {{ $vehisubcircuito->subcircuito ? $vehisubcircuito->subcircuito->nombre : 'No Asignado'}}
                                                                                    </div>
                                    
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                                <div class="row row-deck row-cards">
                                                                    <div class="col-12">
                                                                        <div class="card">
                                                                            <div class="card-header">
                                                                                <h3 class="card-title">Seleccionar Usuarios</h3>
                                                                            </div>
                                                                            <div class="card-body">
                                                                                <form action="{{ route('asignarvehiculos.store') }}" method="post">
                                                                                    @csrf
                                                                                    <input type="hidden" name="vehisubcircuito_id" value="{{ $vehisubcircuito->id }}">
                                                                                    <h4>Seleccionar Usuarios (hasta 4):</h4>
                                                                                    @php $count = 0; @endphp
                                                                                    @foreach($d_user as $usuario)
                                                                                    @php
                                                                                        // Verificar si el usuario ya está asignado a otro vehículo en el mismo subcircuito
                                                                                        $usuarioAsignado = DB::table('asignarvehiculos')
                                                                                            ->where('user_id', $usuario->user_id)
                                                                                            ->join('vehisubcircuitos', 'asignarvehiculos.vehisubcircuito_id', '=', 'vehisubcircuitos.id')
                                                                                            ->where('vehisubcircuitos.subcircuito_id', $vehisubcircuito->subcircuito->id)
                                                                                            ->exists();
                                                                                    @endphp
                                                                                
                                                                                    @if (!$usuarioAsignado && $count < 4 && $usuario->subcircuito && $usuario->subcircuito_id == $vehisubcircuito->subcircuito->id)
                                                                                        <li>
                                                                                            <label>
                                                                                                <input type="checkbox" name="usuarios[]" value="{{ $usuario->id }}">
                                                                                                {{ $usuario->user_id }} {{ $usuario->user->name }} {{ $usuario->user->lastname }}
                                                                                            </label>
                                                                                        </li>
                                                                                        @php $count++; @endphp
                                                                                    @endif
                                                                                @endforeach
                                                                                
                                                                                @if ($count == 0)
                                                                                    <li>No hay usuarios registrados en el mismo subcircuito.</li>
                                                                                @endif
                                                                                    
                                                                                    <button type="submit" class="btn btn-primary" style="float: right;">Guardar Asignación</button>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal" id="desasignarModal{{ $vehisubcircuito->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Desasignar Personal</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="page-body">
                                                            <div class="row row-deck row-cards">
                                                                <div class="col-12">
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h3 class="card-title">Desasignar Usuarios</h3>
                                                                        </div>
                                                                        <!-- Sección Desasignar Usuarios -->
                                                                        <div class="card-body">
                                                                            <form action="{{ route('asignarvehiculos.destroy', $vehisubcircuito->id) }}" method="post">
                                                                                @csrf
                                                                                @method('DELETE')
                                                                                <h4>Usuarios Asignados:</h4>
                                                                                <ul>
                                                                                    @forelse($vehisubcircuito->asignar as $asignacion)
                                                                                        <li>
                                                                                            <input type="hidden" name="asignacion_ids[]" value="{{ $asignacion->id }}">
                                                                                            <label>
                                                                                                <input type="checkbox" name="usuarios[]" value="{{ $asignacion->user->id }}" checked>
                                                                                                {{ $asignacion->user_id }} {{ $asignacion->user->name }} {{ $asignacion->user->lastname }}
                                                                                            </label>
                                                                                        </li>
                                                                                    @empty
                                                                                        <p>No hay usuarios asignados a este vehículo.</p>
                                                                                    @endforelse
                                                                                </ul>
                                                                                
                                                                                <button type="submit" class="btn btn-primary">Desasignar Usuarios</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </tr>
                                    @empty
                                        <td>@lang('No Data Found')</td>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex align-items-center">
                            {!! $d_vehiculo->links('tablar::pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
