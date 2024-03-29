@extends('tablar::page')

@section('title')
@lang('Vehiculo')
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
                        {{ __('Vehiculo') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('vehiculos.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Create Vehiculo')
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
                            <h3 class="card-title">@lang('Vehiculo')</h3>
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
                                        <form action="{{ route('vehiculos.index') }}" method="GET" class="form-inline">
                                            <input type="text" name="search" class="form-control form-control-sm" value="{{ request('search') }}">
                                        </form>
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
                                    
										<th>Tipo</th>
										<th>Placa</th>
										<th>Chasis</th>
										<th>Marca</th>
										<th>Modelo</th>
										<th>Motor</th>
										<th>Kilometraje</th>
										<th>Cilindraje</th>
										<th>Cap. Carga</th>
										<th>Cap. Pasajero</th>
										<th>Estado</th>

                                    <th class="w-1"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($vehiculos as $vehiculo)
                                    <tr>
                                        <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                   aria-label="Select vehiculo"></td>
                                        <td>{{ ++$i }}</td>
                                        
											<td>{{ $vehiculo->tvehiculo->nombre }}</td>
											<td>{{ $vehiculo->placa }}</td>
											<td>{{ $vehiculo->chasis }}</td>
											<td>{{ $vehiculo->marca->nombre }}</td>
											<td>{{ $vehiculo->modelo->nombre }}</td>
											<td>{{ $vehiculo->motor }}</td>
											<td>{{ $vehiculo->kilometraje }}</td>
											<td>{{ $vehiculo->cilindraje }}</td>
											<td>{{ $vehiculo->vcarga->nombre }}</td>
											<td>{{ $vehiculo->vpasajero->nombre }}</td>
											<td>{{ $vehiculo->estado->nombre }}</td>

                                        <td>
                                            <div class="btn-list flex-nowrap">
                                                <div class="dropdown">
                                                    <button class="btn dropdown-toggle align-text-top"
                                                            data-bs-toggle="dropdown">
                                                            @lang('Actions')
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                           href="{{ route('vehiculos.show',$vehiculo->id) }}">
                                                           @lang('View')
                                                        </a>
                                                        <a class="dropdown-item"
                                                           href="{{ route('vehiculos.edit',$vehiculo->id) }}">
                                                           @lang('Edit')
                                                        </a>
                                                        <!-- Botón Delete que abre el modal -->
                                                        <button type="button" class="dropdown-item text-red" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $vehiculo->id }}">
                                                            @lang('Delete')
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Modal de Confirmación de Eliminación -->
                                            <div class="modal fade" id="deleteModal{{ $vehiculo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">@lang('Confirm Delete')</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('vehiculos.destroy',$vehiculo->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="mb-3">
                                                                    <label for="motivo" class="form-label">@lang('Motivo de Eliminación')</label>
                                                                    <input type="text" class="form-control" id="motivo" name="motivo" required>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">@lang('Cancel')</button>
                                                                    <button type="submit" class="btn btn-danger ms-auto" data-bs-dismiss="modal">@lang('Confirm')</button>
                                                                </div>
                                                            </form>
                                                        </div>
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
                            {!! $vehiculos->links('tablar::pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
