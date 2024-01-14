

<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('provincia_id', 'Provincia') }}</label>
    <div>
        <select name="provincia_id" class="form-control form-control-rounded mb-2 {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia">
            <option value="" >Seleccionar Provincia..</option>
            @foreach($provincias as $provincia)
               <option value="{{ $provincia->id }}" {{ $canton->provincia_id == $provincia->id ? 'selected' : '' }}>
                    {{ $provincia->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre') }}</label>
    <div>
        {{ Form::text('nombre', $canton->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/cantons" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
