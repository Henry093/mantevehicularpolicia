
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('mantenimientos_id') }}</label>
    <div>
        {{ Form::text('mantenimientos_id', $vehientrega->mantenimientos_id, ['class' => 'form-control' .
        ($errors->has('mantenimientos_id') ? ' is-invalid' : ''), 'placeholder' => 'Mantenimientos Id']) }}
        {!! $errors->first('mantenimientos_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehientrega <b>mantenimientos_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('vehiregistros_id') }}</label>
    <div>
        {{ Form::text('vehiregistros_id', $vehientrega->vehiregistros_id, ['class' => 'form-control' .
        ($errors->has('vehiregistros_id') ? ' is-invalid' : ''), 'placeholder' => 'Vehiregistros Id']) }}
        {!! $errors->first('vehiregistros_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehientrega <b>vehiregistros_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('fecha_entrega') }}</label>
    <div>
        {{ Form::text('fecha_entrega', $vehientrega->fecha_entrega, ['class' => 'form-control' .
        ($errors->has('fecha_entrega') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Entrega']) }}
        {!! $errors->first('fecha_entrega', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehientrega <b>fecha_entrega</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('p_retiro') }}</label>
    <div>
        {{ Form::text('p_retiro', $vehientrega->p_retiro, ['class' => 'form-control' .
        ($errors->has('p_retiro') ? ' is-invalid' : ''), 'placeholder' => 'P Retiro']) }}
        {!! $errors->first('p_retiro', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehientrega <b>p_retiro</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('km_actual') }}</label>
    <div>
        {{ Form::text('km_actual', $vehientrega->km_actual, ['class' => 'form-control' .
        ($errors->has('km_actual') ? ' is-invalid' : ''), 'placeholder' => 'Km Actual']) }}
        {!! $errors->first('km_actual', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehientrega <b>km_actual</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('km_proximo') }}</label>
    <div>
        {{ Form::text('km_proximo', $vehientrega->km_proximo, ['class' => 'form-control' .
        ($errors->has('km_proximo') ? ' is-invalid' : ''), 'placeholder' => 'Km Proximo']) }}
        {!! $errors->first('km_proximo', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehientrega <b>km_proximo</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('observaciones') }}</label>
    <div>
        {{ Form::text('observaciones', $vehientrega->observaciones, ['class' => 'form-control' .
        ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones']) }}
        {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehientrega <b>observaciones</b> instruction.</small>
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
