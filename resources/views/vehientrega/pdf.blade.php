<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Mantenimiento</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Agrega estilos personalizados aquí si es necesario */
        html,
        body {
            height: 96%;
        }

        .container {
            min-height: 100%;
            position: relative;
        }

        footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 60px;
            /* Altura del footer */
            background-color: #d3d3d3;
            /* Color de fondo del footer */
            text-align: center;
            padding-top: 20px;
            /* Espacio interno superior */
        }

        .page-body {
            page-break-inside: avoid;
            margin-bottom: 100px;
            /* Espacio al final de la página */
        }

        .table-container {
            margin-top: 100px;
            /* Espacio al principio de la tabla */
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4" style="text-align: center;">Policía Nacional del Ecuador</h1>

        <h2 class="text-2xl font-bold mb-4" style="text-align: center;">Sub Zona 7 - Loja</h2>

        <div class="text-center">
            <img src="assets/escudo.png" alt="" width="90px" height="90px" class="mx-auto">
        </div>

        <div class="page-body">
            <div class="container-xl">
                <div class="row row-deck row-cards">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-body">
                                    <div class="form-group text-center"><br>
                                        <h1 class="text-2xl font-bold mb-4">Informe Mantenimiento</h1>
                                        <h3 class="text-1x2 font-bold mb-4">Orden # {{ $vehientrega->vehirecepcione->mantenimiento->orden }}</h3><br>
                                    </div>
                                    <div class="form-group">
                                        <strong>Tipo Vehículo:</strong>
                                        {{ $vehientrega->vehirecepcione->mantenimiento->vehiculo->tvehiculo->nombre }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Marca:</strong>
                                        {{ $vehientrega->vehirecepcione->mantenimiento->vehiculo->marca->nombre }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Modelo:</strong>
                                        {{ $vehientrega->vehirecepcione->mantenimiento->vehiculo->modelo->nombre }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Fecha Solicitud:</strong>
                                        {{ $vehientrega->vehirecepcione->mantenimiento->fecha }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Fecha Registro:</strong>
                                        {{ $vehientrega->vehirecepcione->fecha_ingreso }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Fecha Entrega:</strong>
                                        {{ $vehientrega->fecha_entrega }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Responsable del vehículo:</strong>
                                        {{ $vehientrega->vehirecepcione->mantenimiento->user->name }}
                                        {{ $vehientrega->vehirecepcione->mantenimiento->user->lastname }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Persona que retira el vehículo:</strong>
                                        {{ $vehientrega->p_retiro }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Km Actual:</strong>
                                        {{ $vehientrega->km_actual }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Km Proximo:</strong>
                                        {{ $vehientrega->km_proximo }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Tipo de mantenimiento:</strong>
                                        {{ $vehientrega->vehirecepcione->mantetipo->nombre }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Descripción del mantenimiento:</strong>
                                        {{ $vehientrega->vehirecepcione->mantetipo->descripcion }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Valor del mantenimiento: </strong>
                                        {{ $vehientrega->vehirecepcione->mantetipo->valor }} $
                                    </div>
                                    <div class="form-group">
                                        <strong>Observaciones:</strong>
                                        {{ $vehientrega->observaciones }}
                                    </div>
                                    <div class="form-group">
                                        <strong>Estado mantenimiento:</strong>
                                        {{ $vehientrega->vehirecepcione->mantenimiento->mantestado->nombre }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-container">
                <div class="table-responsive min-vh-100">
                    <table class="table card-table table-vcenter text-nowrap datatable">
                        <thead>
                            <tr>
                                <th>
                                    <div class="firma-nombre">
                                        <strong>Nombre:____________________________ </strong>
                                    </div>
                                </th>
                                <th>
                                    <div class="firma">
                                        <strong>Firma:____________________________ </strong>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <footer>
                <a href="https://www.gob.ec/pn" target="_blank" class="text-gray-500"
                    style="color: blue">https://www.gob.ec/pn</a><br>
            </footer>
        </div>
</body>

</html>
