
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('vsubcircuito_id') }}</label>
    <div>
        {{ Form::text('vsubcircuito_id', $rmantenimiento->vsubcircuito_id, ['class' => 'form-control' .
        ($errors->has('vsubcircuito_id') ? ' is-invalid' : ''), 'placeholder' => 'Vsubcircuito Id']) }}
        {!! $errors->first('vsubcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">rmantenimiento <b>vsubcircuito_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('fecha_inicio') }}</label>
    <div>
        {{ Form::text('fecha_inicio', $rmantenimiento->fecha_inicio, ['class' => 'form-control' .
        ($errors->has('fecha_inicio') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Inicio']) }}
        {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">rmantenimiento <b>fecha_inicio</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('hora') }}</label>
    <div>
        {{ Form::text('hora', $rmantenimiento->hora, ['class' => 'form-control' .
        ($errors->has('hora') ? ' is-invalid' : ''), 'placeholder' => 'Hora']) }}
        {!! $errors->first('hora', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">rmantenimiento <b>hora</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('kilometraje') }}</label>
    <div>
        {{ Form::text('kilometraje', $rmantenimiento->kilometraje, ['class' => 'form-control' .
        ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje']) }}
        {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">rmantenimiento <b>kilometraje</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('observacion') }}</label>
    <div>
        {{ Form::text('observacion', $rmantenimiento->observacion, ['class' => 'form-control' .
        ($errors->has('observacion') ? ' is-invalid' : ''), 'placeholder' => 'Observacion']) }}
        {!! $errors->first('observacion', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">rmantenimiento <b>observacion</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('emantenimiento_id') }}</label>
    <div>
        {{ Form::text('emantenimiento_id', $rmantenimiento->emantenimiento_id, ['class' => 'form-control' .
        ($errors->has('emantenimiento_id') ? ' is-invalid' : ''), 'placeholder' => 'Emantenimiento Id']) }}
        {!! $errors->first('emantenimiento_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">rmantenimiento <b>emantenimiento_id</b> instruction.</small>
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
