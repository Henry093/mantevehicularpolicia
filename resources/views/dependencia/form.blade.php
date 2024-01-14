
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('provincia_id') }}</label>
    <div>
        {{ Form::text('provincia_id', $dependencia->provincia_id, ['class' => 'form-control' .
        ($errors->has('provincia_id') ? ' is-invalid' : ''), 'placeholder' => 'Provincia Id']) }}
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>provincia_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('num_distritos') }}</label>
    <div>
        {{ Form::text('num_distritos', $dependencia->num_distritos, ['class' => 'form-control' .
        ($errors->has('num_distritos') ? ' is-invalid' : ''), 'placeholder' => 'Num Distritos']) }}
        {!! $errors->first('num_distritos', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>num_distritos</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('canton_id') }}</label>
    <div>
        {{ Form::text('canton_id', $dependencia->canton_id, ['class' => 'form-control' .
        ($errors->has('canton_id') ? ' is-invalid' : ''), 'placeholder' => 'Canton Id']) }}
        {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>canton_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('parroquia_id') }}</label>
    <div>
        {{ Form::text('parroquia_id', $dependencia->parroquia_id, ['class' => 'form-control' .
        ($errors->has('parroquia_id') ? ' is-invalid' : ''), 'placeholder' => 'Parroquia Id']) }}
        {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>parroquia_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('cod_distrito') }}</label>
    <div>
        {{ Form::text('cod_distrito', $dependencia->cod_distrito, ['class' => 'form-control' .
        ($errors->has('cod_distrito') ? ' is-invalid' : ''), 'placeholder' => 'Cod Distrito']) }}
        {!! $errors->first('cod_distrito', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>cod_distrito</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nom_distrito') }}</label>
    <div>
        {{ Form::text('nom_distrito', $dependencia->nom_distrito, ['class' => 'form-control' .
        ($errors->has('nom_distrito') ? ' is-invalid' : ''), 'placeholder' => 'Nom Distrito']) }}
        {!! $errors->first('nom_distrito', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>nom_distrito</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('num_circuitos') }}</label>
    <div>
        {{ Form::text('num_circuitos', $dependencia->num_circuitos, ['class' => 'form-control' .
        ($errors->has('num_circuitos') ? ' is-invalid' : ''), 'placeholder' => 'Num Circuitos']) }}
        {!! $errors->first('num_circuitos', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>num_circuitos</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('cod_circuito') }}</label>
    <div>
        {{ Form::text('cod_circuito', $dependencia->cod_circuito, ['class' => 'form-control' .
        ($errors->has('cod_circuito') ? ' is-invalid' : ''), 'placeholder' => 'Cod Circuito']) }}
        {!! $errors->first('cod_circuito', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>cod_circuito</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nom_circuito') }}</label>
    <div>
        {{ Form::text('nom_circuito', $dependencia->nom_circuito, ['class' => 'form-control' .
        ($errors->has('nom_circuito') ? ' is-invalid' : ''), 'placeholder' => 'Nom Circuito']) }}
        {!! $errors->first('nom_circuito', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>nom_circuito</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('num_subcircuitos') }}</label>
    <div>
        {{ Form::text('num_subcircuitos', $dependencia->num_subcircuitos, ['class' => 'form-control' .
        ($errors->has('num_subcircuitos') ? ' is-invalid' : ''), 'placeholder' => 'Num Subcircuitos']) }}
        {!! $errors->first('num_subcircuitos', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>num_subcircuitos</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('cod_subcircuito') }}</label>
    <div>
        {{ Form::text('cod_subcircuito', $dependencia->cod_subcircuito, ['class' => 'form-control' .
        ($errors->has('cod_subcircuito') ? ' is-invalid' : ''), 'placeholder' => 'Cod Subcircuito']) }}
        {!! $errors->first('cod_subcircuito', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>cod_subcircuito</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('nom_subcircuito') }}</label>
    <div>
        {{ Form::text('nom_subcircuito', $dependencia->nom_subcircuito, ['class' => 'form-control' .
        ($errors->has('nom_subcircuito') ? ' is-invalid' : ''), 'placeholder' => 'Nom Subcircuito']) }}
        {!! $errors->first('nom_subcircuito', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>nom_subcircuito</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('estado_id') }}</label>
    <div>
        {{ Form::text('estado_id', $dependencia->estado_id, ['class' => 'form-control' .
        ($errors->has('estado_id') ? ' is-invalid' : ''), 'placeholder' => 'Estado Id']) }}
        {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">dependencia <b>estado_id</b> instruction.</small>
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
