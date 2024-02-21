<div class="col-md-12">
</div>
<div class="form-group mb-3">
    <div class="row">
        @if ($edicion)
        <div class="col-md-6">
            <label class="form-label required">{{ Form::label('vehirecepciones_id', 'Orden de Mantenimiento') }}</label>
            <div>
                <select name="vehirecepciones_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('vehirecepciones_id') ? ' is-invalid' : '' }}" placeholder="Orden">
                    <option value="">Seleccionar Orden de Mantenimiento..</option>
                    @foreach($d_vehirecepciones as $vehirecepciones)
                        @if (!in_array($vehirecepciones->id, $ordenesSeleccionadas))
                            <option value="{{ $vehirecepciones->id }}" {{ $vehientrega->vehirecepciones_id == $vehirecepciones->id ? 'selected' : '' }}>
                                {{ $vehirecepciones->mantenimiento->orden }}
                            </option>
                        @endif
                    @endforeach
                </select>
                {!! $errors->first('vehirecepciones_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        @else
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('vehirecepciones_id', 'Orden de Mantenimiento') }}</label>
            <div>
                <select name="vehirecepciones_id" required class="form-select form-control-rounded mb-2 
                {{ $errors->has('vehirecepciones_id') ? ' is-invalid' : '' }}" placeholder="Orden de Mantenimiento" >
                    <option value="" >Seleccionar Orden de Mantenimiento..</option>
                    @foreach($d_vehirecepciones as $vehirecepciones)
                        <option value="{{ $vehirecepciones->id }}" {{ $vehientrega->vehirecepciones_id == $vehirecepciones->id ? 'selected' : '' }}>
                            {{ $vehirecepciones->mantenimiento->orden }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('vehirecepciones_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        @endif
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('fecha_entrega') }}</label>
            <div>
                {{ Form::date('fecha_entrega',  now(), ['class' => 'form-control' .
                ($errors->has('fecha_entrega') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Entrega', 'required']) }}
                {!! $errors->first('fecha_entrega', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('p_retiro', 'Nombre Policía') }}</label>
            <div>
                {{ Form::text('p_retiro', $vehientrega->p_retiro, ['class' => 'form-control' .
                ($errors->has('p_retiro') ? ' is-invalid' : ''), 'placeholder' => 'Nombre de la persona que retira el vehículo', 'required']) }}
                {!! $errors->first('p_retiro', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('km_actual') }}</label>
            <div>
                {{ Form::text('km_actual', $vehientrega->km_actual, ['class' => 'form-control' .
                ($errors->has('km_actual') ? ' is-invalid' : ''), 'placeholder' => 'Km Actual', 'required']) }}
                {!! $errors->first('km_actual', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('observaciones') }}</label>
    <div>
        {{ Form::textarea('observaciones', $vehientrega->observaciones, ['class' => 'form-control' .
        ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones', 'required']) }}
        {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/vehientregas" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
