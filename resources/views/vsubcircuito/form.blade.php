
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('vehiculo_id') }}</label>
    <div>
        {{ Form::text('vehiculo_id', $vsubcircuito->vehiculo_id, ['class' => 'form-control' .
        ($errors->has('vehiculo_id') ? ' is-invalid' : ''), 'placeholder' => 'Vehiculo Id']) }}
        {!! $errors->first('vehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vsubcircuito <b>vehiculo_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('dependencia_id') }}</label>
    <div>
        {{ Form::text('dependencia_id', $vsubcircuito->dependencia_id, ['class' => 'form-control' .
        ($errors->has('dependencia_id') ? ' is-invalid' : ''), 'placeholder' => 'Dependencia Id']) }}
        {!! $errors->first('dependencia_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vsubcircuito <b>dependencia_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('usubcircuito_id') }}</label>
    <div>
        {{ Form::text('usubcircuito_id', $vsubcircuito->usubcircuito_id, ['class' => 'form-control' .
        ($errors->has('usubcircuito_id') ? ' is-invalid' : ''), 'placeholder' => 'Usubcircuito Id']) }}
        {!! $errors->first('usubcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vsubcircuito <b>usubcircuito_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('asignacion_id') }}</label>
    <div>
        {{ Form::text('asignacion_id', $vsubcircuito->asignacion_id, ['class' => 'form-control' .
        ($errors->has('asignacion_id') ? ' is-invalid' : ''), 'placeholder' => 'Asignacion Id']) }}
        {!! $errors->first('asignacion_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vsubcircuito <b>asignacion_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('estado_id') }}</label>
    <div>
        {{ Form::text('estado_id', $vsubcircuito->estado_id, ['class' => 'form-control' .
        ($errors->has('estado_id') ? ' is-invalid' : ''), 'placeholder' => 'Estado Id']) }}
        {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vsubcircuito <b>estado_id</b> instruction.</small>
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
