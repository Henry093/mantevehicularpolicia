<div class="page-body">
    <div class="row row-deck row-cards">
        <div class="col-9 col-md-auto ">
            <div class="card">
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label class="form-label">{{ Form::label('search', 'Buscar Vehículo') }}</label>
                        <div class="input-group">
                            <input type="text" id="searchInput" class="form-control"
                                placeholder="Ingrese la Placa">
                            <div class="col-6 col-md-auto ms-auto d-print-none">
                                <div class="btn-list">
                                    <span class="d-none d-sm-inline">
                                        <a href="#" class="btn btn-blue">
                                            @lang('Search')
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row row-deck row-cards">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label required">{{ Form::label('rmantenimiento_id', 'Fecha Solicitud') }}</label>
                            <div>
                                <select name="rmantenimiento_id" class="form-control form-control-rounded mb-2  
                                {{ $errors->has('rmantenimiento_id') ? ' is-invalid' : '' }}" placeholder="Fecha Solicitud">
                                    @foreach($drmantenimiento as $rmantenimiento)
                                        <option value="{{ $rmantenimiento->id }}" {{ $rmantenimiento->rmantenimiento_id == $rmantenimiento->id ? 'selected' : '' }}>
                                            {{ $rmantenimiento->fecha_inicio }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('rmantenimiento_id', '<div class="invalid-feedback">:message</div>') !!}
                            </div>                            
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">   {{ Form::label('rvehiculo_id') }}</label>
                            <div>
                                {{ Form::text('rvehiculo_id', $evehiculo->rvehiculo_id, ['class' => 'form-control' .
                                ($errors->has('rvehiculo_id') ? ' is-invalid' : ''), 'placeholder' => 'Rvehiculo Id']) }}
                                {!! $errors->first('rvehiculo_id', '<div class="invalid-feedback">:message</div>') !!}
                                <small class="form-hint">evehiculo <b>rvehiculo_id</b> instruction.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label required">   {{ Form::label('fecha_entrega') }}</label>
                            <div>
                                {{ Form::date('fecha_entrega', $evehiculo->fecha_entrega, ['class' => 'form-control' .
                                ($errors->has('fecha_entrega') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Entrega']) }}
                                {!! $errors->first('fecha_entrega', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">   {{ Form::label('p_retiro', 'Persona Retiro') }}</label>
                            <div>
                                {{ Form::text('p_retiro', $evehiculo->p_retiro, ['class' => 'form-control' .
                                ($errors->has('p_retiro') ? ' is-invalid' : ''), 'placeholder' => 'Nombre persona que retira el vehículo']) }}
                                {!! $errors->first('p_retiro', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">   {{ Form::label('km_actual') }}</label>
                            <div>
                                {{ Form::text('km_actual', $evehiculo->km_actual, ['class' => 'form-control' .
                                ($errors->has('km_actual') ? ' is-invalid' : ''), 'placeholder' => 'Km Actual']) }}
                                {!! $errors->first('km_actual', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">   {{ Form::label('km_proximo') }}</label>
                            <div>
                                {{ Form::text('km_proximo', $evehiculo->km_proximo, ['class' => 'form-control' .
                                ($errors->has('km_proximo') ? ' is-invalid' : ''), 'placeholder' => 'Km Proximo']) }}
                                {!! $errors->first('km_proximo', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group mb-3">
                    <div class="row">
                            <label class="form-label">   {{ Form::label('observaciones') }}</label>
                            <div>
                                {{ Form::text('observaciones', $evehiculo->observaciones, ['class' => 'form-control' .
                                ($errors->has('observaciones') ? ' is-invalid' : ''), 'placeholder' => 'Observaciones']) }}
                                {!! $errors->first('observaciones', '<div class="invalid-feedback">:message</div>') !!}
                            </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <div class="form-footer">
        <div class="text-end">
            <div class="d-flex">
                <a href="/evehiculos" class="btn btn-danger">@lang('Cancel')</a>
                <button type="submit" class="btn btn-primary ms-auto ajax-submit">@lang('Submit')</button>
            </div>
        </div>
    </div>
