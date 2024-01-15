<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('provincia_id', 'Provincia') }}</label>
            <div>
                <select name="provincia_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('provincia_id') ? ' is-invalid' : '' }}" placeholder="Provincia" >
                    <option value="" >Seleccionar Provincia..</option>
                    @foreach($dprovincia as $provincia)
                        <option value="{{ $provincia->id }}" {{ $dependencia->provincia_id == $provincia->id ? 'selected' : '' }}>
                            {{ $provincia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('provincia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('canton_id', 'Cantón') }}</label>
            <div>
                <select name="canton_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('canton_id') ? ' is-invalid' : '' }}" placeholder="Cantón" >
                    <option value="" >Seleccionar Cantón..</option>
                    @foreach($dcanton as $canton)
                        <option value="{{ $canton->id }}" {{ $dependencia->canton_id == $canton->id ? 'selected' : '' }}>
                            {{ $canton->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('parroquia_id', 'Parroquia') }}</label>
            <div>
                <select name="parroquia_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('parroquia_id') ? ' is-invalid' : '' }}" placeholder="Parroquia" >
                    <option value="" >Seleccionar Parroquia..</option>
                    @foreach($dparroquia as $parroquia)
                        <option value="{{ $parroquia->id }}" {{ $dependencia->parroquia_id == $parroquia->id ? 'selected' : '' }}>
                            {{ $parroquia->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('parroquia_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('distrito_id', 'Distrito') }}</label>
            <div>
                <select name="distrito_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('distrito_id') ? ' is-invalid' : '' }}" placeholder="Distrito" >
                <option value="" >Seleccionar Circuito..</option>
                    @foreach($ddistrito as $distrito)
                        <option value="{{ $distrito->id }}" {{ $dependencia->distrito_id == $distrito->id ? 'selected' : '' }}>
                            {{ $distrito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('distrito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('circuito_id', 'Circuito') }}</label>
            <div>
                <select name="circuito_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('circuito_id') ? ' is-invalid' : '' }}" placeholder="Circuito" >
                <option value="" >Seleccionar Circuito..</option>
                    @foreach($dcircuito as $circuito)
                        <option value="{{ $circuito->id }}" {{ $dependencia->circuito_id == $circuito->id ? 'selected' : '' }}>
                            {{ $circuito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('circuito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('subcircuito_id', 'Subcircuito') }}</label>
            <div>
                <select name="subcircuito_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('subcircuito_id') ? ' is-invalid' : '' }}" placeholder="Subcircuito" >
                <option value="" >Seleccionar Subcircuito..</option>
                    @foreach($dsubcircuito as $subcircuito)
                        <option value="{{ $subcircuito->id }}" {{ $dependencia->subcircuito_id == $subcircuito->id ? 'selected' : '' }}>
                            {{ $subcircuito->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('subcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>
<div class="form-group mb-3">
    <div class="row">
        <div class="col-md-6">
            <label class="form-label required" >{{ Form::label('estado_id', 'Estado') }}</label>
            <div>
                <select name="estado_id" class="form-control form-control-rounded mb-2 
                {{ $errors->has('estado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
                    @foreach($destado as $estado)
                        <option value="{{ $estado->id }}" {{ $dependencia->estado_id == $estado->id ? 'selected' : '' }}>
                            {{ $estado->nombre }}
                        </option>
                    @endforeach
                </select>
                {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>


    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/dependencias" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
