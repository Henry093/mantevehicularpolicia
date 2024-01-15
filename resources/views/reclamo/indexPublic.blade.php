<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Agregamos los estilos de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Agregamos los scripts de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    
    <title>Formulario de Reclamo</title>
    <!-- Agregamos estilos personalizados -->
    <style>
        body {
            padding: 20px;
            background-color: #63a8ee;
        }
    
        form {
        max-width: 600px;
        margin: auto;
        background-color: #fff; 
        padding: 20px;
        border-radius: 8px; 
        box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }
    
        textarea {
            width: 100%;
            height: 100px;
        }
    
        .mb-3 {
            margin-bottom: 1rem;
        }
    
        .btn {
            padding: 10px 20px;
            font-size: 1rem;
            cursor: pointer;
        }
    
        .btn-primary {
            background-color: #007bff;
            color: #fff;
            border: none;
        }
    
        .btn-primary:hover {
            background-color: #0056b3;
        }
    
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
    
        .alert-success {
            color: #3c763d;
            background-color: #dff0d8;
            border-color: #d6e9c6;
        }
    
        .alert-danger {
            color: #a94442;
            background-color: #f2dede;
            border-color: #ebccd1;
        }
    
        .form-control {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 1rem;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    
        .form-control:focus {
            border-color: #007bff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>

</head>

<body>

    <div class="container">
        <tbody>
            <form action="{{ route('reclamo.store') }}" method="post">
                @csrf

                <h3 class="card-title">Formulario de Reclamos</h3><br>
                <div class="form-group mb-3">
                    <label class="form-label required">{{ Form::label('circuito_id', 'Circuito') }}</label>
                    <div>
                        <select name="circuito_id" class="form-control form-control-rounded mb-2 
                        {{ $errors->has('circuito_id') ? ' is-invalid' : '' }}" placeholder="Circuito" required>
                            <option value="">Seleccionar Circuito..</option>
                            @foreach($dcircuito as $circuito)
                                <option value="{{ $circuito->id }}" {{ $reclamo->circuito_id == $circuito->id ? 'selected' : '' }}>
                                    {{ $circuito->nombre }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('circuito_id', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label required" >{{ Form::label('subcircuito_id', 'Subcircuito') }}</label>
                    <div>
                        <select name="subcircuito_id" class="form-control form-control-rounded mb-2 
                        {{ $errors->has('subcircuito_id') ? ' is-invalid' : '' }}" placeholder="Subcircuito" required >
                        <option value="" >Seleccionar Subcircuito..</option>
                            @foreach($dsubcircuito as $subcircuito)
                                <option value="{{ $subcircuito->id }}" {{ $reclamo->subcircuito_id == $subcircuito->id ? 'selected' : '' }}>
                                    {{ $subcircuito->nombre }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('subcircuito_id', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
                <div class="form-group mb-3">
                    <label class="form-label required" >{{ Form::label('treclamo_id', 'Tipo Reclamo') }}</label>
                    <div>
                        <select name="treclamo_id" class="form-control form-control-rounded mb-2 
                        {{ $errors->has('treclamo_id') ? ' is-invalid' : '' }}" placeholder="Tipo Reclamo"  >
                        <option value="" >Seleccionar Tipo Reclamo..</option>
                            @foreach($dtreclamo as $treclamo)
                                <option value="{{ $treclamo->id }}" {{ $reclamo->treclamo_id == $treclamo->id ? 'selected' : '' }}>
                                    {{ $treclamo->nombre }}
                                </option>
                            @endforeach
                        </select>
                        {!! $errors->first('treclamo_id', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>

                <div class="mb-3">
                    <label for="detalle" class="form-label">Detalle</label>
                    <textarea name="detalle" id="detalle" class="form-control" placeholder="Ingrese el detalle del Reclamo" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="contacto" class="form-label">Contacto</label>
                    <input type="text" name="contacto" id="contacto" class="form-control" placeholder="Ingrese el número de teléfono o email" required>
                </div>

                <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ingrese sus apellidos" required>
                </div>

                <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Ingrese sus nombres" required>
                </div>
                <div class="form-footer">
                    <div class="text-end">
                        <div class="d-flex">
                            <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-primary ms-auto ajax-submit">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </tbody>
        <script>
            $(document).ready(function() {
                // Cuando cambia la selección de circuito
                $('select[name="circuito_id"]').change(function() {
                    var circuitoId = $(this).val();
                    if (circuitoId) {
                        // Realizar una solicitud AJAX para obtener los subcircuitos correspondientes al circuito seleccionado
                        $.ajax({
                            url: '/obtener-subcircuitos/' + circuitoId,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {
                                $('select[name="subcircuito_id"]').empty();
                                $('select[name="subcircuito_id"]').append(
                                    '<option value="">Seleccionar Subcircuito..</option>');
                                $.each(data, function(key, value) {
                                    $('select[name="subcircuito_id"]').append(
                                        '<option value="' + key + '">' + value +
                                        '</option>');
                                });
                            }
                        });
                    } else {
                        $('select[name="subcircuito_id"]').empty();
                    }
                });
            });
        </script>
    </div>
</body>

</html>
