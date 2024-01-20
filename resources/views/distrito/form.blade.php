<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('provincia_id', 'Provincia') }}</label>
    <div>
        <select name="provincia_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia" >
            <option value="" >Seleccionar Provincia..</option>
            @foreach($d_provincia as $provincia)
                <option value="{{ $provincia->id }}" {{ $distrito->provincia_id == $provincia->id ? 'selected' : '' }}>
                    {{ $provincia->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('canton_id', 'Cantón') }}</label>
    <div>
        <select name="canton_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('canton_id') ? ' is-invalid' : '' }}" placeholder="Cantón" >
            <option value="" >Seleccionar Cantón..</option>
            @foreach($d_canton as $canton)
                <option value="{{ $canton->id }}" {{ $distrito->canton_id == $canton->id ? 'selected' : '' }}>
                    {{ $canton->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('parroquia_id', 'Parroquia') }}</label>
    <div>
        <select name="parroquia_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('parroquia_id') ? ' is-invalid' : '' }}" placeholder="Parroquia" >
            <option value="" >Seleccionar Parroquia..</option>
            @foreach($d_parroquia as $parroquia)
                <option value="{{ $parroquia->id }}" {{ $distrito->parroquia_id == $canton->id ? 'selected' : '' }}>
                    {{ $parroquia->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $distrito->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el nombre del Distrito', 'required']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('codigo', 'Código') }}</label>
    <div>
        {{ Form::text('codigo', $distrito->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el código del Distrito, ejm: 11D01', 'required']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-footer">
    <div class="text-end">
        <div class="d-flex">
            <a href="/distritos" class="btn btn-danger">@lang('Cancel')</a>
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
                        url: '/obtener-cantones/' + provinciaId,
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
                        url: '/obtener-parroquias/' + cantonId,
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
        });
    </script>