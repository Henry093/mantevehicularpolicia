
<div class="form-group mb-3">
    <label class="form-label">   {{ Form::label('novedad') }}</label>
    <div>
        {{ Form::text('novedad', $nmantenimiento->novedad, ['class' => 'form-control' .
        ($errors->has('novedad') ? ' is-invalid' : ''), 'placeholder' => 'Novedad']) }}
        {!! $errors->first('novedad', '<div class="invalid-feedback">:message</div>') !!}
        <small class="form-hint">nmantenimiento <b>novedad</b> instruction.</small>
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
