<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >   {{ Form::label('name', 'Nombres') }}</label>
            <div>
                {{ Form::text('name', $user->name, ['class' => 'form-control' .
                ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese los nombres', 'required']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('lastname', 'Apellidos') }}</label>
            <div>
                {{ Form::text('lastname', $user->lastname, ['class' => 'form-control' .
                ($errors->has('lastname') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese los apellidos', 'required']) }}
                {!! $errors->first('lastname', '<div class="invalid-feedback">:message</div>') !!}
            </div>           
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('cedula', 'Cédula') }}</label>
            <div>
                {{ Form::text('cedula', $user->cedula, ['class' => 'form-control' .
                ($errors->has('cedula') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el número de cédula', 'required']) }}
                {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('fecha_nacimiento') }}</label>
            <div>
                {{ Form::date('fecha_nacimiento', $user->fecha_nacimiento, ['class' => 'form-control' .
                ($errors->has('fecha_nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento', 'required']) }}
                {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback">:message</div>') !!}
            </div>           
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('sangre_id', 'Tipo Sangre') }}</label>
            <div>
                <select name="sangre_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('sangre_id') ? ' is-invalid' : '' }}" placeholder="Tipo Sangre" >
                    <option value="" >Seleccionar Tipo Sangre..</option>
                    @foreach($d_sangre as $sangre)
                        <option value="{{ $sangre->id }}" {{ $user->sangre_id == $sangre->id ? 'selected' : '' }}>
                            {{ $sangre->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('sangre_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('provincia_id', 'Provincia de nacimiento') }}</label>
            <div>
                <select name="provincia_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia de nacimiento" >
                    <option value="" >Seleccionar Provincia..</option>
                    @foreach($d_provincia as $provincia)
                        <option value="{{ $provincia->id }}" {{ $user->provincia_id == $provincia->id ? 'selected' : '' }}>
                            {{ $provincia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('canton_id', 'Cantón de nacimiento') }}</label>
            <div>
                <select name="canton_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('canton_id') ? ' is-invalid' : '' }}" placeholder="Cantón de nacimiento" >
                    <option value="" >Seleccionar Cantón..</option>
                    @foreach($d_canton as $canton)
                        <option value="{{ $canton->id }}" {{ $user->canton_id == $canton->id ? 'selected' : '' }}>
                            {{ $canton->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('parroquia_id', 'Parroquia de nacimiento') }}</label>
            <div>
                <select name="parroquia_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('parroquia_id') ? ' is-invalid' : '' }}" placeholder="Parroquia de nacimiento" >
                    <option value="" >Seleccionar Parroquia..</option>
                    @foreach($d_parroquia as $parroquia)
                        <option value="{{ $parroquia->id }}" {{ $user->parroquia_id == $parroquia->id ? 'selected' : '' }}>
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
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('telefono', 'Teléfono') }}</label>
            <div>
                {{ Form::text('telefono', $user->telefono, ['class' => 'form-control' .
                ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el número del teléfono celular', 'required']) }}
                {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('grado_id', 'Grado') }}</label>
            <div>
                <select name="grado_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('grado_id') ? ' is-invalid' : '' }}" placeholder="Grado" >
                    <option value="" >Seleccionar Grado..</option>
                    @foreach($d_grado as $grado)
                        <option value="{{ $grado->id }}" {{ $user->grado_id == $grado->id ? 'selected' : '' }}>
                            {{ $grado->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('grado_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('rango_id', 'Rango') }}</label>
            <div>
                <select name="rango_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('rango_id') ? ' is-invalid' : '' }}" placeholder="Rango" >
                    <option value="" >Seleccionar Rango..</option>
                    @foreach($d_rango as $rango)
                        <option value="{{ $rango->id }}" {{ $user->rango_id == $rango->id ? 'selected' : '' }}>
                            {{ $rango->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('rango_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        @if ($edicion)
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('estado_id', 'Estado') }}</label>
            <div>
                <select name="estado_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('estado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
                    @foreach($d_estado as $estado)
                        <option value="{{ $estado->id }}" {{ $user->estado_id == $estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        @endif
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/users" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Cuando cambia la selección de provincia
            $('select[name="provincia_id"]').change(function() {
                var provinciaId = $(this).val();
                if (provinciaId) {
                    // Realizar una solicitud AJAX para obtener los cantones correspondientes a la provincia seleccionada
                    $.ajax({
                        url: '/obtener-cantones/' + provinciaId, // Reemplaza con la ruta correcta de la aplicación
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="canton_id"]').empty();
                            $('select[name="parroquia_id"]').empty();
                            $('select[name="canton_id"]').append('<option value="">Seleccionar Cantón..</option>');
                            $('select[name="parroquia_id"]').append('<option value="">Seleccionar Parroquia..</option>');
                            $.each(data, function(key, value) {
                                $('select[name="canton_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="canton_id"]').empty();
                    $('select[name="parroquia_id"]').empty();
                }
            });
    
            // Cuando cambia la selección de cantón
            $('select[name="canton_id"]').change(function() {
                var cantonId = $(this).val();
                if (cantonId) {
                    // Realizar una solicitud AJAX para obtener las parroquias correspondientes al cantón seleccionado
                    $.ajax({
                        url: '/obtener-parroquias/' + cantonId, // Reemplaza con la ruta correcta de la aplicación
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="parroquia_id"]').empty();
                            $('select[name="parroquia_id"]').append('<option value="">Seleccionar Parroquia..</option>');
                            $.each(data, function(key, value) {
                                $('select[name="parroquia_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="parroquia_id"]').empty();
                }
            });
            $(document).ready(function() {
                // Cuando cambia la selección de grado
                $('select[name="grado_id"]').change(function() {
                    var gradoId = $(this).val();
                    if (gradoId) {
                        // Realizar una solicitud AJAX para obtener los rangos correspondientes al grado seleccionado
                        $.ajax({
                            url: '/obtener-rangos/' + gradoId, // Reemplaza con la ruta correcta de la aplicación
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('select[name="rango_id"]').empty();
                                $('select[name="rango_id"]').append('<option value="">Seleccionar Rango..</option>');
                                $.each(data, function(key, value) {
                                    $('select[name="rango_id"]').append('<option value="' + key + '">' + value + '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="rango_id"]').empty();
                    }
                });
            });
        });
    </script>