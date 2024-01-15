
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('user_id', 'Usuario') }}</label>
    <div>
        <select name="user_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('user_id') ? ' is-invalid' : '' }}" placeholder="Usuario" >
        <option value="" >Seleccionar Usuario..</option>
            @foreach($duser as $user)
                <option value="{{ $user->id }}" {{ $usubcircuito->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} {{ $user->lastname }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>    
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('dependencia_id', 'Subcircuito') }}</label>
    <div>
        <select name="dependencia_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('dependencia_id') ? ' is-invalid' : '' }}" placeholder="Dependencia" >
        <option value="" >Seleccionar Dependencia..</option>
            @foreach($ddependencia as $dependencia)
                <option value="{{ $dependencia->id }}" {{ $usubcircuito->dependencia_id == $dependencia->id ? 'selected' : '' }}>
                    {{ $dependencia->subcircuito->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('dependencia_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('asignacion_id', 'Asignación') }}</label>
    <div>
        <select name="asignacion_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('asignacion_id') ? ' is-invalid' : '' }}" placeholder="Asignación" >
            @foreach($dasignacion as $asignacion)
                <option value="{{ $asignacion->id }}" {{ $usubcircuito->asignacion_id == $asignacion->id ? 'selected' : '' }}>
                    {{ $asignacion->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('asignacion_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('estado_id', 'Estado') }}</label>
    <div>
        <select name="estado_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('estado_id') ? ' is-invalid' : '' }}" placeholder="Estado" >
            @foreach($destado as $estado)
                <option value="{{ $estado->id }}" {{ $usubcircuito->estado_id == $estado->id ? 'selected' : '' }}>
                       {{ $estado->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('estado_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/usubcircuitos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
