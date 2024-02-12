@extends('tablar::page')

@section('title')
@lang('Vehientrega')
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
                        {{ __('Vehientrega') }}
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('vehientregas.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('Create Vehientrega')
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
                            <h3 class="card-title">@lang('Vehientrega')</h3>
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
                                    
										<th>Orden</th>
										<th>Placa</th>
										<th>Fecha Entrega</th>
										<th>Persona Retiro</th>
										<th>Km Actual</th>
										<th>Km Proximo</th>
										<th>Observaciones</th>
										<th>Estado Mantenimiento</th>

                                    <th class="w-1"></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($vehientregas as $vehientrega)
                                    <tr>
                                        <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                aria-label="Select vehientrega"></td>
                                        <td>{{ ++$i }}</td>
                                        
											<td>{{ $vehientrega->vehirecepcione->mantenimiento->orden }}</td>
											<td>{{ $vehientrega->vehirecepcione->mantenimiento->vehiculo->placa }}</td>
											<td>{{ $vehientrega->fecha_entrega }}</td>
											<td>{{ $vehientrega->p_retiro }}</td>
											<td>{{ $vehientrega->km_actual }}</td>
											<td>{{ $vehientrega->km_proximo }}</td>
											<td>{{ $vehientrega->observaciones }}</td>
                                            <td
                                                style="{{ $vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'Aceptado'
                                                    ? 'color: green;'
                                                    : ($vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'Re-Asignado'
                                                        ? 'color:red;'
                                                        : ($vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'En Proceso'
                                                            ? 'color:orange;'
                                                            : ($vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'Finalizado'
                                                                ? 'color:blue;'
                                                                : ''))) }}">
                                                {{ $vehientrega->vehirecepcione->mantenimiento->mantestado->nombre }}
                                                @if ($vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'Aceptado')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M5 12l5 5l10 -10" />
                                                    </svg>
                                                @elseif ($vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'Re-Asignado')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-checks" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 12l5 5l10 -10" />
                                                        <path d="M2 12l5 5m5 -5l5 -5" />
                                                    </svg>
                                                @elseif ($vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'En Proceso')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-progress-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M10 20.777a8.942 8.942 0 0 1 -2.48 -.969" />
                                                        <path d="M14 3.223a9.003 9.003 0 0 1 0 17.554" />
                                                        <path d="M4.579 17.093a8.961 8.961 0 0 1 -1.227 -2.592" />
                                                        <path d="M3.124 10.5c.16 -.95 .468 -1.85 .9 -2.675l.169 -.305" />
                                                        <path d="M6.907 4.579a8.954 8.954 0 0 1 3.093 -1.356" />
                                                        <path d="M9 12l2 2l4 -4" />
                                                    </svg>
                                                @elseif ($vehientrega->vehirecepcione->mantenimiento->mantestado->nombre == 'Finalizado')
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="icon icon-tabler icon-tabler-discount-check" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path
                                                            d="M5 7.2a2.2 2.2 0 0 1 2.2 -2.2h1a2.2 2.2 0 0 0 1.55 -.64l.7 -.7a2.2 2.2 0 0 1 3.12 0l.7 .7c.412 .41 .97 .64 1.55 .64h1a2.2 2.2 0 0 1 2.2 2.2v1c0 .58 .23 1.138 .64 1.55l.7 .7a2.2 2.2 0 0 1 0 3.12l-.7 .7a2.2 2.2 0 0 0 -.64 1.55v1a2.2 2.2 0 0 1 -2.2 2.2h-1a2.2 2.2 0 0 0 -1.55 .64l-.7 .7a2.2 2.2 0 0 1 -3.12 0l-.7 -.7a2.2 2.2 0 0 0 -1.55 -.64h-1a2.2 2.2 0 0 1 -2.2 -2.2v-1a2.2 2.2 0 0 0 -.64 -1.55l-.7 -.7a2.2 2.2 0 0 1 0 -3.12l.7 -.7a2.2 2.2 0 0 0 .64 -1.55v-1" />
                                                        <path d="M9 12l2 2l4 -4" />
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
                                                            href="{{ route('vehientregas.show',$vehientrega->id) }}">
                                                            @lang('View')
                                                        </a>
                                                        <a class="dropdown-item"
                                                            href="{{ route('vehientregas.edit',$vehientrega->id) }}">
                                                            @lang('Edit')
                                                        </a>
                                                        <form
                                                            action="{{ route('vehientregas.destroy',$vehientrega->id) }}"
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
                            {!! $vehientregas->links('tablar::pagination') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
