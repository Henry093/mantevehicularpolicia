<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('mantenimientos_id', 'Placa') }}</label>
    <div>
        <select name="mantenimientos_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('mantenimientos_id') ? ' is-invalid' : '' }}" placeholder="Placa del vehiculo" >
            <option value="" >Seleccionar Placa..</option>
            @foreach($d_mantenimientos as $mantenimientos)
                @if ($mantenimientos->id != $vehiregistro->mantenimientos_id)
                    <option value="{{ $mantenimientos->id }}" {{ $vehiregistro->mantenimientos_id == $mantenimientos->id ? 'selected' : '' }}>
                        {{ $mantenimientos->vehiculo->placa }}
                    </option>
                @endif
            @endforeach
        </select>
        {!! $errors->first('mantenimientos_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('fecha_ingreso') }}</label>
            <div>
                {{ Form::date('fecha_ingreso',  now(),  ['class' => 'form-control' .
                ($errors->has('fecha_ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Ingreso']) }}
                {!! $errors->first('fecha_ingreso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('hora_ingreso') }}</label>
            <div>
                {{ Form::time('hora_ingreso', now()->subHours(5), ['class' => 'form-control' .
                ($errors->has('hora_ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Hora Ingreso']) }}
                {!! $errors->first('hora_ingreso', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('kilometraje') }}</label>
            <div>
                {{ Form::text('kilometraje', $vehiregistro->kilometraje, ['class' => 'form-control' .
                ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Kilometraje']) }}
                {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('asunto') }}</label>
            <div>
                {{ Form::text('asunto', $vehiregistro->asunto, ['class' => 'form-control' .
                ($errors->has('asunto') ? ' is-invalid' : ''), 'placeholder' => 'Asunto']) }}
                {!! $errors->first('asunto', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('detalle') }}</label>
    <div>
        {{ Form::text('detalle', $vehiregistro->detalle, ['class' => 'form-control' .
        ($errors->has('detalle') ? ' is-invalid' : ''), 'placeholder' => 'Detalle', 'data-bs-toggle' => 'autosize']) }}
        {!! $errors->first('detalle', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('mantetipos_id', 'Tipo de Mantenimiento') }}</label>
            <div>
                <select name="mantetipos_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('mantetipos_id') ? ' is-invalid' : '' }}" placeholder="Placa del vehiculo" >
                    <option value="" >Seleccionar Tipo Mantenimiento..</option>
                    @foreach($d_mantetipos as $mantetipos)
                        <option value="{{ $mantetipos->id }}" {{ $vehiregistro->mantetipos_id == $mantetipos->id ? 'selected' : '' }}>
                            {{ $mantetipos->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('mantetipos_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('imagen') }}</label>
            <div>
                {{ Form::file('imagen', $vehiregistro->imagen, ['class' => 'form-control' .
                ($errors->has('imagen') ? ' is-invalid' : ''), 'placeholder' => 'Imagen']) }}
                {!! $errors->first('imagen', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>


<div class="form-group mb-3">

</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="#" class="btn btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">Submit</button>
            </div>
        </div>
    </div>
