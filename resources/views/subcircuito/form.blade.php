
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('circuito_id') }}</label>
    <div>
        {{ Form::text('circuito_id', $subcircuito->circuito_id, ['class' => 'form-control' .
        ($errors->has('circuito_id') ? ' is-invalid' : ''), 'placeholder' => 'Circuito Id']) }}
        {!! $errors->first('circuito_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">subcircuito <b>circuito_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre') }}</label>
    <div>
        {{ Form::text('nombre', $subcircuito->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">subcircuito <b>nombre</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('codigo') }}</label>
    <div>
        {{ Form::text('codigo', $subcircuito->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Codigo']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">subcircuito <b>codigo</b> instruction.</small>
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="#" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">Submit</button>
            </div>
        </div>
    </div>
