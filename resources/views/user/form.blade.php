
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('name') }}</label>
    <div>
        {{ Form::text('name', $user->name, ['class' => 'form-control' .
        ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>name</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('lastname') }}</label>
    <div>
        {{ Form::text('lastname', $user->lastname, ['class' => 'form-control' .
        ($errors->has('lastname') ? ' is-invalid' : ''), 'placeholder' => 'Lastname']) }}
        {!! $errors->first('lastname', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>lastname</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('cedula') }}</label>
    <div>
        {{ Form::text('cedula', $user->cedula, ['class' => 'form-control' .
        ($errors->has('cedula') ? ' is-invalid' : ''), 'placeholder' => 'Cedula']) }}
        {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>cedula</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('fecha_nacimiento') }}</label>
    <div>
        {{ Form::text('fecha_nacimiento', $user->fecha_nacimiento, ['class' => 'form-control' .
        ($errors->has('fecha_nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento']) }}
        {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>fecha_nacimiento</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('sangre_id') }}</label>
    <div>
        {{ Form::text('sangre_id', $user->sangre_id, ['class' => 'form-control' .
        ($errors->has('sangre_id') ? ' is-invalid' : ''), 'placeholder' => 'Sangre Id']) }}
        {!! $errors->first('sangre_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>sangre_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('provincia_id') }}</label>
    <div>
        {{ Form::text('provincia_id', $user->provincia_id, ['class' => 'form-control' .
        ($errors->has('provincia_id') ? ' is-invalid' : ''), 'placeholder' => 'Provincia Id']) }}
        {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>provincia_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('canton_id') }}</label>
    <div>
        {{ Form::text('canton_id', $user->canton_id, ['class' => 'form-control' .
        ($errors->has('canton_id') ? ' is-invalid' : ''), 'placeholder' => 'Canton Id']) }}
        {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>canton_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('parroquia_id') }}</label>
    <div>
        {{ Form::text('parroquia_id', $user->parroquia_id, ['class' => 'form-control' .
        ($errors->has('parroquia_id') ? ' is-invalid' : ''), 'placeholder' => 'Parroquia Id']) }}
        {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>parroquia_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('telefono') }}</label>
    <div>
        {{ Form::text('telefono', $user->telefono, ['class' => 'form-control' .
        ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Telefono']) }}
        {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>telefono</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('grado_id') }}</label>
    <div>
        {{ Form::text('grado_id', $user->grado_id, ['class' => 'form-control' .
        ($errors->has('grado_id') ? ' is-invalid' : ''), 'placeholder' => 'Grado Id']) }}
        {!! $errors->first('grado_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>grado_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('rango_id') }}</label>
    <div>
        {{ Form::text('rango_id', $user->rango_id, ['class' => 'form-control' .
        ($errors->has('rango_id') ? ' is-invalid' : ''), 'placeholder' => 'Rango Id']) }}
        {!! $errors->first('rango_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>rango_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('estado_id') }}</label>
    <div>
        {{ Form::text('estado_id', $user->estado_id, ['class' => 'form-control' .
        ($errors->has('estado_id') ? ' is-invalid' : ''), 'placeholder' => 'Estado Id']) }}
        {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>estado_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('usuario') }}</label>
    <div>
        {{ Form::text('usuario', $user->usuario, ['class' => 'form-control' .
        ($errors->has('usuario') ? ' is-invalid' : ''), 'placeholder' => 'Usuario']) }}
        {!! $errors->first('usuario', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>usuario</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('email') }}</label>
    <div>
        {{ Form::text('email', $user->email, ['class' => 'form-control' .
        ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email']) }}
        {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">user <b>email</b> instruction.</small>
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
