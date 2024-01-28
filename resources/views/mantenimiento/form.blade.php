<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('user_id', 'Usuario') }}</label>
    <div>
        {{ Form::text('user_id', $user->name . ' ' . $user->lastname, ['class' => 'form-control', 'readonly' => true, 'placeholder' => 'Usuario']) }}

    </div>
</div>



<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('user_id') }}</label>
    <div>
        {{ Form::text('user_id', $mantenimiento->user_id, ['class' => 'form-control' .
        ($errors->has('user_id') ? ' is-invalid' : ''), 'placeholder' => 'User Id']) }}
        {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">mantenimiento <b>user_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('vehiculo_id') }}</label>
    <div>
        {{ Form::text('vehiculo_id', $mantenimiento->vehiculo_id, ['class' => 'form-control' .
        ($errors->has('vehiculo_id') ? ' is-invalid' : ''), 'placeholder' => 'Vehiculo Id']) }}
        {!! $errors->first('vehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">mantenimiento <b>vehiculo_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('fecha') }}</label>
    <div>
        {{ Form::date('fecha', $mantenimiento->fecha, ['class' => 'form-control' .
        ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
        {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('hora') }}</label>
    <div>
        {{ Form::time('hora', $mantenimiento->hora, ['class' => 'form-control' .
        ($errors->has('hora') ? ' is-invalid' : ''), 'placeholder' => 'Hora']) }}
        {!! $errors->first('hora', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('kilometraje') }}</label>
    <div>
        {{ Form::text('kilometraje', $mantenimiento->kilometraje, ['class' => 'form-control' .
        ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje']) }}
        {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('observaciones') }}</label>
    <div>
        {{ Form::textarea('observaciones', $mantenimiento->observaciones, ['class' => 'form-control' .
        ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones']) }}
        {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

@if ($edicion)
    <div class="form-group mb-3">
        <label class="form-label required" >{{ Form::label('mantestado_id', 'Estado del Mantenimieto') }}</label>
        <div>
            <select name="mantestado_id" required class="form-select form-control-rounded mb-2 
            {{ $errors->has('mantestado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
                <option value="" >Seleccionar Cantón..</option>
                @foreach($d_mantestado as $mantestado)
                     <option value="{{ $mantestado->id }}" {{ $mantenimiento->mantestado_id == $mantestado->id ? 'selected' : '' }}>
                        {{ $mantestado->nombre }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('mantestado_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
@endif

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="#" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">Submit</button>
            </div>
        </div>
    </div>
