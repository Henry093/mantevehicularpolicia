<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('tvehiculo_id', 'Tipo Vehículo') }}</label>
            <div>
                <select name="tvehiculo_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('tvehiculo_id') ? ' is-invalid' : '' }}" placeholder="Tipo Vehículo" >
                    <option value="" >Seleccionar Tipo Vehículo..</option>
                    @foreach($d_vehiculo as $tvehiculo)
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
                ($errors->has('placa') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese la placa',
                 'required', 'value'=> old('placa', $vehiculo->placa ?? '')]) }}
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
                ($errors->has('chasis') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el número del chasis', 'required']) }}
                {!! $errors->first('chasis', '<div class="invalid-feedback">:message</div>') !!}
            </div>            
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('marca_id', 'Marca') }}</label>
            <div>
                <select name="marca_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('marca_id') ? ' is-invalid' : '' }}" placeholder="Marca" >
                    <option value="" >Seleccionar Marca..</option>
                    @foreach($d_marca as $marca)
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
                <select name="modelo_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('modelo_id') ? ' is-invalid' : '' }}" placeholder="Modelo" >
                    <option value="" >Seleccionar Modelo..</option>
                    @foreach($d_modelo as $modelo)
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
                ($errors->has('motor') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el número del motor', 'required']) }}
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
                ($errors->has('kilometraje') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el kilometraje actual','required']) }}
                {!! $errors->first('kilometraje', '<div class="invalid-feedback">:message</div>') !!}
            </div>            
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('cilindraje', 'Cilindraje') }}</label>
            <div>
                {{ Form::text('cilindraje', $vehiculo->cilindraje, ['class' => 'form-control' .
                ($errors->has('cilindraje') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el cilindraje ej: 1.6', 'required']) }}
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
                <select name="vcarga_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('vcarga_id') ? ' is-invalid' : '' }}" placeholder="Capacidad de Carga" >
                    <option value="" >Seleccionar Capacidad de Carga..</option>
                    @foreach($d_carga as $vcarga)
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
                <select name="vpasajero_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('vpasajero_id') ? ' is-invalid' : '' }}" placeholder="Capacidad de Pasajeros" >
                    <option value="" >Seleccionar Capacidad de Pasajeros..</option>
                    @foreach($d_pasajero as $vpasajero)
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

@if ($edicion)
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('estado_id', 'Estado') }}</label>
            <div>
                <select name="estado_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('estado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
                    @foreach($d_estado as $estado)
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
@endif

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/vehiculos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Cuando cambia la selección de tipo vehículo
            $('select[name="tvehiculo_id"]').change(function() {
                var tvehiculoId  = $(this).val();
                if (tvehiculoId ) {
                    // Realizar una solicitud AJAX para obtener los cantones correspondientes a la provincia seleccionada
                    $.ajax({
                        url: '/obtener-marcas/' + tvehiculoId ,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('select[name="marca_id"]').empty();
                            $('select[name="modelo_id"]').empty();
                            $('select[name="marca_id"]').append('<option value="">Seleccionar Marca..</option>');
                            $('select[name="modelo_id"]').append('<option value="">Seleccionar Modelo..</option>');
                            $.each(data, function(key, value) {
                                $('select[name="marca_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="marca_id"]').empty();
                    $('select[name="modelo_id"]').empty();
                }
            });
    
            // Cuando cambia la selección de marca
            $('select[name="marca_id"]').change(function() {
                var marcaId = $(this).val();
                if (marcaId) {
                    // Realizar una solicitud AJAX para obtener las parroquias correspondientes al cantón seleccionado
                    $.ajax({
                        url: '/obtener-modelos/' + marcaId, 
                        dataType: "json",
                        success: function(data) {
                            $('select[name="modelo_id"]').empty();
                            $('select[name="modelo_id"]').append('<option value="">Seleccionar Modelo..</option>');
                            $.each(data, function(key, value) {
                                $('select[name="modelo_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="modelo_id"]').empty();
                }
                
            });
        });
    </script>