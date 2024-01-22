
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('provincia_id', 'Provincia') }}</label>
            <div>
                <select name="provincia_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia" >
                    <option value="" >Seleccionar Provincia..</option>
                    @foreach($d_provincia as $provincia)
                        <option value="{{ $provincia->id }}" {{ $subcircuito->provincia_id == $provincia->id ? 'selected' : '' }}>
                            {{ $provincia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('canton_id', 'Cantón') }}</label>
            <div>
                <select name="canton_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('canton_id') ? ' is-invalid' : '' }}" placeholder="Cantón" >
                    <option value="" >Seleccionar Cantón..</option>
                    @foreach($d_canton as $canton)
                        <option value="{{ $canton->id }}" {{ $subcircuito->canton_id == $canton->id ? 'selected' : '' }}>
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
            <label class="form-label required" >{{ Form::label('parroquia_id', 'Parroquia') }}</label>
            <div>
                <select name="parroquia_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('parroquia_id') ? ' is-invalid' : '' }}" placeholder="Parroquia" >
                    <option value="" >Seleccionar Parroquia..</option>
                    @foreach($d_parroquia as $parroquia)
                        <option value="{{ $parroquia->id }}" {{ $subcircuito->parroquia_id == $parroquia->id ? 'selected' : '' }}>
                            {{ $parroquia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('distrito_id', 'Distrito') }}</label>
            <div>
                <select name="distrito_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" placeholder="Distrito" >
                <option value="" >Seleccionar Distrito..</option>
                    @foreach($d_distrito as $distrito)
                        <option value="{{ $distrito->id }}" {{ $subcircuito->distrito_id == $distrito->id ? 'selected' : '' }}>
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
    <label class="form-label required" >{{ Form::label('circuito_id', 'Circuito') }}</label>
    <div>
        <select name="circuito_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('circuito_id') ? ' is-invalid' : '' }}" placeholder="Circuito" >
        <option value="" >Seleccionar Circuito..</option>
            @foreach($d_circuito as $circuito)
                <option value="{{ $circuito->id }}" {{ $subcircuito->circuito_id == $circuito->id ? 'selected' : '' }}>
                    {{ $circuito->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('circuito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('nombre') }}</label>
    <div>
        {{ Form::text('nombre', $subcircuito->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el nombre del subcircuito', 'required']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('codigo', 'Código') }}</label>
    <div>
        {{ Form::text('codigo', $subcircuito->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el código del subcircuito ej. 11D01C01S01', 'required']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
@if ($edicion)
    <div class="form-group mb-3">
        <label class="form-label required">{{ Form::label('estado_id', 'Estado') }}</label>
        <div>
            <select name="estado_id" required
                class="form-select form-control-rounded mb-2 
        {{ $errors->has('estado_id') ? ' is-invalid' : '' }}"
                placeholder="Estado">
                <option value="">Seleccionar Estado..</option>
                @foreach ($d_estado as $estado)
                    <option value="{{ $estado->id }}" {{ $subcircuito->estado_id == $estado->id ? 'selected' : '' }}>
                        {{ $estado->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
@endif

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/subcircuitos" class="btn btn-danger">@lang('Cancel')</a>
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
                        url: '/obtener-cantones-s/' + provinciaId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="canton_id"]').empty();
                            $('select[name="parroquia_id"]').empty();
                            $('select[name="distrito_id"]').empty();
                            $('select[name="circuito_id"]').empty(); // Nuevo: Limpiar la selección de circuito
    
                            $('select[name="canton_id"]').append('<option value="">Seleccionar Cantón..</option>');
                            $('select[name="parroquia_id"]').append('<option value="">Seleccionar Parroquia..</option>');
                            $('select[name="distrito_id"]').append('<option value="">Seleccionar Distrito..</option>');
                            $('select[name="circuito_id"]').append('<option value="">Seleccionar Circuito..</option>'); // Nuevo: Agregar la opción de circuito
    
                            $.each(data, function(key, value) {
                                $('select[name="canton_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="canton_id"]').empty();
                    $('select[name="parroquia_id"]').empty();
                    $('select[name="distrito_id"]').empty();
                    $('select[name="circuito_id"]').empty(); // Nuevo: Limpiar la selección de circuito
                }
            });
    
            // Cuando cambia la selección de cantón
            $('select[name="canton_id"]').change(function() {
                var cantonId = $(this).val();
                if (cantonId) {
                    // Realizar una solicitud AJAX para obtener las parroquias correspondientes al cantón seleccionado
                    $.ajax({
                        url: '/obtener-parroquias-s/' + cantonId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="parroquia_id"]').empty();
                            $('select[name="distrito_id"]').empty();
                            $('select[name="circuito_id"]').empty(); // Nuevo: Limpiar la selección de circuito
    
                            $('select[name="parroquia_id"]').append('<option value="">Seleccionar Parroquia..</option>');
                            $('select[name="distrito_id"]').append('<option value="">Seleccionar Distrito..</option>');
                            $('select[name="circuito_id"]').append('<option value="">Seleccionar Circuito..</option>'); // Nuevo: Agregar la opción de circuito
    
                            $.each(data, function(key, value) {
                                $('select[name="parroquia_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="parroquia_id"]').empty();
                    $('select[name="distrito_id"]').empty();
                    $('select[name="circuito_id"]').empty(); // Nuevo: Limpiar la selección de circuito
                }
            });
    
            // Cuando cambia la selección de parroquia
            $('select[name="parroquia_id"]').change(function() {
                var parroquiaId = $(this).val();
                if (parroquiaId) {
                    // Realizar una solicitud AJAX para obtener los distritos correspondientes a la parroquia seleccionada
                    $.ajax({
                        url: '/obtener-distritos-s/' + parroquiaId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="distrito_id"]').empty();
                            $('select[name="circuito_id"]').empty(); // Nuevo: Limpiar la selección de circuito
    
                            $('select[name="distrito_id"]').append('<option value="">Seleccionar Distrito..</option>');
                            $('select[name="circuito_id"]').append('<option value="">Seleccionar Circuito..</option>'); // Nuevo: Agregar la opción de circuito
    
                            $.each(data, function(key, value) {
                                $('select[name="distrito_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="distrito_id"]').empty();
                    $('select[name="circuito_id"]').empty(); // Nuevo: Limpiar la selección de circuito
                }
            });
    
            // Cuando cambia la selección de distrito
            $('select[name="distrito_id"]').change(function() {
                var distritoId = $(this).val();
                if (distritoId) {
                    // Realizar una solicitud AJAX para obtener los circuitos correspondientes al distrito seleccionado
                    $.ajax({
                        url: '/obtener-circuitos-s/' + distritoId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="circuito_id"]').empty();
    
                            $('select[name="circuito_id"]').append('<option value="">Seleccionar Circuito..</option>');
    
                            $.each(data, function(key, value) {
                                $('select[name="circuito_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="circuito_id"]').empty();
                }
            });
        });
    </script>