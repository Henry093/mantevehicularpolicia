<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class SubcircuitoController
 * @package App\Http\Controllers
 */
class SubcircuitoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:subcircuitos.index')->only('index');
        $this->middleware('can:subcircuitos.create')->only('create', 'store');
        $this->middleware('can:subcircuitos.edit')->only('edit', 'update');
        $this->middleware('can:subcircuitos.show')->only('show');
        $this->middleware('can:subcircuitos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Subcircuito::query(); // Se crea una consulta para obtener los Subcircuito
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
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
                    ->orWhereHas('circuito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $subcircuitos = $query->paginate(12);// Se obtienen los subcircuitos paginados

        // Se devuelve la vista con los subcircuitos paginados
        return view('subcircuito.index', compact('subcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $subcircuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcircuito = new Subcircuito(); // Se crea una nueva instancia de Subcircuito
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $edicion = false;
        // Se devuelve la vista con el formulario de creación
        return view('subcircuito.create', compact('subcircuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'd_circuito', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario según las reglas definidas en el modelo Subcircuito
        $validator = Validator::make($request->all(), Subcircuito::$rules);
    
        // Si la validación falla, redirigir de vuelta al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            
            $estado = $request->input('estado_id');// Verificar si el estado ya está presente en la solicitud
    
            if (empty($estado)) {
                // Si no se proporciona un estado, establecerlo en 1 (Activo)
                $request->merge(['estado_id' => '1']);
            }
    
            $nombre = $request->input('nombre'); // Obtener el nombre del subcircuito del formulario
    
            // Verificar si ya existe un subcircuito con el mismo nombre
            $subcircuitoExistente = Subcircuito::where('nombre', $nombre)->first();
            if ($subcircuitoExistente) {
                // Si ya existe un subcircuito con el mismo nombre, redirigir con un mensaje de error
                return redirect()->route('subcircuitos.create')->with('error', 'El subcircuito ya está registrado.');
            }
    
            // Crear un nuevo subcircuito con los datos del formulario y guardarlo en la base de datos
            Subcircuito::create($request->all());
    
            DB::commit();// Confirmar la transacción de base de datos
    
            // Redirigir al usuario a la página de índice de subcircuitos con un mensaje de éxito
            return redirect()->route('subcircuitos.index')->with('success', 'Subcircuito creado exitosamente.');
        } catch (\Exception $e) {
            // Si ocurre algún error durante el proceso, revertir la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'Error al crear el subcircuito: ' . $e->getMessage());
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
            $subcircuito = Subcircuito::findOrFail($id); // Intenta encontrar el subcircuito por su ID
            return view('subcircuito.show', compact('subcircuito')); // Devuelve la vista con los detalles del subcircuito
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el subcircuitos, redirige a la lista de subcircuitos con un mensaje de error
            return redirect()->route('subcircuitos.index')->with('error', 'El subcircuito no existe.');
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
            $subcircuito = Subcircuito::findOrFail($id); // Intenta encontrar el provincia por su ID
            $d_provincia = Provincia::all();
            $d_canton = Canton::all();
            $d_parroquia = Parroquia::all();
            $d_distrito = Distrito::all();
            $d_circuito = Circuito::all();
            $edicion = true;

            // Devuelve la vista con el provincia a editar
            return view('subcircuito.edit', compact('subcircuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'd_circuito', 'edicion'));
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el provincia, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('subcircuitos.index')->with('error', 'El subcircuito no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Subcircuito $subcircuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcircuito $subcircuito)
    {
        $validator = Validator::make($request->all(), Subcircuito::$rules); // Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del Subcircuito
            
            // Verificar si ya existe un Subcircuito con el mismo nombre pero distinto ID
            $subcircuitoExistente = Subcircuito::where('nombre', $nombre)->where('id', '!=', $subcircuito->id)->first();
            if ($subcircuitoExistente) {
                return redirect()->route('subcircuitos.index')->with('error', 'Ya existe un subcircuito con ese nombre.');
            }
    
            $subcircuito->update($request->all());// Actualizar los datos del subcircuito con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de subcircuitos con un mensaje de éxito
            return redirect()->route('subcircuitos.index')->with('success', 'Subcircuito actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'Error al actualizar el subcircuito: ' . $e->getMessage());
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
    
            $subcircuito = Subcircuito::findOrFail($id);// Buscar el Subcircuito por su ID
            $subcircuito->delete();// Eliminar el Subcircuito
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de subcircuitos con un mensaje de éxito
            return redirect()->route('subcircuitos.index')->with('success', 'Subcircuito borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el subcircuitos no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'El subcircuito no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'El subcircuito no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'Error al eliminar el subcircuito: ' . $e->getMessage());
        }
    }

    public function getCantoness($provinciaId) {
        try {
            // Intenta encontrar los cantones correspondientes a la provincia proporcionada
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            
            // Devuelve una respuesta JSON con los cantones encontrados
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentran cantones, devuelve un error 404
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            // Si ocurre otro tipo de error, devuelve un error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getParroquiass($cantonId) {
        try {
             // Intenta encontrar las parroquias correspondientes al cantón proporcionado
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            // Devuelve una respuesta JSON con las parroquias encontradas
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentran cantones, devuelve un error 404
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            // Si ocurre otro tipo de error, devuelve un error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getDistritoss($parroquiaId) {
        try {
            // Intenta encontrar los distritos correspondientes a la parroquia proporcionada
            $distritos = Distrito::where('parroquia_id', $parroquiaId)->pluck('nombre', 'id')->toArray();
            // Devuelve una respuesta JSON con los distritos encontrados
            return response()->json($distritos);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentran cantones, devuelve un error 404
            return new JsonResponse(['error' => 'Distritos no encontrados'], 404);
        } catch (\Exception $e) {
            // Si ocurre otro tipo de error, devuelve un error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getCircuitoss($distritoId) {
        try {
            // Intenta encontrar los circuitos correspondientes al distrito proporcionado
            $circuitos = Circuito::where('distrito_id', $distritoId)->pluck('nombre', 'id')->toArray();
            // Devuelve una respuesta JSON con los circuitos encontrados
            return response()->json($circuitos);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentran cantones, devuelve un error 404
            return new JsonResponse(['error' => 'Circuitos no encontrados'], 404);
        } catch (\Exception $e) {
            // Si ocurre otro tipo de error, devuelve un error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
}
