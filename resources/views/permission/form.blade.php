
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('name', 'Nombre') }}</label>
    <div>
        {{ Form::text('name', $permission->name, ['class' => 'form-control' .
        ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el nombre del permiso']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('description', 'Descripción') }}</label>
    <div>
        {{ Form::text('description', $permission->description, ['class' => 'form-control' .
        ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese la descripción del permiso']) }}
        {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

@if ($edicion) 
    <div class="form-group mb-3">
        <label class="form-label">   {{ Form::label('guard_name') }}</label>
        <div>
            {{ Form::text('guard_name', $permission->guard_name, ['class' => 'form-control' .
            ($errors->has('guard_name') ? ' is-invalid' : ''), 'placeholder' => 'Guard Name']) }}
            {!! $errors->first('guard_name', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
@endif
    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/permissions" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
