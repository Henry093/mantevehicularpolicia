<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('tvehiculo_id', 'Tipo Vehículo') }}</label>
            <div>
                <select name="tvehiculo_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('tvehiculo_id') ? ' is-invalid' : '' }}" placeholder="Tipo Vehículo" >
                    <option value="" >Seleccionar Tipo Vehículo..</option>
                    @foreach($dvehiculo as $tvehiculo)
                        <option value="{{ $tvehiculo->id }}" {{ $vehiculo->tvehiculo_id == $tvehiculo->id ? 'selected' : '' }}>
                            {{ $tvehiculo->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('tvehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('placa', 'Placa') }}</label>
            <div>
                {{ Form::text('placa', $vehiculo->placa, ['class' => 'form-control' .
                ($errors->has('placa') ? ' is-invalid' : ''), 'placeholder' => 'Placa']) }}
                {!! $errors->first('placa', '<div class="invalid-feedback">:message</div>') !!}
            </div>                       
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('chasis', 'Chasis') }}</label>
            <div>
                {{ Form::text('chasis', $vehiculo->chasis, ['class' => 'form-control' .
                ($errors->has('chasis') ? ' is-invalid' : ''), 'placeholder' => 'Chasis']) }}
                {!! $errors->first('chasis', '<div class="invalid-feedback">:message</div>') !!}
            </div>            
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('marca_id', 'Marca') }}</label>
            <div>
                <select name="marca_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('marca_id') ? ' is-invalid' : '' }}" placeholder="Marca" >
                    <option value="" >Seleccionar Marca..</option>
                    @foreach($dmarca as $marca)
                        <option value="{{ $marca->id }}" {{ $vehiculo->marca_id == $marca->id ? 'selected' : '' }}>
                            {{ $marca->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('marca_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('modelo_id', 'Modelo') }}</label>
            <div>
                <select name="modelo_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('modelo_id') ? ' is-invalid' : '' }}" placeholder="Modelo" >
                    <option value="" >Seleccionar Modelo..</option>
                    @foreach($dmodelo as $modelo)
                        <option value="{{ $modelo->id }}" {{ $vehiculo->modelo_id == $modelo->id ? 'selected' : '' }}>
                            {{ $modelo->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('modelo_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('motor', 'Motor') }}</label>
            <div>
                {{ Form::text('motor', $vehiculo->motor, ['class' => 'form-control' .
                ($errors->has('motor') ? ' is-invalid' : ''), 'placeholder' => 'Motor']) }}
                {!! $errors->first('motor', '<div class="invalid-feedback">:message</div>') !!}
            </div>                       
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('kilometraje', 'Kilometraje') }}</label>
            <div>
                {{ Form::text('kilometraje', $vehiculo->kilometraje, ['class' => 'form-control' .
                ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje']) }}
                {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
            </div>            
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('cilindraje', 'Cilindraje') }}</label>
            <div>
                {{ Form::text('cilindraje', $vehiculo->cilindraje, ['class' => 'form-control' .
                ($errors->has('cilindraje') ? ' is-invalid' : ''), 'placeholder' => 'Cilindraje']) }}
                {!! $errors->first('cilindraje', '<div class="invalid-feedback">:message</div>') !!}
            </div>                      
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('vcarga_id', 'Capacidad de Carga') }}</label>
            <div>
                <select name="vcarga_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('vcarga_id') ? ' is-invalid' : '' }}" placeholder="Capacidad de Carga" >
                    <option value="" >Seleccionar Capacidad de Carga..</option>
                    @foreach($dcarga as $vcarga)
                        <option value="{{ $vcarga->id }}" {{ $vehiculo->vcarga_id == $vcarga->id ? 'selected' : '' }}>
                            {{ $vcarga->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('vcarga_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('vpasajero_id', 'Capacidad de Pasajeros') }}</label>
            <div>
                <select name="vpasajero_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('vpasajero_id') ? ' is-invalid' : '' }}" placeholder="Capacidad de Pasajeros" >
                    <option value="" >Seleccionar Capacidad de Pasajeros..</option>
                    @foreach($dpasajero as $vpasajero)
                        <option value="{{ $vpasajero->id }}" {{ $vehiculo->vpasajero_id == $vpasajero->id ? 'selected' : '' }}>
                            {{ $vpasajero->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('vpasajero_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('estado_id', 'Estado') }}</label>
            <div>
                <select name="estado_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('estado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
                    @foreach($destado as $estado)
                        <option value="{{ $estado->id }}" {{ $vehiculo->estado_id == $estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group mb-3">

</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/vehiculos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
