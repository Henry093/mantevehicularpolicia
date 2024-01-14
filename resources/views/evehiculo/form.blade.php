
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('rmantenimiento_id') }}</label>
    <div>
        {{ Form::text('rmantenimiento_id', $evehiculo->rmantenimiento_id, ['class' => 'form-control' .
        ($errors->has('rmantenimiento_id') ? ' is-invalid' : ''), 'placeholder' => 'Rmantenimiento Id']) }}
        {!! $errors->first('rmantenimiento_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">evehiculo <b>rmantenimiento_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('rvehiculo_id') }}</label>
    <div>
        {{ Form::text('rvehiculo_id', $evehiculo->rvehiculo_id, ['class' => 'form-control' .
        ($errors->has('rvehiculo_id') ? ' is-invalid' : ''), 'placeholder' => 'Rvehiculo Id']) }}
        {!! $errors->first('rvehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">evehiculo <b>rvehiculo_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('fecha_entrega') }}</label>
    <div>
        {{ Form::text('fecha_entrega', $evehiculo->fecha_entrega, ['class' => 'form-control' .
        ($errors->has('fecha_entrega') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Entrega']) }}
        {!! $errors->first('fecha_entrega', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">evehiculo <b>fecha_entrega</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('p_retiro') }}</label>
    <div>
        {{ Form::text('p_retiro', $evehiculo->p_retiro, ['class' => 'form-control' .
        ($errors->has('p_retiro') ? ' is-invalid' : ''), 'placeholder' => 'P Retiro']) }}
        {!! $errors->first('p_retiro', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">evehiculo <b>p_retiro</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('km_actual') }}</label>
    <div>
        {{ Form::text('km_actual', $evehiculo->km_actual, ['class' => 'form-control' .
        ($errors->has('km_actual') ? ' is-invalid' : ''), 'placeholder' => 'Km Actual']) }}
        {!! $errors->first('km_actual', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">evehiculo <b>km_actual</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('km_proximo') }}</label>
    <div>
        {{ Form::text('km_proximo', $evehiculo->km_proximo, ['class' => 'form-control' .
        ($errors->has('km_proximo') ? ' is-invalid' : ''), 'placeholder' => 'Km Proximo']) }}
        {!! $errors->first('km_proximo', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">evehiculo <b>km_proximo</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('observaciones') }}</label>
    <div>
        {{ Form::text('observaciones', $evehiculo->observaciones, ['class' => 'form-control' .
        ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones']) }}
        {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">evehiculo <b>observaciones</b> instruction.</small>
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
