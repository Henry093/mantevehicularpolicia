<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('provincia_id', 'Provincia') }}</label>
    <div>
        <select name="provincia_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia" >
            <option value="" >Seleccionar Provincia..</option>
            @foreach($d_provincia as $provincia)
                <option value="{{ $provincia->id }}" {{ $circuito->provincia_id == $provincia->id ? 'selected' : '' }}>
                    {{ $provincia->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('distrito_id', 'Distrito') }}</label>
    <div>
        <select name="distrito_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" placeholder="Distrito" >
        <option value="" >Seleccionar Distrito..</option>
            @foreach($d_distrito as $distrito)
                <option value="{{ $distrito->id }}" {{ $circuito->distrito_id == $distrito->id ? 'selected' : '' }}>
                    {{ $distrito->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('distrito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $circuito->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el nombre del circuito', 'required']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('codigo', 'Código') }}</label>
    <div>
        {{ Form::text('codigo', $circuito->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el código del circuito, ejm: 11D01C01', 'required']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/circuitos" class="btn btn-danger">@lang('Cancel')</a>
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
                    $.ajax({
                        url: '/obtener-distritos/' + provinciaId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="distrito_id"]').empty();
                            $('select[name="distrito_id"]').append('<option value="">Seleccionar Distrito..</option>');
            
                            $.each(data, function(key, value) {
                                $('select[name="distrito_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="distrito_id"]').empty();
                }
            });
        });
    </script>