

<div class="form-group mb-3">
    <label class="form-label">{{ Form::label('tvehiculo_id', 'Tipo Vehículo') }}</label>
    <div>
        <select name="tvehiculo_id" class="form-select form-control-rounded mb-2 {{ $errors->has('tvehiculo_id') ? ' is-invalid' : '' }}" placeholder="Tipo Vehículo">
            <option value="" >Seleccionar Tipo Vehículo..</option>
            @foreach($tvehiculos as $tvehiculo)
                <option value="{{ $tvehiculo->id }}" {{ $marca->tvehiculo_id == $tvehiculo->id ? 'selected' : '' }}>
                    {{ $tvehiculo->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('tvehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre') }}</label>
    <div>
        {{ Form::text('nombre', $marca->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre de la Marca']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/tvehiculos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
