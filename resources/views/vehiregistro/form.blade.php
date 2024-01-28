
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('manteregistros_id') }}</label>
    <div>
        {{ Form::text('manteregistros_id', $vehiregistro->manteregistros_id, ['class' => 'form-control' .
        ($errors->has('manteregistros_id') ? ' is-invalid' : ''), 'placeholder' => 'Manteregistros Id']) }}
        {!! $errors->first('manteregistros_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>manteregistros_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('fecha_ingreso') }}</label>
    <div>
        {{ Form::text('fecha_ingreso', $vehiregistro->fecha_ingreso, ['class' => 'form-control' .
        ($errors->has('fecha_ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Ingreso']) }}
        {!! $errors->first('fecha_ingreso', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>fecha_ingreso</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('hora_ingreso') }}</label>
    <div>
        {{ Form::text('hora_ingreso', $vehiregistro->hora_ingreso, ['class' => 'form-control' .
        ($errors->has('hora_ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Hora Ingreso']) }}
        {!! $errors->first('hora_ingreso', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>hora_ingreso</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('kilometraje') }}</label>
    <div>
        {{ Form::text('kilometraje', $vehiregistro->kilometraje, ['class' => 'form-control' .
        ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje']) }}
        {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>kilometraje</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('asunto') }}</label>
    <div>
        {{ Form::text('asunto', $vehiregistro->asunto, ['class' => 'form-control' .
        ($errors->has('asunto') ? ' is-invalid' : ''), 'placeholder' => 'Asunto']) }}
        {!! $errors->first('asunto', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>asunto</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('detalle') }}</label>
    <div>
        {{ Form::text('detalle', $vehiregistro->detalle, ['class' => 'form-control' .
        ($errors->has('detalle') ? ' is-invalid' : ''), 'placeholder' => 'Detalle']) }}
        {!! $errors->first('detalle', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>detalle</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('mantetipos_id') }}</label>
    <div>
        {{ Form::text('mantetipos_id', $vehiregistro->mantetipos_id, ['class' => 'form-control' .
        ($errors->has('mantetipos_id') ? ' is-invalid' : ''), 'placeholder' => 'Mantetipos Id']) }}
        {!! $errors->first('mantetipos_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>mantetipos_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('imagen') }}</label>
    <div>
        {{ Form::text('imagen', $vehiregistro->imagen, ['class' => 'form-control' .
        ($errors->has('imagen') ? ' is-invalid' : ''), 'placeholder' => 'Imagen']) }}
        {!! $errors->first('imagen', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiregistro <b>imagen</b> instruction.</small>
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
