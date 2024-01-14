
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre', 'Nombre') }}</label>
    <div>
        {{ Form::text('nombre', $tmantenimiento->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre del tipo de mantenimiento']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('valor', 'Valor') }}</label>
    <div>
        {{ Form::text('valor', $tmantenimiento->valor, ['class' => 'form-control' .
        ($errors->has('valor') ? ' is-invalid' : ''), 'placeholder' => 'Valor total $']) }}
        {!! $errors->first('valor', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('descripcion', 'Descripción') }}</label>
    <div>
        {{ Form::textarea('descripcion', $tmantenimiento->descripcion, ['class' => 'form-control' .
        ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripción del mantenimiento']) }}
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
