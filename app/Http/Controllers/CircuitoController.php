<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Estado;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class CircuitoController
 * @package App\Http\Controllers
 */
class CircuitoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:circuitos.index')->only('index');
        $this->middleware('can:circuitos.create')->only('create', 'store');
        $this->middleware('can:circuitos.edit')->only('edit', 'update');
        $this->middleware('can:circuitos.show')->only('show');
        $this->middleware('can:circuitos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda

        $query = Circuito::query();// Se crea una consulta para obtener los circuitos
    
        // Si hay un término de búsqueda, se aplica el filtro
        if ($search) {
            $query->where(function ($query) use ($search) {
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
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
    
        $circuitos = $query->paginate(12);// Se obtienen los circuitos paginados
    
        // Se devuelve la vista con los circuitos paginados
        return view('circuito.index', compact('circuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $circuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $circuito = new Circuito();// Crear una nueva instancia de Circuito
        $d_provincia = Provincia::all();// Obtener todas las provincias disponibles
        $d_canton = Canton::all();// Obtener todos los cantones disponibles
        $d_parroquia = Parroquia::all();// Obtener todas las parroquias disponibles
        $d_distrito = Distrito::all();// Obtener todos los distritos disponibles
        $edicion = false;// Variable para indicar que no es una edición

        // Devolver la vista con el formulario de creación
        return view('circuito.create', compact('circuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), Circuito::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            // Se busca si ya existe un Circuito con el mismo nombre
            $nombre = Circuito::where('nombre', $request->input('nombre'))->first();
            if ($nombre) {
                return redirect()->route('circuitos.create')->with('error', 'El circuito ya está registrado.');
            }
    
            // Verificar si el estado ya está presente en la solicitud
            $estado = $request->input('estado_id');
    
            if (empty($estado)) {
                // Si no se proporciona un estado, en este caso 1 = Activo
                $request->merge(['estado_id' => '1']);
            }
    
            Circuito::create($request->all());// Crear el circuito con los datos proporcionados
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de circuitos con un mensaje de éxito
            return redirect()->route('circuitos.index')->with('success', 'Circuito creado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('circuitos.index')->with('error', 'Error al crear el circuito: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $circuito = Circuito::findOrFail($id);// Buscar el circuito por su ID

            return view('circuito.show', compact('circuito'));// Devolver la vista con los detalles del circuito

        } catch (ModelNotFoundException $e) {
            // Si el circuito no se encuentra, redirigir a la lista de circuitos con un mensaje de error
            return redirect()->route('circuitos.index')->with('error', 'El circuito no existe.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $circuito = Circuito::findOrFail($id);// Buscar el circuito por su ID
            $d_provincia = Provincia::all();// Obtener todas las provincias disponibles
            $d_canton = Canton::all();// Obtener todos los cantones disponibles
            $d_parroquia = Parroquia::all();// Obtener todas las parroquias disponibles
            $d_distrito = Distrito::all();// Obtener todos los distritos disponibles
            $d_estado = Estado::all();// Obtener todos los estados disponibles
            $edicion = true;// Variable para indicar que es una edición
    
            // Devolver la vista con el formulario de edición y los datos del circuito
            return view('circuito.edit', compact('circuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'edicion', 'd_estado'));
        
        } catch (ModelNotFoundException $e) {
            // Si el circuito no se encuentra, redirigir a la lista de circuitos con un mensaje de error
            return redirect()->route('circuitos.index')->with('error', 'El circuito no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Circuito $circuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circuito $circuito)
    {
        $validator = Validator::make($request->all(), Circuito::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del Circuito

            // Verificar si ya existe un Circuito con el mismo nombre pero distinto ID
            $circuitoExistente = Circuito::where('nombre', $nombre)->where('id', '!=', $circuito->id)->first();
            if ($circuitoExistente) {
                return redirect()->route('circuitos.index')->with('error', 'Ya existe un circuito con ese nombre.');
            }
    
            $circuito->update($request->all());// Actualizar los datos del cantón con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('circuitos.index')->with('success', 'Circuito actualizado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('circuitos.index')->with('error', 'Error al actualizar el circuito: ' . $e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $circuito = Circuito::findOrFail($id);// Buscar el circuito por su ID

            $circuito->delete();// Eliminar el circuito
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de circuitos con un mensaje de éxito
            return redirect()->route('circuitos.index')->with('success', 'Circuito borrado exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el circuito no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('circuitos.index')->with('error', 'El circuito no existe.');

        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('circuitos.index')->with('error', 'El circuito no puede eliminarse, tiene datos asociados.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('circuitos.index')->with('error', 'Error al eliminar el circuito: ' . $e->getMessage());
        }
    }

    public function getCantonesc($provinciaId) {
        try {
            // Obtener los cantones asociados a la provincia especificada
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            
            return response()->json($cantones);// Devolver una respuesta JSON con los cantones

        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);// En caso de que no se encuentren los cantones, devolver un error 404
        
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);// En caso de otro error, devolver un error 500
        }
    }
    
    public function getParroquiasc($cantonId) {
        try {
            // Obtener las parroquias asociadas al cantón especificado
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();

            return response()->json($parroquias);// Devolver una respuesta JSON con las parroquias

        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);// En caso de que no se encuentren las parroquias, devolver un error 404
        
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);// En caso de otro error, devolver un error 500
        }
    }
    
    public function getDistritosc($parroquiaId) {
        try {
            // Obtener los distritos asociados a la parroquia especificada
            $distritos = Distrito::where('parroquia_id', $parroquiaId)->pluck('nombre', 'id')->toArray();
            
            return response()->json($distritos);// Devolver una respuesta JSON con los distritos

        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Distritos no encontrados'], 404);// En caso de que no se encuentren los distritos, devolver un error 404

        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);// En caso de otro error, devolver un error 500
        }
    }
}
