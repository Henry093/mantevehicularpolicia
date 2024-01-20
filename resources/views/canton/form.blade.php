

<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('provincia_id', 'Provincia') }}</label>
    <div>
        <select name="provincia_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia">
            <option value="" >Seleccionar Provincia..</option>
            @foreach($d_provincia as $provincia)
               <option value="{{ $provincia->id }}" {{ $canton->provincia_id == $provincia->id ? 'selected' : '' }}>
                    {{ $provincia->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $canton->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el nombre del Cantón', 'required']) }}
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
