
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('user_id') }}</label>
    <div>
        {{ Form::text('user_id', $novedade->user_id, ['class' => 'form-control' .
        ($errors->has('user_id') ? ' is-invalid' : ''), 'placeholder' => 'User Id']) }}
        {!! $errors->first('user_id', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">novedade <b>user_id</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('mensaje') }}</label>
    <div>
        {{ Form::text('mensaje', $novedade->mensaje, ['class' => 'form-control' .
        ($errors->has('mensaje') ? ' is-invalid' : ''), 'placeholder' => 'Mensaje']) }}
        {!! $errors->first('mensaje', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">novedade <b>mensaje</b> instruction.</small>
    </div>
</div>
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('atendida') }}</label>
    <div>
        {{ Form::text('atendida', $novedade->atendida, ['class' => 'form-control' .
        ($errors->has('atendida') ? ' is-invalid' : ''), 'placeholder' => 'Atendida']) }}
        {!! $errors->first('atendida', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">novedade <b>atendida</b> instruction.</small>
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
