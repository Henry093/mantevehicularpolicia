@extends('tablar::page')

@section('title')
    @lang('Dependencia')
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
                        {{ __('Dependencia') }}
                    </h2>
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
                            <h3 class="card-title">@lang('Dependencia')</h3>
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
										<th>Acciones</th>

                                    <th class="w-1"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($dependencias as $dependencia)
                                    <tr>
                                        <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                   aria-label="Select dependencia"></td>
                                        <td>{{ ++$i }}</td>
                                        
											<td>{{ $dependencia->provincia->nombre }}</td>
											<td>{{ $dependencia->canton->nombre }}</td>
											<td>{{ $dependencia->parroquia->nombre }}</td>
											<td>{{ $dependencia->distrito->nombre }}</td>
											<td>{{ $dependencia->distrito->codigo }}</td>
											<td>{{ $dependencia->circuito->nombre }}</td>
											<td>{{ $dependencia->circuito->codigo }}</td>
											<td>{{ $dependencia->nombre }}</td>
											<td>{{ $dependencia->codigo }}</td>
											<td>{{ $dependencia->estado->nombre }}</td>
                                            <td>
                                                <a  href="{{ route('dependencias.show', $dependencia->id) }}" class="btn btn-pill">@lang('View Dependencia')</a>
                                            </td>

                                        <td>
                                    </tr>
                                @empty
                                    <td>@lang('No Data Found')</td>
                                @endforelse
                                </tbody>

                            </table>
                        </div>
                       <div class="card-footer d-flex align-items-center">
                            {!! $dependencias->links('tablar::pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
