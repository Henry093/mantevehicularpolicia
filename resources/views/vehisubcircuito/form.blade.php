<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('vehiculo_id', 'Placa del Vehículo ') }}</label>
    <div>
        <select name="vehiculo_id" required
        class="form-select form-control-rounded mb-2 vehiculo-select
        {{ $errors->has('vehiculo_id') ? ' is-invalid' : '' }}" placeholder="Vehículo policial">
            <option value="">Seleccionar Vehiculo..</option>
            @foreach ($d_vehiculo as $vehiculo)
                @unless ($vehiculo->asignacion_id == 1 || $vehiculo->asignacion_id == 2)
                <option value="{{ $vehiculo->id }}" {{ $vehisubcircuito->vehiculo_id == $vehiculo->id ? 'selected' : '' }}>
                    {{ $vehiculo->placa }} 
                </option>
                @endunless
            @endforeach
        </select>
        {!! $errors->first('vehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
@if ($edicion2)
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detalle del Vehículo</h3>
                    </div>
                    <div class="modal-body vehiculo-info">
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Vehículo</label>
                                    <input type="text" class="form-control ps-0 vehiculo-info-tipo" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Placa del Vehículo</label>
                                    <input type="text" class="form-control ps-0 vehiculo-info-placa" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Marca del Vehículo</label>
                                    <input type="text" class="form-control ps-0 vehiculo-info-marca" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Modelo del Vehículo</label>
                                    <input type="text" class="form-control ps-0 vehiculo-info-modelo" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label">Capacidad de carga</label>
                                    <input type="text" class="form-control ps-0 vehiculo-info-carga" disabled>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Capacidad de Pasajeros</label>
                                    <input type="text" class="form-control ps-0 vehiculo-info-pasajero" disabled>
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
        <div class="col-md-6">
            <label class="form-label required">{{ Form::label('provincia_id', 'Provincia') }}</label>
            <div>
                <select name="provincia_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}"
                    placeholder="Provincia">
                    <option value="">Seleccionar Provincia..</option>
                    @foreach ($d_provincia as $provincia)
                        <option value="{{ $provincia->id }}"
                            {{ $vehisubcircuito->provincia_id == $provincia->id ? 'selected' : '' }}>
                            {{ $provincia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">{{ Form::label('canton_id', 'Cantón') }}</label>
            <div>
                <select name="canton_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('canton_id') ? ' is-invalid' : '' }}"
                    placeholder="Cantón">
                    <option value="">Seleccionar Cantón..</option>
                    @foreach ($d_canton as $canton)
                        <option value="{{ $canton->id }}"
                            {{ $vehisubcircuito->canton_id == $canton->id ? 'selected' : '' }}>
                            {{ $canton->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">{{ Form::label('parroquia_id', 'Parroquia') }}</label>
            <div>
                <select name="parroquia_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('parroquia_id') ? ' is-invalid' : '' }}"
                    placeholder="Parroquia">
                    <option value="">Seleccionar Parroquia..</option>
                    @foreach ($d_parroquia as $parroquia)
                        <option value="{{ $parroquia->id }}"
                            {{ $vehisubcircuito->parroquia_id == $parroquia->id ? 'selected' : '' }}>
                            {{ $parroquia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">{{ Form::label('distrito_id', 'Distrito') }}</label>
            <div>
                <select name="distrito_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}"
                    placeholder="Distrito">
                    <option value="">Seleccionar Distrito..</option>
                    @foreach ($d_distrito as $distrito)
                        <option value="{{ $distrito->id }}"
                            {{ $vehisubcircuito->distrito_id == $distrito->id ? 'selected' : '' }}>
                            {{ $distrito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('distrito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">{{ Form::label('circuito_id', 'Circuito') }}</label>
            <div>
                <select name="circuito_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('circuito_id') ? ' is-invalid' : '' }}"
                    placeholder="Circuito">
                    <option value="">Seleccionar Circuito..</option>
                    @foreach ($d_circuito as $circuito)
                        <option value="{{ $circuito->id }}"
                            {{ $vehisubcircuito->circuito_id == $circuito->id ? 'selected' : '' }}>
                            {{ $circuito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('circuito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">{{ Form::label('subcircuito_id', 'Sub Circuito') }}</label>
            <div>
                <select name="subcircuito_id" required
                    class="form-select form-control-rounded mb-2 
                {{ $errors->has('subcircuito_id') ? ' is-invalid' : '' }}"
                    placeholder="Circuito">
                    <option value="">Seleccionar Sub Circuito..</option>
                    @foreach ($d_subcircuito as $subcircuito)
                        <option value="{{ $subcircuito->id }}"
                            {{ $vehisubcircuito->subcircuito_id == $subcircuito->id ? 'selected' : '' }}>
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
            <select name="asignacion_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('asignacion_id') ? ' is-invalid' : '' }}" placeholder="Estado Asignación">
                <option value="">Seleccionar Estado Asignación..</option>
                @foreach ($d_asignacion as $asignacion)
                    <option
                        value="{{ $asignacion->id }}"{{ $vehisubcircuito->asignacion_id == $asignacion->id ? 'selected' : '' }}>
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
            <a href="/vehisubcircuitos" class="btn btn-danger">@lang('Cancel')</a>
            <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        
        // Maneja el cambio en el select
        $('.vehiculo-select').change(function() {
            // Obtiene el valor seleccionado del usuario
            var vehiculoId = $(this).val();

            // Realiza una petición Ajax para obtener la información del vehículo
            $.ajax({
                url: '/obtener-informacion-vehiculo/' + vehiculoId,
                type: 'GET',
                success: function(data) {
                    // Actualiza los campos de la información del vehículo con los datos obtenidos
                    $('.vehiculo-info-tipo').val(data.tvehiculo);
                    $('.vehiculo-info-placa').val(data.placa);
                    $('.vehiculo-info-marca').val(data.marca);
                    $('.vehiculo-info-modelo').val(data.modelo);
                    $('.vehiculo-info-carga').val(data.vcarga);
                    $('.vehiculo-info-pasajero').val(data.vpasajero);
                },
                error: function(error) {
                    alert('Error al obtener la información del vehículo');
                }
            });
        });
        // Cuando cambia la selección de provincia
        $('select[name="provincia_id"]').change(function() {
            var provinciaId = $(this).val();
            if (provinciaId) {
                // Realizar una solicitud AJAX para obtener los cantones correspondientes a la provincia seleccionada
                $.ajax({
                    url: '/obtener-cantones-vs/' + provinciaId,
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
                    url: '/obtener-parroquias-vs/' + cantonId,
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
                    url: '/obtener-distritos-vs/' + parroquiaId,
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
                    url: '/obtener-circuitos-vs/' + distritoId,
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
                    url: '/obtener-subcircuitos-vs/' + circuitoId,
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
