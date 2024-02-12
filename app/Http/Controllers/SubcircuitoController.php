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
        $search = request('search');
        $query = Subcircuito::query();
    
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
        $subcircuitos = $query->paginate(12);

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
        $subcircuito = new Subcircuito();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $edicion = false;
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
            // Iniciar una transacción de base de datos
            DB::beginTransaction();
    
            // Verificar si el estado ya está presente en la solicitud
            $estado = $request->input('estado_id');
    
            if (empty($estado)) {
                // Si no se proporciona un estado, establecerlo en 1 (Activo)
                $request->merge(['estado_id' => '1']);
            }
    
            // Obtener el nombre del subcircuito del formulario
            $nombre = $request->input('nombre');
    
            // Verificar si ya existe un subcircuito con el mismo nombre
            $subcircuitoExistente = Subcircuito::where('nombre', $nombre)->first();
            if ($subcircuitoExistente) {
                // Si ya existe un subcircuito con el mismo nombre, redirigir con un mensaje de error
                return redirect()->route('subcircuitos.create')->with('error', 'El subcircuito ya está registrado.');
            }
    
            // Crear un nuevo subcircuito con los datos del formulario y guardarlo en la base de datos
            Subcircuito::create($request->all());
    
            // Confirmar la transacción de base de datos
            DB::commit();
    
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
            $subcircuito = Subcircuito::findOrFail($id);
            return view('subcircuito.show', compact('subcircuito'));
        } catch (ModelNotFoundException $e) {
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
            $subcircuito = Subcircuito::findOrFail($id);
            $d_provincia = Provincia::all();
            $d_canton = Canton::all();
            $d_parroquia = Parroquia::all();
            $d_distrito = Distrito::all();
            $d_circuito = Circuito::all();
            $edicion = true;
    
            return view('subcircuito.edit', compact('subcircuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'd_circuito', 'edicion'));
        } catch (ModelNotFoundException $e) {
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
        $validator = Validator::make($request->all(), Subcircuito::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $subcircuitoExistente = Subcircuito::where('nombre', $nombre)->where('id', '!=', $subcircuito->id)->first();
            if ($subcircuitoExistente) {
                return redirect()->route('subcircuitos.index')->with('error', 'Ya existe un subcircuito con ese nombre.');
            }
    
            $subcircuito->update($request->all());
    
            DB::commit();
    
            return redirect()->route('subcircuitos.index')->with('success', 'Subcircuito actualizado exitosamente.');
        } catch (\Exception $e) {
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
            DB::beginTransaction();
    
            $subcircuito = Subcircuito::findOrFail($id);
            $subcircuito->delete();
    
            DB::commit();
    
            return redirect()->route('subcircuitos.index')->with('success', 'Subcircuito borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'El subcircuito no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'El subcircuito no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('subcircuitos.index')->with('error', 'Error al eliminar el subcircuito: ' . $e->getMessage());
        }
    }

    public function getCantoness($provinciaId) {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getParroquiass($cantonId) {
        try {
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getDistritoss($parroquiaId) {
        try {
            $distritos = Distrito::where('parroquia_id', $parroquiaId)->pluck('nombre', 'id')->toArray();
            return response()->json($distritos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Distritos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getCircuitoss($distritoId) {
        try {
            $circuitos = Circuito::where('distrito_id', $distritoId)->pluck('nombre', 'id')->toArray();
            return response()->json($circuitos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Circuitos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
}
