
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('tvehiculo_id') }}</label>
    <div>
        {{ Form::text('tvehiculo_id', $vehiculo->tvehiculo_id, ['class' => 'form-control' .
        ($errors->has('tvehiculo_id') ? ' is-invalid' : ''), 'placeholder' => 'Tvehiculo Id']) }}
        {!! $errors->first('tvehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>tvehiculo_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('placa') }}</label>
    <div>
        {{ Form::text('placa', $vehiculo->placa, ['class' => 'form-control' .
        ($errors->has('placa') ? ' is-invalid' : ''), 'placeholder' => 'Placa']) }}
        {!! $errors->first('placa', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>placa</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('chasis') }}</label>
    <div>
        {{ Form::text('chasis', $vehiculo->chasis, ['class' => 'form-control' .
        ($errors->has('chasis') ? ' is-invalid' : ''), 'placeholder' => 'Chasis']) }}
        {!! $errors->first('chasis', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>chasis</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('marca_id') }}</label>
    <div>
        {{ Form::text('marca_id', $vehiculo->marca_id, ['class' => 'form-control' .
        ($errors->has('marca_id') ? ' is-invalid' : ''), 'placeholder' => 'Marca Id']) }}
        {!! $errors->first('marca_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>marca_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('modelo_id') }}</label>
    <div>
        {{ Form::text('modelo_id', $vehiculo->modelo_id, ['class' => 'form-control' .
        ($errors->has('modelo_id') ? ' is-invalid' : ''), 'placeholder' => 'Modelo Id']) }}
        {!! $errors->first('modelo_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>modelo_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('motor') }}</label>
    <div>
        {{ Form::text('motor', $vehiculo->motor, ['class' => 'form-control' .
        ($errors->has('motor') ? ' is-invalid' : ''), 'placeholder' => 'Motor']) }}
        {!! $errors->first('motor', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>motor</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('kilometraje') }}</label>
    <div>
        {{ Form::text('kilometraje', $vehiculo->kilometraje, ['class' => 'form-control' .
        ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje']) }}
        {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>kilometraje</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('cilindraje') }}</label>
    <div>
        {{ Form::text('cilindraje', $vehiculo->cilindraje, ['class' => 'form-control' .
        ($errors->has('cilindraje') ? ' is-invalid' : ''), 'placeholder' => 'Cilindraje']) }}
        {!! $errors->first('cilindraje', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>cilindraje</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('vcarga_id') }}</label>
    <div>
        {{ Form::text('vcarga_id', $vehiculo->vcarga_id, ['class' => 'form-control' .
        ($errors->has('vcarga_id') ? ' is-invalid' : ''), 'placeholder' => 'Vcarga Id']) }}
        {!! $errors->first('vcarga_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>vcarga_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('vpasajero_id') }}</label>
    <div>
        {{ Form::text('vpasajero_id', $vehiculo->vpasajero_id, ['class' => 'form-control' .
        ($errors->has('vpasajero_id') ? ' is-invalid' : ''), 'placeholder' => 'Vpasajero Id']) }}
        {!! $errors->first('vpasajero_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>vpasajero_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('estado_id') }}</label>
    <div>
        {{ Form::text('estado_id', $vehiculo->estado_id, ['class' => 'form-control' .
        ($errors->has('estado_id') ? ' is-invalid' : ''), 'placeholder' => 'Estado Id']) }}
        {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">vehiculo <b>estado_id</b> instruction.</small>
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
