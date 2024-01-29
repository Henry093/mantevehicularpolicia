
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('user_id', 'Usuario') }}</label>
    <div>
        {{ Form::text('user_id', $user->name . ' ' . $user->lastname, ['class' => 'form-control', 'readonly' => true, 'placeholder' => 'Usuario']) }}
    </div>
</div>

@if ($d_vehiculo)
    <div class="form-group mb-3">
        <label class="form-label">   {{ Form::label('vehiculo_id', 'Vehículo') }}</label>
        <div>
            {{ Form::text('vehiculo_id', $d_vehiculo->vehisubcircuito->vehiculo->placa, ['class' => 'form-control', 'readonly' => true, 'placeholder' => 'Vehículo']) }}
        </div>
    </div>

    <div class="form-group mb-3">
        <div class="row">
            <div class="col-md-6">
                <label class="form-label required">   {{ Form::label('fecha') }}</label>
                <div>
                    {{ Form::date('fecha', now(), ['class' => 'form-control' .
                    ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha', 'required']) }}
                    {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
            <div class="col-md-6">
                <label class="form-label required">   {{ Form::label('hora') }}</label>
                <div>
                    {{ Form::time('hora', now()->subHours(5), ['class' => 'form-control' .
                    ($errors->has('hora') ? ' is-invalid' : ''), 'placeholder' => 'Hora', 'required']) }}
                    {!! $errors->first('hora', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>  
        </div>
    </div>

    <div class="form-group mb-3">
        <label class="form-label required">   {{ Form::label('kilometraje', 'Kilometraje Actual') }}</label>
        <div>
            {{ Form::text('kilometraje', $mantenimiento->kilometraje, ['class' => 'form-control' .
            ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el kilometraje actual del vehículo', 'readonly' => !$d_vehiculo, 'required']) }}
            {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div class="form-group mb-3">
        <label class="form-label required">   {{ Form::label('observaciones') }}</label>
        <div>
            {{ Form::textarea('observaciones', $mantenimiento->observaciones, ['class' => 'form-control' .
            ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones adicionales', 'readonly' => !$d_vehiculo, 'required']) }}
            {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>


    @if ($edicion)
        <div class="form-group mb-3">
            <label class="form-label required" >{{ Form::label('mantestado_id', 'Estado del Mantenimieto') }}</label>
            <div>
                <select name="mantestado_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('mantestado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
                    <option value="" >Seleccionar Estado..</option>
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
                <a href="#" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
@else
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (!document.getElementById("vehiculo-asignado")) {
            // Si no hay un vehículo asignado, ocultar el resto del formulario
            document.querySelector(".form-group:nth-child(3)").style.display = "none";
            document.querySelector(".form-group:nth-child(4)").style.display = "none";
            document.querySelector(".form-group:nth-child(5)").style.display = "none";
            document.querySelector(".form-group:nth-child(6)").style.display = "none";
            document.querySelector(".form-footer").style.display = "none";

            // Mostrar el botón "Reportar novedad"
            document.querySelector(".col-md-6.text-center").style.display = "block";
        }
    });
</script>
<div class="form-group mb-3">
    <div class="row align-items-center" id="vehiculo-asignado">
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('vehiculo_id', 'Vehículo') }}</label>
            <div>
                <span class="form-control text-danger">El usuario no tiene asignado un vehículo</span>
            </div>
        </div>
        <div class="col-md-6 text-center">
            <div>
                <br>
                <a href="{{ route('novedades.create') }}" class="btn btn-primary">Reportar novedad</a>
            </div>
        </div>
    </div>
</div>
@endif



