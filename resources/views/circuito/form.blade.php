
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('distrito_id', 'Distrito') }}</label>
    <div>
        <select name="distrito_id" class="form-select form-control-rounded mb-2 {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" placeholder="Nombre del distrito">
            <option value="" >Seleccionar Distrito..</option>
            @foreach($distritos as $distrito)
                <option value="{{ $distrito->id }}" {{ $circuito->distrito_id == $distrito->id ? 'selected' : '' }}>
                    {{ $distrito->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('distrito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $circuito->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre circuito']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('codigo', 'Código') }}</label>
    <div>
        {{ Form::text('codigo', $circuito->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Código circuito']) }}
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
