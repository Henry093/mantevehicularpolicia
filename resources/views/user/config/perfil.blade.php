@extends('tablar::page')

@section('title', __('validation.User Profile'))

@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        @lang('View')
                    </div>
                    <h2 class="page-title">
                        @lang('User Profile')
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
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('User Profile')</h3>
                        </div>
                        <div class="card-body">
                            <div>
                                <p><strong>@lang('Name'):</strong> {{ $user->name }} {{ $user->lastname }}</p>
                                <p><strong>@lang('Cédula'):</strong> {{ $user->cedula }}</p>
                                <p><strong>@lang('Tipo Sangre'):</strong> {{ $user->sangre->nombre }}</p>
                                <p><strong>@lang('Ciudad Nacimiento'):</strong> {{ $user->parroquia->nombre }}</p>
                                <p><strong>@lang('Teléfono'):</strong> {{ $user->telefono }}</p>
                                <p><strong>@lang('Grado'):</strong> {{ $user->grado->nombre }}</p>
                                <p><strong>@lang('Rango'):</strong> {{ $user->rango->nombre }}</p>
                                <p><strong>@lang('Rol'):</strong>
                                    @foreach ($user->roles as $role)
                                        {{ $role->name }},
                                    @endforeach
                                </p>
                                <p><strong>@lang('Estado'):</strong> {{ $user->estado->nombre }}</p>
                                <p><strong>@lang('Usuario'):</strong> {{ $user->usuario }}</p>
                                <p><strong>@lang('Email'):</strong> {{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cambiar contraseña -->
                <hr>
                <div class="col-12 d-flex justify-content-center">
                    <div class="card" style="max-width: 800px;">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Change Password')</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('change.password') }}" id="passwordChangeForm">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">@lang('Current Password')</label>
                                    <input id="current_password" type="password" class="form-control" name="current_password" required>
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">@lang('New Password')</label>
                                    <input id="new_password" type="password" class="form-control" name="new_password" required placeholder="Min 8 Caracteres">
                                </div>

                                <div class="mb-3">
                                    <label for="new_confirm_password" class="form-label">@lang('Repeat New Password')</label>
                                    <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" required placeholder="Min 8 Caracteres">
                                    <span id="passwordMatchMessage" class="text-danger"></span>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">@lang('Change Password')</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Función para verificar si las contraseñas coinciden
    function checkPasswordMatch() {
        var password = $("#new_password").val();
        var confirmPassword = $("#new_confirm_password").val();

        if (password != confirmPassword) {
            $("#passwordMatchMessage").text("@lang('Passwords do not match')");
        } else {
            $("#passwordMatchMessage").text('');
        }
    }

    // Llamar a la función cuando cambie el contenido de los campos de contraseña
    $(document).ready(function () {
        $("#new_password, #new_confirm_password").keyup(checkPasswordMatch);
    });
</script>
@endpush