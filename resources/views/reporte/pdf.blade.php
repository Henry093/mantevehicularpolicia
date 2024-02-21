<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px; /* Reducir el padding */
            font-size: 10px; /* Reducir el tamaño de la fuente */
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        /* Ajuste para que las tablas se ajusten al ancho de la página */
        @page {
            size: landscape;
        }

        /* Disminuir el tamaño de la fuente */
        body {
            margin: 0; /* Eliminar los márgenes */
            font-family: Arial, sans-serif; /* Agregar una fuente predeterminada */
            font-size: 12px; /* Tamaño de fuente más pequeño */
        }
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
        .image-container {
            text-align: center;
            margin-top: 35px; /* Ajusta según sea necesario */
        }

        .image-container img {
            display: inline-block;
            vertical-align:  middle;
        }
    </style>
</head>
    <body class="bg-gray-100">
        <div class="container mx-auto p-4">
            
        <h1 class="text-3xl font-bold mb-4" style="text-align: center;">Policía Nacional del Ecuador</h1>

        <h2 class="text-2xl font-bold mb-4" style="text-align: center;">Sub Zona 7 - Loja</h2>

        <div class="image-container">
            <img src="assets/escudo.png" alt="" width="90px" height="90px">
        </div>
            <!-- Encabezado del reporte -->
            <h2 class="text-3xl font-bold mb-4" style="text-align: center;">Reporte</h2>
    
            <!-- Tabla del reporte -->
            <table>
                <!-- Encabezado del reporte -->
                <thead>
                    <tr>
                        <!-- Iterar sobre los encabezados -->
                        @foreach($headers as $key => $header)
                            <!-- Excluir los encabezados de las dos últimas columnas -->
                            @if ($key < count($headers) - 2)
                                <th>{{ $header }}</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <!-- Iterar sobre los datos del reporte -->
                    @foreach($exportData as $item)
                        <tr>
                            <!-- Iterar sobre los valores de cada fila -->
                            @foreach($item as $key => $value)
                                <!-- Excluir los datos de las dos últimas columnas -->
                                @if ($key < count($item))
                                    <td>{{ $value }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
    
            <!-- Pie de página -->
            <footer>
                <a href="https://www.gob.ec/pn" target="_blank" class="text-gray-500" style="color: blue">https://www.gob.ec/pn</a><br>
            </footer>
        </div>
    </body>
    
    </html>