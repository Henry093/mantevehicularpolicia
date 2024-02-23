<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('tpertrecho_id', 'Tipo Pertrecho') }}</label>
    <div>
        <select name="tpertrecho_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('tpertrecho_id') ? ' is-invalid' : '' }}" placeholder="Tipo Vehículo" >
            <option value="" >Seleccionar Tipo Pertrecho..</option>
            @foreach($d_tpertrecho as $tpertrecho)
                <option value="{{ $tpertrecho->id }}" {{ $pertrecho->tpertrecho_id == $tpertrecho->id ? 'selected' : '' }}>
                    {{ $tpertrecho->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('tpertrecho_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nombre') }}</label>
    <div>
        {{ Form::text('nombre', $pertrecho->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('descripcion') }}</label>
    <div>
        {{ Form::text('descripcion', $pertrecho->descripcion, ['class' => 'form-control' .
        ($errors->has('descripcion') ? ' is-invalid' : ''), 'placeholder' => 'Descripción']) }}
        {!! $errors->first('descripcion', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('codigo') }}</label>
    <div>
        {{ Form::text('codigo', $pertrecho->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Código']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/pertrechos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
