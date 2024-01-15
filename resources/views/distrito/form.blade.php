
<div class="form-group mb-3">
    <label class="form-label required" >{{ Form::label('canton_id', 'Cantón') }}</label>
    <div>
        <select name="canton_id" class="form-control form-control-rounded mb-2 
        {{ $errors->has('canton_id') ? ' is-invalid' : '' }}" placeholder="Cantón" required>
            <option value="" >Seleccionar Cantón..</option>
            @foreach($dcanton as $canton)
                <option value="{{ $canton->id }}" {{ $distrito->canton_id == $canton->id ? 'selected' : '' }}>
                    {{ $canton->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('canton_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('nombre') }}</label>
    <div>
        {{ Form::text('nombre', $distrito->nombre, ['class' => 'form-control' .
        ($errors->has('nombre') ? ' is-invalid' : ''), 'placeholder' => 'Nombre', 'required']) }}
        {!! $errors->first('nombre', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('codigo', 'Código') }}</label>
    <div>
        {{ Form::text('codigo', $distrito->codigo, ['class' => 'form-control' .
        ($errors->has('codigo') ? ' is-invalid' : ''), 'placeholder' => 'Código', 'required']) }}
        {!! $errors->first('codigo', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/distritos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
