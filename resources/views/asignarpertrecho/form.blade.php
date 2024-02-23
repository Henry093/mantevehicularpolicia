
<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('pertrecho_id', 'Pertrecho') }}</label>
    <div>
        <select name="pertrecho_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('pertrecho_id') ? ' is-invalid' : '' }}" placeholder="pertrecho">
            <option value="" >Seleccionar Pertrecho..</option>
            @foreach($d_pertrecho as $pertrecho)
               <option value="{{ $pertrecho->id }}" {{ $asignarpertrecho->pertrecho_id == $pertrecho->id ? 'selected' : '' }}>
                    {{ $pertrecho->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('pertrecho_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">{{ Form::label('user_id', 'user') }}</label>
    <div>
        <select name="user_id" required class="form-select form-control-rounded mb-2 
        {{ $errors->has('user_id') ? ' is-invalid' : '' }}" placeholder="user">
            <option value="" >Seleccionar Usuario..</option>
            @foreach($usuarios as $user)
               <option value="{{ $user->id }}" {{ $asignarpertrecho->user_id == $user->id ? 'selected' : '' }}>
                    {{ $user->name }} {{ $user->lastname }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/asignarpertrechos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
