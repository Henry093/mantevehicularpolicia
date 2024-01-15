
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('vehiculo_id', 'Vehículo') }}</label>
    <div>
        <select name="vehiculo_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('vehiculo_id') ? ' is-invalid' : '' }}" placeholder="Vehículo" >
        <option value="" >Seleccionar Vehículo..</option>
            @foreach($dvehiculo as $vehiculo)
                <option value="{{ $vehiculo->id }}" {{ $vsubcircuito->vehiculo_id == $vehiculo->id ? 'selected' : '' }}>
                    {{ $vehiculo->placa }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('vehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>  
</div>
<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('dependencia_id', 'Subcircuito') }}</label>
    <div>
        <select name="dependencia_id" class="form-control form-control-rounded mb-2  
        {{ $errors->has('dependencia_id') ? ' is-invalid' : '' }}" placeholder="Subcircuito">
            <option value="" >Seleccionar Subcircuito..</option>
            @foreach($ddependencia as $dependencia)
                <option value="{{ $dependencia->id }}" {{ $vsubcircuito->dependencia_id == $dependencia->id ? 'selected' : '' }}>
                    {{ $dependencia->subcircuito->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('dependencia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('usubcircuito_id', 'Usuario Subcircuito') }}</label>
    <div>
        <select name="usubcircuito_id" class="form-control form-control-rounded mb-2  
        {{ $errors->has('usubcircuito_id') ? ' is-invalid' : '' }}" placeholder="Subcircuito">
            <option value="" >Seleccionar Usuario Subcircuito..</option>
            @foreach($dusubcircuito as $usubcircuito)
                <option value="{{ $usubcircuito->id }}" {{ $vsubcircuito->usubcircuito_id == $usubcircuito->id ? 'selected' : '' }}>
                    {{ $usubcircuito->user->name }} {{ $usubcircuito->user->lastname }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('usubcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('asignacion_id', 'Asignación') }}</label>
    <div>
        <select name="asignacion_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('asignacion_id') ? ' is-invalid' : '' }}" placeholder="Asignación" >
            @foreach($dasignacion as $asignacion)
                <option value="{{ $asignacion->id }}" {{ $vsubcircuito->asignacion_id == $asignacion->id ? 'selected' : '' }}>
                    {{ $asignacion->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('asignacion_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('estado_id', 'Estado') }}</label>
    <div>
        <select name="estado_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('estado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
            @foreach($destado as $estado)
                <option value="{{ $estado->id }}" {{ $vsubcircuito->estado_id == $estado->id ? 'selected' : '' }}>
                       {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/vsubcircuitos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
