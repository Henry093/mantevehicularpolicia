
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('asignarvehiculos_id') }}</label>
    <div>
        {{ Form::text('asignarvehiculos_id', $manteregistro->asignarvehiculos_id, ['class' => 'form-control' .
        ($errors->has('asignarvehiculos_id') ? ' is-invalid' : ''), 'placeholder' => 'Asignarvehiculos Id']) }}
        {!! $errors->first('asignarvehiculos_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">manteregistro <b>asignarvehiculos_id</b> instruction.</small>
    </div>
</div>

<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('fecha_inicio') }}</label>
            <div>
                {{ Form::date('fecha_inicio',  now()->toDateString(), ['class' => 'form-control' .
                ($errors->has('fecha_inicio') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Inicio', 'required']) }}
                {!! $errors->first('fecha_inicio', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('hora') }}</label>
            <div>
                {{ Form::time('hora', now()->subHours(5)->format('H:i'), ['class' => 'form-control' .
                ($errors->has('hora') ? ' is-invalid' : ''), 'placeholder' => 'Hora', 'required']) }}
                {!! $errors->first('hora', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('kilometraje') }}</label>
    <div>
        {{ Form::text('kilometraje', $manteregistro->kilometraje, ['class' => 'form-control' .
        ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el Kilometraje actual del vehículo', 'required']) }}
        {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('observacion', 'Observación') }}</label>
    <div>
        {{ Form::textarea('observacion', $manteregistro->observacion, ['class' => 'form-control' .
        ($errors->has('observacion') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese alguna observación']) }}
        {!! $errors->first('observacion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
@if ($edicion)
    <div class="col-md-6">
        <label class="form-label required">{{ Form::label('asignacion_id', 'Estado Asignación') }}</label>
        <div>
            <select name="asignacion_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('asignacion_id') ? ' is-invalid' : '' }}" placeholder="Estado Asignación">
                <option value="">Seleccionar Estado Asignación..</option>
                @foreach ($d_asignacion as $asignacion)
                    <option
                        value="{{ $asignacion->id }}"{{ $vehisubcircuito->asignacion_id == $asignacion->id ? 'selected' : '' }}>
                        {{ $asignacion->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('asignacion_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
@endif
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('novedad') }}</label>
    <div>
        {{ Form::text('novedad', $manteregistro->novedad, ['class' => 'form-control' .
        ($errors->has('novedad') ? ' is-invalid' : ''), 'placeholder' => 'Novedad']) }}
        {!! $errors->first('novedad', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">manteregistro <b>novedad</b> instruction.</small>
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
