

<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('user_id', 'Usuario') }}</label>
    <div>
        {{ Form::hidden('user_id', $user->id) }} <!-- Cambiado a un campo oculto para enviar el ID del usuario -->
        {{ Form::text('user_name', $user->name . ' ' . $user->lastname, ['class' => 'form-control', 'readonly' => true, 'placeholder' => 'Usuario']) }}
    </div>
</div>

<div class="form-group mb-3">
    <label class="form-label required">   {{ Form::label('mensaje') }}</label>
    <div>
        {{ Form::textarea('mensaje', $novedade->mensaje, ['class' => 'form-control' .
        ($errors->has('mensaje') ? ' is-invalid' : ''), 'placeholder' => 'Mensaje', 'required']) }}
        {!! $errors->first('mensaje', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
@if ($edicion)
<div class="col-md-6">
    <label class="form-label required">{{ Form::label('tnovedad_id', 'Estatus') }}</label>
    <div>
        <select name="tnovedad_id" required class="form-select form-control-rounded mb-2 
            {{ $errors->has('tnovedad_id') ? ' is-invalid' : '' }}" placeholder="Estatus">
            <option value="">Seleccionar Estatus..</option>
            @foreach ($d_tnovedad as $tnovedad)
                <option
                    value="{{ $tnovedad->id }}"{{ $novedade->tnovedad_id == $tnovedad->id ? 'selected' : '' }}>
                    {{ $tnovedad->nombre }}
                </option>
            @endforeach
        </select>
        {!! $errors->first('tnovedad_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
@endif

    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/novedades" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
