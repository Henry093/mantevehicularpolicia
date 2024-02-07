@extends('tablar::page')

@section('title')
    Usuarios
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
                        {{ __('Administración de Usuarios') }}
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
                            <h3 class="card-title">@lang('User')</h3>
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
                                        <form action="{{ route('asignar.index') }}" method="GET" class="form-inline">
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
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <polyline points="6 15 12 9 18 15" />
                                            </svg>
                                        </th>

                                        <th>Nombre</th>
                                        <th>Usuario</th>
                                        <th>Grado</th>
                                        <th>Rango</th>
                                        <th>Email</th>
                                        <th>Rol Asignado</th>

                                        <th class="w-1"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($users as $user)
                                        <tr>
                                            <td><input class="form-check-input m-0 align-middle" type="checkbox"
                                                    aria-label="Select Rol"></td>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }} {{ $user->lastname }}</td>
                                            <td>{{ $user->usuario }}</td>
                                            <td>{{ $user->grado->nombre }}</td>
                                            <td>{{ $user->rango->nombre }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->roles->isNotEmpty())
                                                    @foreach ($user->roles as $role)
                                                        {{ $role->name }}
                                                    @endforeach
                                                @else
                                                <span style="color: red;">No Asignado</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M18 6l-12 12" />
                                                    <path d="M6 6l12 12" />
                                                </svg>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                <a  href="{{ route('asignar.edit', $user->id) }}" class="btn btn-pill">@lang('Asignar Rol')</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <td>@lang('No Data Found')</td>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="card-footer d-flex align-items-center">
                                {!! $users->links('tablar::pagination') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection