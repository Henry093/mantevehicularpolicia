<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('provincia_id', 'Provincia') }}</label>
    <div>
        <select name="provincia_id" class="form-control form-control-rounded mb-2 {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia">
            <option value="" >Seleccionar Provincia..</option>
            @foreach($dprovincias as $provincia)
                <option value="{{ $provincia->id }}" {{ $parroquia->provincia_id == $provincia->id ? 'selected' : '' }}>
                    {{ $provincia->nombre }}
            </option>
            @endforeach
        </select>
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('canton_id', 'Cantón') }}</label>
    <div>
        <select name="canton_id" class="form-control form-control-rounded mb-2 {{ $errors->has('canton_id') ? ' is-invalid' : '' }}" placeholder="Cantón">
            <option value="" >Seleccionar Cantón..</option>
            @foreach($dcantons as $canton)
                <option value="{{ $canton->id }}" {{ $parroquia->canton_id == $canton->id ? 'selected' : '' }}>
                    {{ $canton->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre', 'Nombre Parroquia') }}</label>
    <div>
        {{ Form::text('nombre', $parroquia->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre Parroquia']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/parroquias" class="btn btn-danger">@lang('Cancel')</a>
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
                            $('select[name="canton_id"]').append('<option value="">Seleccionar Cantón..</option>');
                            $.each(data, function(key, value) {
                                $('select[name="canton_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="canton_id"]').empty();
                }
            });
        });
    </script>
