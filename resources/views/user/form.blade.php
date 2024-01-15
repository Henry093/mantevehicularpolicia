<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >   {{ Form::label('name', 'Nombres') }}</label>
            <div>
                {{ Form::text('name', $user->name, ['class' => 'form-control' .
                ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese los nombres']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('lastname', 'Apellidos') }}</label>
            <div>
                {{ Form::text('lastname', $user->lastname, ['class' => 'form-control' .
                ($errors->has('lastname') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese los apellidos']) }}
                {!! $errors->first('lastname', '<div class="invalid-feedback">:message</div>') !!}
            </div>           
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('cedula', 'Cédula') }}</label>
            <div>
                {{ Form::text('cedula', $user->cedula, ['class' => 'form-control' .
                ($errors->has('cedula') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese la cédula']) }}
                {!! $errors->first('cedula', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required">   {{ Form::label('fecha_nacimiento') }}</label>
            <div>
                {{ Form::date('fecha_nacimiento', $user->fecha_nacimiento, ['class' => 'form-control' .
                ($errors->has('fecha_nacimiento') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Nacimiento']) }}
                {!! $errors->first('fecha_nacimiento', '<div class="invalid-feedback">:message</div>') !!}
            </div>           
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('sangre_id', 'Tipo Sangre') }}</label>
            <div>
                <select name="sangre_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('sangre_id') ? ' is-invalid' : '' }}" placeholder="Tipo Sangre" >
                    <option value="" >Seleccionar Tipo Sangre..</option>
                    @foreach($dsangre as $sangre)
                        <option value="{{ $sangre->id }}" {{ $user->sangre_id == $sangre->id ? 'selected' : '' }}>
                            {{ $sangre->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('sangre_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('provincia_id', 'Provincia') }}</label>
            <div>
                <select name="provincia_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia" >
                    <option value="" >Seleccionar Provincia..</option>
                    @foreach($dprovincia as $provincia)
                        <option value="{{ $provincia->id }}" {{ $user->provincia_id == $provincia->id ? 'selected' : '' }}>
                            {{ $provincia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('canton_id', 'Cantón') }}</label>
            <div>
                <select name="canton_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('canton_id') ? ' is-invalid' : '' }}" placeholder="Cantón" >
                    <option value="" >Seleccionar Cantón..</option>
                    @foreach($dcanton as $canton)
                        <option value="{{ $canton->id }}" {{ $user->canton_id == $canton->id ? 'selected' : '' }}>
                            {{ $canton->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('parroquia_id', 'Parroquia') }}</label>
            <div>
                <select name="parroquia_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('parroquia_id') ? ' is-invalid' : '' }}" placeholder="Parroquia" >
                    <option value="" >Seleccionar Parroquia..</option>
                    @foreach($dparroquia as $parroquia)
                        <option value="{{ $parroquia->id }}" {{ $user->parroquia_id == $parroquia->id ? 'selected' : '' }}>
                            {{ $parroquia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('telefono', 'Teléfono') }}</label>
            <div>
                {{ Form::text('telefono', $user->telefono, ['class' => 'form-control' .
                ($errors->has('telefono') ? ' is-invalid' : ''), 'placeholder' => 'Teléfono']) }}
                {!! $errors->first('telefono', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('grado_id', 'Grado') }}</label>
            <div>
                <select name="grado_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('grado_id') ? ' is-invalid' : '' }}" placeholder="Grado" >
                    <option value="" >Seleccionar Grado..</option>
                    @foreach($dgrado as $grado)
                        <option value="{{ $grado->id }}" {{ $user->grado_id == $grado->id ? 'selected' : '' }}>
                            {{ $grado->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('grado_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('rango_id', 'Rango') }}</label>
            <div>
                <select name="rango_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('rango_id') ? ' is-invalid' : '' }}" placeholder="Rango" >
                    <option value="" >Seleccionar Rango..</option>
                    @foreach($drango as $rango)
                        <option value="{{ $rango->id }}" {{ $user->rango_id == $rango->id ? 'selected' : '' }}>
                            {{ $rango->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('rango_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('estado_id', 'Estado') }}</label>
            <div>
                <select name="estado_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('estado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
                    @foreach($destado as $estado)
                        <option value="{{ $estado->id }}" {{ $user->estado_id == $estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('usuario') }}</label>
            <div>
                {{ Form::text('usuario', $user->usuario, ['class' => 'form-control' .
                ($errors->has('usuario') ? ' is-invalid' : ''), 'placeholder' => 'Usuario']) }}
                {!! $errors->first('usuario', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">   {{ Form::label('email') }}</label>
            <div>
                {{ Form::text('email', $user->email ?? '@policianacional.gob.ec',
                 ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email']) }}
                {!! $errors->first('email', '<div class="invalid-feedback">:message</div>') !!}
            </div>            
        </div>
    </div>
</div>
    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/users" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
