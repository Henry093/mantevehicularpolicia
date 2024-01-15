<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('vsubcircuito_id', 'Vehículo Subcircuito') }}</label>
    <div>
        <select name="vsubcircuito_id" class="form-control form-control-rounded mb-2  
        {{ $errors->has('vsubcircuito_id') ? ' is-invalid' : '' }}" placeholder="Vehículo">
            <option value="" >Seleccionar Vehículo Subcircuito..</option>
            @foreach($dvsubcircuito as $vsubcircuito)
                <option value="{{ $vsubcircuito->id }}" {{ $rmantenimiento->vsubcircuito_id == $vsubcircuito->id ? 'selected' : '' }}>
                    {{ $vsubcircuito->vehiculo->placa }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('vsubcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('fecha_inicio') }}</label>
    <div>
        {{ Form::date('fecha_inicio', $rmantenimiento->fecha_inicio, ['class' => 'form-control' .
        ($errors->has('fecha_inicio') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Inicio']) }}
        {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('hora') }}</label>
    <div>
        {{ Form::time('hora', $rmantenimiento->hora, ['class' => 'form-control' .
        ($errors->has('hora') ? ' is-invalid' : ''), 'placeholder' => 'Hora']) }}
        {!! $errors->first('hora', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('kilometraje') }}</label>
    <div>
        {{ Form::text('kilometraje', $rmantenimiento->kilometraje, ['class' => 'form-control' .
        ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje']) }}
        {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('observacion', 'Observación') }}</label>
    <div>
        {{ Form::text('observacion', $rmantenimiento->observacion, ['class' => 'form-control' .
        ($errors->has('observacion') ? ' is-invalid' : ''), 'placeholder' => 'Observación']) }}
        {!! $errors->first('observacion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('emantenimiento_id', 'Estatus Mantenimiento') }}</label>
    <div>
        <select name="emantenimiento_id" class="form-control form-control-rounded mb-2  
        {{ $errors->has('emantenimiento_id') ? ' is-invalid' : '' }}" placeholder="Estatus Mantenimiento">
            @foreach($demantenimiento as $emantenimiento)
                <option value="{{ $emantenimiento->id }}" {{ $rmantenimiento->emantenimiento_id == $emantenimiento->id ? 'selected' : '' }}>
                    {{ $emantenimiento->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('emantenimiento_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/rmantenimientos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
