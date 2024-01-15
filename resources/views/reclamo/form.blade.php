<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('circuito_id', 'Circuito') }}</label>
    <div>
        <select name="circuito_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('circuito_id') ? ' is-invalid' : '' }}" placeholder="Circuito">
            <option value="">Seleccionar Circuito..</option>
            @foreach($dcircuito as $circuito)
                <option value="{{ $circuito->id }}" {{ $reclamo->circuito_id == $circuito->id ? 'selected' : '' }}>
                    {{ $circuito->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('circuito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('subcircuito_id', 'Subcircuito') }}</label>
    <div>
        <select name="subcircuito_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('subcircuito_id') ? ' is-invalid' : '' }}" placeholder="Subcircuito" >
        <option value="" >Seleccionar Subcircuito..</option>
            @foreach($dsubcircuito as $subcircuito)
                <option value="{{ $subcircuito->id }}" {{ $reclamo->subcircuito_id == $subcircuito->id ? 'selected' : '' }}>
                    {{ $subcircuito->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('subcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('treclamo_id', 'Tipo Reclamo') }}</label>
    <div>
        <select name="treclamo_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('treclamo_id') ? ' is-invalid' : '' }}" placeholder="Tipo Reclamo" >
        <option value="" >Seleccionar Tipo Reclamo..</option>
            @foreach($dtreclamo as $treclamo)
                <option value="{{ $treclamo->id }}" {{ $reclamo->treclamo_id == $treclamo->id ? 'selected' : '' }}>
                    {{ $treclamo->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('treclamo_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('detalle') }}</label>
    <div>
        {{ Form::textarea('detalle', $reclamo->detalle, ['class' => 'form-control' .
        ($errors->has('detalle') ? ' is-invalid' : ''), 'placeholder' => 'Detalle']) }}
        {!! $errors->first('detalle', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('contacto') }}</label>
    <div>
        {{ Form::text('contacto', $reclamo->contacto, ['class' => 'form-control' .
        ($errors->has('contacto') ? ' is-invalid' : ''), 'placeholder' => 'Contacto']) }}
        {!! $errors->first('contacto', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('apellidos') }}</label>
    <div>
        {{ Form::text('apellidos', $reclamo->apellidos, ['class' => 'form-control' .
        ($errors->has('apellidos') ? ' is-invalid' : ''), 'placeholder' => 'Apellidos']) }}
        {!! $errors->first('apellidos', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombres') }}</label>
    <div>
        {{ Form::text('nombres', $reclamo->nombres, ['class' => 'form-control' .
        ($errors->has('nombres') ? ' is-invalid' : ''), 'placeholder' => 'Nombres']) }}
        {!! $errors->first('nombres', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/reclamos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>

    
    <script>
        $(document).ready(function() {
            // Cuando cambia la selección de circuito
            $('select[name="circuito_id"]').change(function() {
                var circuitoId = $(this).val();
                if (circuitoId) {
                    // Realizar una solicitud AJAX para obtener los subcircuitos correspondientes al circuito seleccionado
                    $.ajax({
                        url: '/obtener-subcircuitos/' + circuitoId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="subcircuito_id"]').empty();
                            $('select[name="subcircuito_id"]').append('<option value="">Seleccionar Subcircuito..</option>');
                            $.each(data, function(key, value) {
                                $('select[name="subcircuito_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="subcircuito_id"]').empty();
                }
            });
        });
    </script>