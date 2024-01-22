
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $tmantenimiento->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el nombre del tipo de mantenimiento', 'required']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('valor', 'Valor') }}</label>
    <div>
        {{ Form::text('valor', $tmantenimiento->valor, ['class' => 'form-control' .
        ($errors->has('valor') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el valor total $', 'required']) }}
        {!! $errors->first('valor', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('descripcion', 'Descripción') }}</label>
    <div>
        {{ Form::textarea('descripcion', $tmantenimiento->descripcion, ['class' => 'form-control' .
        ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese la descripción del mantenimiento', 'required']) }}
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/tmantenimientos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
