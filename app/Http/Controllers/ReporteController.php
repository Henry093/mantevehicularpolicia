<?php

namespace App\Http\Controllers;

use App\Exports\ReporteExport;
use App\Models\Mantenimiento;
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
        $view = $request->get('view');
        $search = $request->get('search');

        $query = $this->getModelQuery($view);

        if ($search) {
            $query->where(function ($query) use ($search, $view) {
                $this->applySearchLogic($query, $search, $view);
            });
        }

        $data = $query->paginate(14);

        return view('reporte.index', compact('data', 'view'))
            ->with('i', ($request->input('page', 1) - 1) * $data->perPage());
    }

    /**
     * Export data to PDF or Excel.
     */
    public function export(Request $request)
    {
        $view = $request->get('view');
        $search = $request->get('search');
    
        $query = $this->getModelQuery($view);
    
        if ($search) {
            $query->where(function ($query) use ($search, $view) {
                $this->applySearchLogic($query, $search, $view);
            });
        }
    
        $data = $query->paginate(20);
    
        $headers = $this->getHeadersForView($view);
    
        $exportData = [];
    
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
            $pdf = PDF::loadView('reporte.pdf', compact('headers', 'exportData', 'view', 'search'));
            $pdf->setPaper('landscape');
            return $pdf->download('reporte.pdf');
        } elseif ($request->input('format') === 'excel') {
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
            case 'personas':
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
            case 'vehiculos':
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
            case 'mantenimientos':
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
            case 'recepciones':
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
            case 'entregas':
                $query->where('fecha_entrega', 'like', '%' . $search . '%')
                    ->orWhere('p_retiro', 'like', '%' . $search . '%')
                    ->orWhere('km_actual', 'like', '%' . $search . '%')
                    ->orWhere('km_proximo', 'like', '%' . $search . '%')
                    ->orWhere('observaciones', 'like', '%' . $search . '%')
                    ->orWhereHas('vehirecepciones_id', function ($q) use ($search) {
                        $q->where('placa', 'like', '%' . $search . '%');
                    });
                break;
            case 'subcircuitos':
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
            default:
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
            default:
                return ['ID', 'Provincia', 'Cantón', 'Parroquia', 'Distrito', 'Código Distrito', 'Circuito', 'Código Circuito', 'Subcircuito', 'Código Subcircuito', 'Estado', '', ''];
        }
    }

    /**
     * Get the query based on the view.
     */
    private function getModelQuery($view)
    {
        switch ($view) {
            case 'personas':
                return User::query();
            case 'vehiculos':
                return Vehiculo::query();
            case 'mantenimientos':
                return Mantenimiento::query();
            case 'recepciones':
                return Vehirecepcione::query();
            case 'entregas':
                return Vehientrega::query();
            case 'subcircuitos':
                return Subcircuito::query();
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
            case 'personas':
                return 'users';
            case 'vehiculos':
                return 'vehiculos';
            case 'mantenimientos':
                return 'mantenimientos';
            case 'recepciones':
                return 'vehirecepciones';
            case 'entregas':
                return 'vehientregas';
            case 'subcircuitos':
                return 'subcircuitos';
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