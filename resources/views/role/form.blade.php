<div class="card">
    <div class="card-body">
        {!! Form::open(['route' => 'roles.store']) !!}
            <div class="form-group mb-3">
                <label class="form-label required"> {!! Form::label('name', 'Nombre') !!}</label>
                {!! Form::text('name', null, ['class' => 'form-control '.
                ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Ingrese el nombre del Rol', 'required']) !!}

                    {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
          
            </div>
            <div class="card">
            <div class="card-body">
                <h2 class="h3">Lista de Permisos</h2>

                @foreach ($permissions as $permission)
                    <div>
                        <label class="form-check ">
                            {!! Form::checkbox('permissions[]', $permission->id, null, ['class'=>'mr-1']) !!}
                                    {{ $permission->description }}
                        </label>
                    </div>
                @endforeach
            </div></div>
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary m-3']) !!}
            
        {!! Form::close() !!}
    </div>
</div> 
