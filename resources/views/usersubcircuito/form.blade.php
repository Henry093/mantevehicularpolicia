<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('user_id', 'Nombre ') }}</label>
    <div>
        <select name="user_id" required
            class="form-select form-control-rounded mb-2 user-select
            {{ $errors->has('user_id') ? ' is-invalid' : '' }}"
            placeholder="Nombre del personal policial">
            <option value="">Seleccionar Usuario..</option>
            @foreach ($d_user as $user)
                @unless ($user->asignacion_id == 1 || $user->asignacion_id == 2)
                    <option value="{{ $user->id }}" {{ $usersubcircuito->user_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} {{ $user->lastname }}
                    </option>
                @endunless
            @endforeach
        </select>
        {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
@if ($edicion2)
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-deck row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Details')</h3>
                        </div>
                        <div class="card-body user-info">
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Nombres y Apellidos</label>
                                        <input type="text" class="form-control ps-3 user-info-name" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Email</label>
                                        <input type="text" class="form-control ps-3 user-info-email" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Grado</label>
                                        <input type="text" class="form-control ps-3 user-info-grado" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label">Rango</label>
                                        <input type="text" class="form-control ps-3 user-info-rango" disabled>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <label class="form-label">Cédula</label>
                                        <input type="text" class="form-control ps-3 user-info-cedula" disabled>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Teléfono</label>
                                        <input type="text" class="form-control ps-3 user-info-telefono" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-4">
            <label class="form-label required">{{ Form::label('provincia_id', 'Provincia') }}</label>
            <div>
                <select name="provincia_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}"
                    placeholder="Provincia">
                    <option value="">Seleccionar Provincia..</option>
                    @foreach ($d_provincia as $provincia)
                        <option value="{{ $provincia->id }}"
                            {{ $usersubcircuito->provincia_id == $provincia->id ? 'selected' : '' }}>
                            {{ $provincia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label required">{{ Form::label('canton_id', 'Cantón') }}</label>
            <div>
                <select name="canton_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('canton_id') ? ' is-invalid' : '' }}"
                    placeholder="Cantón">
                    <option value="">Seleccionar Cantón..</option>
                    @foreach ($d_canton as $canton)
                        <option value="{{ $canton->id }}"
                            {{ $usersubcircuito->canton_id == $canton->id ? 'selected' : '' }}>
                            {{ $canton->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label required">{{ Form::label('parroquia_id', 'Parroquia') }}</label>
            <div>
                <select name="parroquia_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('parroquia_id') ? ' is-invalid' : '' }}"
                    placeholder="Parroquia">
                    <option value="">Seleccionar Parroquia..</option>
                    @foreach ($d_parroquia as $parroquia)
                        <option value="{{ $parroquia->id }}"
                            {{ $usersubcircuito->parroquia_id == $parroquia->id ? 'selected' : '' }}>
                            {{ $parroquia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-4">
            <label class="form-label required">{{ Form::label('distrito_id', 'Distrito') }}</label>
            <div>
                <select name="distrito_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}"
                    placeholder="Distrito">
                    <option value="">Seleccionar Distrito..</option>
                    @foreach ($d_distrito as $distrito)
                        <option value="{{ $distrito->id }}"
                            {{ $usersubcircuito->distrito_id == $distrito->id ? 'selected' : '' }}>
                            {{ $distrito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('distrito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label required">{{ Form::label('circuito_id', 'Circuito') }}</label>
            <div>
                <select name="circuito_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('circuito_id') ? ' is-invalid' : '' }}"
                    placeholder="Circuito">
                    <option value="">Seleccionar Circuito..</option>
                    @foreach ($d_circuito as $circuito)
                        <option value="{{ $circuito->id }}"
                            {{ $usersubcircuito->circuito_id == $circuito->id ? 'selected' : '' }}>
                            {{ $circuito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('circuito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-4">
            <label class="form-label required">{{ Form::label('subcircuito_id', 'Sub Circuito') }}</label>
            <div>
                <select name="subcircuito_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('subcircuito_id') ? ' is-invalid' : '' }}"
                    placeholder="Circuito">
                    <option value="">Seleccionar Sub Circuito..</option>
                    @foreach ($d_subcircuito as $subcircuito)
                        <option value="{{ $subcircuito->id }}"
                            {{ $usersubcircuito->subcircuito_id == $subcircuito->id ? 'selected' : '' }}>
                            {{ $subcircuito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('subcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>

@if ($edicion)
    <div class="col-md-6">
        <label class="form-label required">{{ Form::label('asignacion_id', 'Estado Asignación') }}</label>
        <div>
            <select name="asignacion_id" required
                class="form-select form-control-rounded mb-2 
                {{ $errors->has('asignacion_id') ? ' is-invalid' : '' }}"
                placeholder="Estado Asignación">
                <option value="">Seleccionar Estado Asignación..</option>
                @foreach ($d_asignacion as $asignacion)
                    <option
                        value="{{ $asignacion->id }}"{{ $usersubcircuito->asignacion_id == $asignacion->id ? 'selected' : '' }}>
                        {{ $asignacion->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('asignacion_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
@endif


<div class="form-footer">
    <div class="text-end">
        <div class="d-flex">
            <a href="/usersubcircuitos" class="btn btn-danger">@lang('Cancel')</a>
            <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Maneja el cambio en el select
        $('.user-select').change(function() {
            // Obtiene el valor seleccionado del usuario
            var userId = $(this).val();

            // Realiza una petición Ajax para obtener la información del usuario
            $.ajax({
                url: '/obtener-informacion-usuario/' + userId,
                type: 'GET',
                success: function(data) {
                    // Actualiza los campos de la información del usuario con los datos obtenidos
                    $('.user-info-name').val(data.name + ' ' + data.lastname);
                    $('.user-info-email').val(data.email);
                    $('.user-info-grado').val(data.grado);
                    $('.user-info-rango').val(data.rango);
                    $('.user-info-cedula').val(data.cedula);
                    $('.user-info-telefono').val(data.telefono);
                },
                error: function() {
                    alert('Error al obtener la información del usuario');
                }
            });
        });
        // Cuando cambia la selección de provincia
        $('select[name="provincia_id"]').change(function() {
            var provinciaId = $(this).val();
            if (provinciaId) {
                // Realizar una solicitud AJAX para obtener los cantones correspondientes a la provincia seleccionada
                $.ajax({
                    url: '/obtener-cantones-us/' + provinciaId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="canton_id"]').empty();
                        $('select[name="parroquia_id"]').empty();
                        $('select[name="distrito_id"]').empty();
                        $('select[name="circuito_id"]').empty();
                        $('select[name="subcircuito_id"]').empty();
                        $('select[name="canton_id"]').append(
                            '<option value="">Seleccionar Cantón..</option>');
                        $('select[name="parroquia_id"]').append(
                            '<option value="">Seleccionar Parroquia..</option>');
                        $('select[name="distrito_id"]').append(
                            '<option value="">Seleccionar Distrito..</option>');
                        $('select[name="circuito_id"]').append(
                            '<option value="">Seleccionar Circuito..</option>');
                        $('select[name="subcircuito_id"]').append(
                            '<option value="">Seleccionar Sub Circuito..</option>');

                        $.each(data, function(key, value) {
                            $('select[name="canton_id"]').append('<option value="' +
                                key + '">' + value + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="canton_id"]').empty();
                $('select[name="parroquia_id"]').empty();
                $('select[name="distrito_id"]').empty();
                $('select[name="circuito_id"]').empty();
                $('select[name="subcircuito_id"]').empty();
            }
        });

        // Cuando cambia la selección de cantón
        $('select[name="canton_id"]').change(function() {
            var cantonId = $(this).val();
            if (cantonId) {
                // Realizar una solicitud AJAX para obtener las parroquias correspondientes al cantón seleccionado
                $.ajax({
                    url: '/obtener-parroquias-us/' + cantonId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="parroquia_id"]').empty();
                        $('select[name="distrito_id"]').empty();
                        $('select[name="circuito_id"]').empty();
                        $('select[name="subcircuito_id"]').empty();

                        $('select[name="parroquia_id"]').append(
                            '<option value="">Seleccionar Parroquia..</option>');
                        $('select[name="distrito_id"]').append(
                            '<option value="">Seleccionar Distrito..</option>');
                        $('select[name="circuito_id"]').append(
                            '<option value="">Seleccionar Circuito..</option>');
                        $('select[name="subcircuito_id"]').append(
                            '<option value="">Seleccionar Sub Circuito..</option>'
                        ); // Nuevo: Agregar la opción de circuito

                        $.each(data, function(key, value) {
                            $('select[name="parroquia_id"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                });
            } else {
                $('select[name="parroquia_id"]').empty();
                $('select[name="distrito_id"]').empty();
                $('select[name="circuito_id"]').empty();
                $('select[name="subcircuito_id"]').empty();
            }
        });

        // Cuando cambia la selección de parroquia
        $('select[name="parroquia_id"]').change(function() {
            var parroquiaId = $(this).val();
            if (parroquiaId) {
                // Realizar una solicitud AJAX para obtener los distritos correspondientes a la parroquia seleccionada
                $.ajax({
                    url: '/obtener-distritos-us/' + parroquiaId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="distrito_id"]').empty();
                        $('select[name="circuito_id"]').empty();
                        $('select[name="subcircuito_id"]').empty();

                        $('select[name="distrito_id"]').append(
                            '<option value="">Seleccionar Distrito..</option>');
                        $('select[name="circuito_id"]').append(
                            '<option value="">Seleccionar Circuito..</option>');
                        $('select[name="subcircuito_id"]').append(
                            '<option value="">Seleccionar Sub Circuito..</option>');

                        $.each(data, function(key, value) {
                            $('select[name="distrito_id"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                });
            } else {
                $('select[name="distrito_id"]').empty();
                $('select[name="circuito_id"]').empty();
                $('select[name="subcircuito_id"]').empty();
            }
        });

        // Cuando cambia la selección de distrito
        $('select[name="distrito_id"]').change(function() {
            var distritoId = $(this).val();
            if (distritoId) {
                // Realizar una solicitud AJAX para obtener los circuitos correspondientes al distrito seleccionado
                $.ajax({
                    url: '/obtener-circuitos-us/' + distritoId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="circuito_id"]').empty();
                        $('select[name="subcircuito_id"]').empty();

                        $('select[name="circuito_id"]').append(
                            '<option value="">Seleccionar Circuito..</option>');
                        $('select[name="subcircuito_id"]').append(
                            '<option value="">Seleccionar Sub Circuito..</option>');

                        $.each(data, function(key, value) {
                            $('select[name="circuito_id"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                });
            } else {
                $('select[name="circuito_id"]').empty();
                $('select[name="subcircuito_id"]').empty();
            }
        });
        // Cuando cambia la selección de distrito
        $('select[name="circuito_id"]').change(function() {
            var circuitoId = $(this).val();
            if (circuitoId) {
                // Realizar una solicitud AJAX para obtener los circuitos correspondientes al distrito seleccionado
                $.ajax({
                    url: '/obtener-subcircuitos-us/' + circuitoId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="subcircuito_id"]').empty();

                        $('select[name="subcircuito_id"]').append(
                            '<option value="">Seleccionar Subcircuito..</option>');

                        $.each(data, function(key, value) {
                            $('select[name="subcircuito_id"]').append(
                                '<option value="' + key + '">' + value +
                                '</option>');
                        });
                    }
                });
            } else {
                $('select[name="subcircuito_id"]').empty();
            }
        });
    });
</script>
