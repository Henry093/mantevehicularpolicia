@extends('tablar::page')

@section('title')
    Roles
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
                        {{ __('Usuario y Roles') }}
                    </h2>
                </div>
                <div class="col-12 col-md-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="{{ route('asignar.index') }}" class="btn btn-primary d-none d-sm-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <line x1="12" y1="5" x2="12" y2="19"/>
                                <line x1="5" y1="12" x2="19" y2="12"/>
                            </svg>
                            @lang('User List')  
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <strong>Nombres: </strong> {{ $user->name }} {{ $user->lastname }} 
                    </div>
                    <div class="form-group">
                        <strong>Grado: </strong> {{ $user->grado->nombre }} </h1>
                    </div>
                    <div class="form-group">
                        <strong>Rango: </strong> {{ $user->rango->nombre }} </h1>
                    </div>
                    
                </div>
                
                <div class="card-body card-md mb-3">
                    <h3>Lista de Roles</h3>
                    
                    {!! Form::model($user, ['route' => ['asignar.update', $user], 'method'=>'put']) !!}
                    
                    @foreach ($roles as $role )
                        <div>
                            <label class="form-check">
                                {!! Form::checkbox('roles[]', $role->id, $user->hasAnyRole($role->id) ? : false, ['class'=>'mr-1']) !!}
                                {{ $role->name }}
                            </label>
                        </div>
                    @endforeach

                    

                    {!! Form::submit('Asignar Roles', ['class'=>'btn btn-primary mt-3']) !!}
                    {!! Form::close() !!}
                    
                </div>
                
            </div>
        </div>
    </div>
    @endsection
