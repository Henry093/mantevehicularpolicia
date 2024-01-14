
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('grado_id', 'Grado') }}</label>
    <div>
        <select name="grado_id" class="form-select form-control-rounded mb-2 {{ $errors->has('grado_id') ? ' is-invalid' : '' }}" placeholder="Grado">
            <option value="" >Seleccionar Grado..</option>
            @foreach($grados as $grado)
                <option value="{{ $grado->id }}" {{ $rango->grado_id == $grado->id ? 'selected' : '' }}>
                    {{ $grado->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('grado_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $rango->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre del rango']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/rangos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
