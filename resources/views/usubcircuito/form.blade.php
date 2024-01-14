
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('user_id') }}</label>
    <div>
        {{ Form::text('user_id', $usubcircuito->user_id, ['class' => 'form-control' .
        ($errors->has('user_id') ? ' is-invalid' : ''), 'placeholder' => 'User Id']) }}
        {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">usubcircuito <b>user_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('dependencia_id') }}</label>
    <div>
        {{ Form::text('dependencia_id', $usubcircuito->dependencia_id, ['class' => 'form-control' .
        ($errors->has('dependencia_id') ? ' is-invalid' : ''), 'placeholder' => 'Dependencia Id']) }}
        {!! $errors->first('dependencia_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">usubcircuito <b>dependencia_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('asignacion_id') }}</label>
    <div>
        {{ Form::text('asignacion_id', $usubcircuito->asignacion_id, ['class' => 'form-control' .
        ($errors->has('asignacion_id') ? ' is-invalid' : ''), 'placeholder' => 'Asignacion Id']) }}
        {!! $errors->first('asignacion_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">usubcircuito <b>asignacion_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('estado_id') }}</label>
    <div>
        {{ Form::text('estado_id', $usubcircuito->estado_id, ['class' => 'form-control' .
        ($errors->has('estado_id') ? ' is-invalid' : ''), 'placeholder' => 'Estado Id']) }}
        {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">usubcircuito <b>estado_id</b> instruction.</small>
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
