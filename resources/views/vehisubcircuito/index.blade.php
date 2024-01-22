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
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('vehisubcircuitos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Create Vehisubcircuito')
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
                            <h3 class="card-title">@lang('Vehisubcircuito')</h3>
                        </div>
                        <div class="card-body border-bottom py-3">
                            <div class="d-flex">
                                <div class="text-muted">
                                    @lang('Show')
                                    <div class="mx-2 d-inline-block">
                                        <input type="text" class="form-control form-control-sm" value="10" size="3"
                                               aria-label="Invoices count">
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
                                    
										<th>Placa</th>
										<th>Tipo Vehículo</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Capacidad Carga</th>
										<th>Capacidad Pasajeros</th>
										<th>Subcircuito</th>
										<th>Asignación</th>

                                    <th class="w-1"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($vehisubcircuitos as $vehisubcircuito)
                                    <tr>
                                        <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                   aria-label="Select vehisubcircuito"></td>
                                        <td>{{ ++$i }}</td>
                                        
											<td>{{ $vehisubcircuito->vehiculo->placa }}</td>
											<td>{{ $vehisubcircuito->vehiculo->tvehiculo->nombre }}</td>
											<td>{{ $vehisubcircuito->vehiculo->marca->nombre }}</td>
											<td>{{ $vehisubcircuito->vehiculo->modelo->nombre }}</td>
											<td>{{ $vehisubcircuito->vehiculo->vcarga->nombre }}</td>
											<td>{{ $vehisubcircuito->vehiculo->vpasajero->nombre }}</td>
                                            <td>
                                                @if ($vehisubcircuito->subcircuito)
                                                    {{ $vehisubcircuito->subcircuito->nombre }}
                                                @else
                                                    No Asignado
                                                @endif
                                            </td>
                                            <td
                                                style="{{ $vehisubcircuito->asignacion->nombre == 'No Asignado' ? 'color: red;' :
                                                 ($vehisubcircuito->asignacion->nombre == 'Asignado' ? 'color: green;' : '') }}">
                                                {{ $vehisubcircuito->asignacion->nombre }}
                                                @if ($vehisubcircuito->asignacion->nombre == 'Asignado')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                @elseif ($vehisubcircuito->asignacion->nombre == 'No Asignado')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-x" width="24" height="24"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                @endif
                                            </td>

                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-toggle="dropdown">
                                                        @lang('Actions')
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                           href="{{ route('vehisubcircuitos.show',$vehisubcircuito->id) }}">
                                                           @lang('View')
                                                        </a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('vehisubcircuitos.edit',$vehisubcircuito->id) }}">
                                                           @lang('Edit')
                                                        </a>
                                                        <form
                                                            action="{{ route('vehisubcircuitos.destroy',$vehisubcircuito->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    onclick="if(!confirm('Do you Want to Proceed?')){return false;}"
                                                                    class="dropdown-item text-red"><i
                                                                    class="fa fa-fw fa-trash"></i>
                                                                    @lang('Delete')
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <td>@lang('No Data Found')</td>
                                @endforelse
                                </tbody>

                            </table>
                        </div>
                       <div class="card-footer d-flex align-items-center">
                            {!! $vehisubcircuitos->links('tablar::pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
