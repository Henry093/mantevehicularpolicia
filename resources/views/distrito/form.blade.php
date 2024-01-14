
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('provincia_id', 'Provincia') }}</label>
    <div>
        <select name="provincia_id" class="form-select form-control-rounded mb-2 {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia">
            <option value="" >Seleccionar Provincia..</option>
            @foreach($provincias as $provincia)
                <option value="{{ $provincia->id }}" {{ $distrito->provincia_id == $provincia->id ? 'selected' : '' }}>
                    {{ $provincia->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $distrito->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre distrito']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('codigo', 'Código') }}</label>
    <div>
        {{ Form::text('codigo', $distrito->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Código distrito']) }}
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
