
<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('marca_id', 'Marca') }}</label>
    <div>
        <select name="marca_id" class="form-select form-control-rounded mb-2 {{ $errors->has('marca_id') ? ' is-invalid' : '' }}" placeholder="Marca">
            <option value="" >Seleccionar Marca..</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ $marca->marca_id == $marca->id ? 'selected' : '' }}>
                    {{ $marca->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('marca_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $modelo->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre modelo']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/modelos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
