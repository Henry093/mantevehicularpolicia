<?php

namespace App\Http\Controllers;

use App\Exports\ReporteExport;
use App\Models\Mantenimiento;
use App\Models\Pertrecho;
use App\Models\Subcircuito;
use App\Models\Vehiculo;
use App\Models\Vehientrega;
use App\Models\Vehirecepcione;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use Intervention\Image\Facades\Image;

class ReporteController extends Controller
{
    
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:reportes.index')->only('index');
        $this->middleware('can:reportes.create')->only('create', 'store');
        $this->middleware('can:reportes.edit')->only('edit', 'update');
        $this->middleware('can:reportes.show')->only('show');
        $this->middleware('can:reportes.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $view = $request->get('view'); // Se obtiene el término de búsqueda
        $search = $request->get('search'); // Se crea una consulta para obtener los provincias

        
        $query = $this->getModelQuery($view); // Se obtiene la consulta base según la vista

        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search, $view) {
                $this->applySearchLogic($query, $search, $view);
            });
        }

        $data = $query->paginate(24);// Se obtienen los provincias paginados

        // Se devuelve la vista con los provincias paginados
        return view('reporte.index', compact('data', 'view'))
            ->with('i', ($request->input('page', 1) - 1) * $data->perPage());
    }

    /**
     * Export data to PDF or Excel.
     */
    public function export(Request $request)
    {
        $view = $request->get('view'); // Obtiene el parámetro 'view' de la solicitud HTTP
        $search = $request->get('search'); // Obtiene el parámetro 'search' de la solicitud HTTP
    
        $query = $this->getModelQuery($view); // Obtiene la consulta base según la vista especificada
    
        // Si hay un término de búsqueda, aplica la lógica de búsqueda en la consulta   
        if ($search) {
            $query->where(function ($query) use ($search, $view) {
                $this->applySearchLogic($query, $search, $view);
            });
        }
    
        $data = $query->get(); // Estrae los resultados de la consulta
    
        $headers = $this->getHeadersForView($view); // Obtiene los encabezados para la vista especificada
    
        $exportData = []; // Inicializa el arreglo donde se almacenarán los datos para exportación
    
        foreach ($data as $item) {
            // Convertir el objeto a un array y eliminar las últimas dos columnas de los datos
            $itemArray = $item->toArray();
            
            // Construir los datos de exportación según la tabla seleccionada
            if ($view === 'personas') {
                $exportData[] = [
                    $item->id,
                    $item->name,
                    $item->lastname,
                    $item->cedula,
                    $item->fecha_nacimiento,
                    $item->sangre->nombre,
                    $item->parroquia->nombre,
                    $item->telefono,
                    $item->grado->nombre,
                    $item->rango->nombre,
                    $item->estado->nombre,

                ];
            } elseif ($view === 'vehiculos') {
                $exportData[] = [
                    $item->id,
                    $item->tvehiculo->nombre,
                    $item->placa,
                    $item->chasis,
                    $item->marca->nombre,
                    $item->modelo->nombre,
                    $item->motor,
                    $item->kilometraje,
                    $item->cilindraje,
                    $item->vcarga->nombre,
                    $item->vpasajero->nombre,
                    $item->estado->nombre,
                ];
            } elseif ($view === 'mantenimientos') {
                $exportData[] = [
                    $item->id,
                    $item->orden,
                    $item->user->name . ' ' . $item->user->lastname,
                    $item->vehiculo->placa,
                    $item->fecha,
                    $item->hora,
                    $item->kilometraje,
                    $item->observaciones,
                    $item->mantestado->nombre,
                ];
            } elseif ($view === 'recepciones') {
                $exportData[] = [
                    $item->id,
                    $item->mantenimientos_id,
                    $item->fecha_ingreso,
                    $item->hora_ingreso,
                    $item->kilometraje,
                    $item->asunto,
                    $item->detalle,
                    $item->mantetipo->nombre,
                    $item->mantenimiento->mantestado->nombre,

                ];
            } elseif ($view === 'entregas') {
                $exportData[] = [
                    $item->id,
                    $item->vehirecepciones_id,
                    $item->fecha_entrega,
                    $item->p_retiro,
                    $item->km_actual,
                    $item->km_proximo,
                    $item->observaciones,
                    $item->vehirecepcione->mantenimiento->mantestado->nombre ,

                ];
            } elseif ($view === 'subcircuitos') {
                $exportData[] = [
                    $item->id,
                    $item->provincia->nombre,
                    $item->canton->nombre,
                    $item->parroquia->nombre,
                    $item->distrito->nombre,
                    $item->circuito->nombre,
                    $item->nombre,
                    $item->codigo,
                    $item->estado->nombre,

                ];
            } elseif ($view === 'pertrechos') {
                $exportData[] = [
                    $item->id,
                    $item->tpertrecho->nombre,
                    $item->nombre,
                    $item->descripcion,
                    $item->codigo,

                ];
            } else {
                $exportData[] = [
                    $item->id,
                    $item->provincia->nombre,
                    $item->canton->nombre,
                    $item->parroquia->nombre,
                    $item->distrito->nombre,
                    $item->distrito->codigo,
                    $item->circuito->nombre,
                    $item->circuito->codigo,
                    $item->nombre,
                    $item->codigo,
                    $item->estado->nombre,

                ];
            }
        }
    
        if ($request->input('format') === 'pdf') {
            // Genera y descarga el PDF
            $pdf = PDF::loadView('reporte.pdf', compact('headers', 'exportData', 'view', 'search'));
            $pdf->setPaper('landscape');
            return $pdf->download('reporte.pdf');
        } elseif ($request->input('format') === 'excel') {
            // Genera y descarga el Excel
            $tableName = $this->getTableName($view);
            $exportData = collect([[$tableName]])->push($headers)->merge($exportData);
            return Excel::download(new ReporteExport($exportData), 'reporte.xlsx');
        }
    }
    

    /**
     * Apply search logic based on the view.
     */
    private function applySearchLogic($query, $search, $view)
    {
        switch ($view) {
            // En caso de que la vista sea 'personas'
            case 'personas':
                // Aplica condiciones de búsqueda para campos específicos de la tabla 'personas'
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('cedula', 'like', '%' . $search . '%')
                    ->orWhereHas('sangre', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('parroquia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhere('fecha_nacimiento', 'like', '%' . $search . '%')
                    ->orWhere('telefono', 'like', '%' . $search . '%')
                    ->orWhereHas('grado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('rango', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
                break;
                
            // En caso de que la vista sea 'vehiculos'
            case 'vehiculos':
                // Aplica condiciones de búsqueda para campos específicos de la tabla 'vehiculos'
                $query->where('placa', 'like', '%' . $search . '%')
                    ->orWhere('chasis', 'like', '%' . $search . '%')
                    ->orWhere('motor', 'like', '%' . $search . '%')
                    ->orWhere('kilometraje', 'like', '%' . $search . '%')
                    ->orWhere('cilindraje', 'like', '%' . $search . '%')
                    ->orWhereHas('tvehiculo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('marca', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('modelo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('vcarga', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('vpasajero', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
                break;
                // En caso de que la vista sea 'mantenimientos'
            case 'mantenimientos':
                // Aplica condiciones de búsqueda para campos específicos de la tabla 'mantenimientos'
                $query->where('fecha', 'like', '%' . $search . '%')
                    ->orWhere('hora', 'like', '%' . $search . '%')
                    ->orWhere('kilometraje', 'like', '%' . $search . '%')
                    ->orWhere('observaciones', 'like', '%' . $search . '%')
                    ->orWhere('orden', 'like', '%' . $search . '%')
                    ->orWhereHas('mantestado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('lastname', 'like', '%' . $search . '%');
                    });
                break;
                // En caso de que la vista sea 'recepciones'
            case 'recepciones':
                // Aplica condiciones de búsqueda para campos específicos de la tabla 'recepciones'
                $query->where('fecha_ingreso', 'like', '%' . $search . '%')
                    ->orWhere('hora_ingreso', 'like', '%' . $search . '%')
                    ->orWhere('kilometraje', 'like', '%' . $search . '%')
                    ->orWhere('asunto', 'like', '%' . $search . '%')
                    ->orWhere('detalle', 'like', '%' . $search . '%')
                    ->orWhereHas('mantenimiento', function ($q) use ($search) {
                        $q->where('orden', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('mantetipo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
                break;
                // En caso de que la vista sea 'entregas'
            case 'entregas':
                // Aplica condiciones de búsqueda para campos específicos de la tabla 'entregas'
                $query->where('fecha_entrega', 'like', '%' . $search . '%')
                    ->orWhere('p_retiro', 'like', '%' . $search . '%')
                    ->orWhere('km_actual', 'like', '%' . $search . '%')
                    ->orWhere('km_proximo', 'like', '%' . $search . '%')
                    ->orWhere('observaciones', 'like', '%' . $search . '%')
                    ->orWhereHas('vehirecepciones_id', function ($q) use ($search) {
                        $q->where('placa', 'like', '%' . $search . '%');
                    });
                break;
                // En caso de que la vista sea 'subcircuitos'
            case 'subcircuitos':
                // Aplica condiciones de búsqueda para campos específicos de la tabla 'subcircuitos'
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('codigo', 'like', '%' . $search . '%')
                    ->orWhereHas('provincia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('canton', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('parroquia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('distrito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('circuito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
                break;

                case 'pertrechos':
                    // Aplica condiciones de búsqueda para campos específicos de la tabla 'subcircuitos'
                    $query->where('nombre', 'like', '%' . $search . '%')
                        ->orWhere('descripcion', 'like', '%' . $search . '%')
                        ->orWhere('codigo', 'like', '%' . $search . '%')
                        ->orWhereHas('tpertrechos', function ($q) use ($search) {
                            $q->where('nombre', 'like', '%' . $search . '%');
                        });
                    break;


                // En caso de que la vista sea 'default'
            default:
            // Aplica condiciones de búsqueda para campos específicos de la tabla 'default'
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('codigo', 'like', '%' . $search . '%')
                    ->orWhereHas('provincia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('canton', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('parroquia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('distrito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('distrito', function ($q) use ($search) {
                        $q->where('codigo', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('circuito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('circuito', function ($q) use ($search) {
                        $q->where('codigo', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
                break;
        }
    }
    
    /**
     * Get headers for the specified view.
     */
    private function getHeadersForView($view)
    {
        // Encabezados para la vista 'personas, vehiculos, etc.
        switch ($view) {
            case 'personas':
                return ['ID', 'Nombre', 'Apellido', 'Cédula', 'Fecha de Nacimiento', 'Sangre', 'Ciudad Nacimiento', 'Teléfono', 'Grado', 'Rango', 'Estado', '', ''];
            case 'vehiculos':
                return ['ID', 'T. Vehículo', 'Placa', 'Chasis', 'Marca', 'Modelo', 'Motor', 'Kilometraje', 'Cilindraje', 'Cap. Carga', 'Cap. Pasajeros', 'Estado', '', ''];
            case 'mantenimientos':
                return ['ID', 'Orden', 'Nombre Responsable', 'Placa', 'Fecha Solicitud', 'Hora Solicitud', 'Kilometraje', 'Observaciones', 'Estado Mantenimiento', '', ''];
            case 'recepciones':
                return ['ID', 'Orden', 'Fecha de Ingreso', 'Hora de Ingreso', 'Kilometraje', 'Asunto', 'Detalle', 'Tipo de Mantenimiento', 'Estado Mantenimiento', '', ''];
            case 'entregas':
                return ['ID', 'Orden', 'Fecha de Entrega', 'Persona que Retira', 'Kilometraje Actual', 'Kilometraje Próximo Mantenimiento', 'Observaciones', 'Estado Mantenimiento', '', ''];
            case 'subcircuitos':
                return ['ID', 'Provincia', 'Cantón', 'Parroquia', 'Distrito', 'Circuito', 'Subcircuito', 'Código', 'Estado', '', ''];
            case 'pertrechos':
                return ['ID', 'Tipo Pertrecho', 'Nombre', 'Descripción', 'Código',  '', ''];
            default:
                return ['ID', 'Provincia', 'Cantón', 'Parroquia', 'Distrito', 'Código Distrito', 'Circuito', 'Código Circuito', 'Subcircuito', 'Código Subcircuito', 'Estado', '', ''];
        }
    }

    /**
     * Get the query based on the view.
     */
    private function getModelQuery($view)
    {
        
        // Retorna la consulta del modelo User para la vista 'personas'
        switch ($view) {
            case 'personas':
                return User::query();
                // Retorna la consulta del modelo Vehiculo para la vista 'vehiculos'
            case 'vehiculos':
                return Vehiculo::query();
                // Retorna la consulta del modelo Mantenimiento para la vista 'mantenimientos'
            case 'mantenimientos':
                return Mantenimiento::query();
                // Retorna la consulta del modelo Vehirecepcione para la vista 'recepciones'
            case 'recepciones':
                return Vehirecepcione::query();
                // Retorna la consulta del modelo Vehientrega para la vista 'entregas'
            case 'entregas':
                return Vehientrega::query();
                // Retorna la consulta del modelo Subcircuito para la vista 'subcircuitos'
            case 'subcircuitos':
                return Subcircuito::query();

                
            case 'pertrechos':
                return Pertrecho::query();


                // Si la vista no está especificada, se devuelve la consulta del modelo Subcircuito por defecto
            default:
                return Subcircuito::query();
        }
    }

    /**
     * Get the query based on the view.
     */
    
    private function getTableName($view)
    {
        switch ($view) {
            // Retorna el nombre de la tabla 'users' para la vista 'personas'
            case 'personas':
                return 'users';
                // Retorna el nombre de la tabla 'vehiculos' para la vista 'vehiculos'
            case 'vehiculos':
                return 'vehiculos';
                // Retorna el nombre de la tabla 'mantenimientos' para la vista 'mantenimientos'
            case 'mantenimientos':
                return 'mantenimientos';
                // Retorna el nombre de la tabla 'vehirecepciones' para la vista 'recepciones'
            case 'recepciones':
                return 'vehirecepciones';
                // Retorna el nombre de la tabla 'vehientregas' para la vista 'entregas'
            case 'entregas':
                return 'vehientregas';
                // Retorna el nombre de la tabla 'subcircuitos' para la vista 'subcircuitos'
            case 'subcircuitos':
                return 'subcircuitos';

            
            case 'pertrechos':
                    return 'pertrechos';


                // Si la vista no está especificada, se devuelve el nombre de la tabla 'subcircuitos' por defecto
            default:
                return 'subcircuitos';
        }
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

}