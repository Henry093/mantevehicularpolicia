<div class="form-group mb-3">
    <div class="row">
        
        <div class="col-md-6">
            <label class="form-label">{{ Form::label('rmantenimiento_id', 'Registro Mantenimiento') }}</label>
            <div>
                <select name="rmantenimiento_id" class="form-control{{ $errors->has('rmantenimiento_id') ? ' is-invalid' : '' }}" placeholder="Registro Mantenimiento">
                    <option value="">Seleccionar Placa del Vehículo..</option>
                    @foreach($rmantenimientos as $rmantenimiento)
                        <option value="{{ $rmantenimiento->id }}" {{ $rvehiculo->rmantenimiento_id == $rmantenimiento->id ? 'selected' : '' }}>
                            {{ $rmantenimiento->vsubcircuito->vehiculo->placa }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('rmantenimiento_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>            
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('fecha_ingreso') }}</label>
            <div>
                {{ Form::date('fecha_ingreso', $rvehiculo->fecha_ingreso, ['class' => 'form-control' .
                ($errors->has('fecha_ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Ingreso']) }}
                {!! $errors->first('fecha_ingreso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('hora_ingreso') }}</label>
            <div>
                {{ Form::time('hora_ingreso', $rvehiculo->hora_ingreso, ['class' => 'form-control' .
                ($errors->has('hora_ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Hora Ingreso']) }}
                {!! $errors->first('hora_ingreso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('kilometraje') }}</label>
            <div>
                {{ Form::text('kilometraje', $rvehiculo->kilometraje, ['class' => 'form-control' .
                ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje actual']) }}
                {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('asunto') }}</label>
            <div>
                {{ Form::textarea('asunto', $rvehiculo->asunto, ['class' => 'form-control  ' .
                ($errors->has('asunto') ? ' is-invalid' : ''), 'placeholder' => 'Asunto']) }}
                {!! $errors->first('asunto', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('detalle') }}</label>
            <div>
                {{ Form::textarea('detalle', $rvehiculo->detalle, ['class' => 'form-control' .
                ($errors->has('detalle') ? ' is-invalid' : ''), 'placeholder' => 'Detalle']) }}
                {!! $errors->first('detalle', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">{{ Form::label('tmantenimiento_id', 'Tipo Mantenimiento') }}</label>
            <div>
                <select name="tmantenimiento_id" class="form-control{{ $errors->has('tmantenimiento_id') ? ' is-invalid' : '' }}" placeholder="Tipo Mantenimiento">
                    <option value="">Seleccionar Tipo Mantenimiento..</option>
                    @foreach($tmantenimientos as $tmantenimiento)
                        <option value="{{ $tmantenimiento->id }}" {{ $rvehiculo->tmantenimiento_id == $tmantenimiento->id ? 'selected' : '' }}>
                            {{ $tmantenimiento->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('tmantenimiento_id', '<div class="invalid-feedback">:message</div>') !!}
            </div> 
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('imagen', 'Parte Policial') }}</label>
            <div>
                {{ Form::file('imagen', ['class' => 'form-control' .
                ($errors->has('imagen') ? ' is-invalid' : ''), 'placeholder' => 'Parte policial']) }}
                {!! $errors->first('imagen', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/rvehiculos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
