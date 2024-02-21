<?php

namespace App\Http\Controllers;

use App\Models\Canton;
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
 * Class DistritoController
 * @package App\Http\Controllers
 */
class DistritoController extends Controller
{
    public function __construct()
    {
        // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
        $this->middleware('can:distritos.index')->only('index');
        $this->middleware('can:distritos.create')->only('create', 'store');
        $this->middleware('can:distritos.edit')->only('edit', 'update');
        $this->middleware('can:distritos.show')->only('show');
        $this->middleware('can:distritos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Obtener el término de búsqueda

        $query = Distrito::query();// Crear una consulta para obtener los distritos
    
        // Si hay un término de búsqueda, aplicar el filtro
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
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }

        $distritos = $query->paginate(12);// Obtener los distritos paginados

        // Devolver la vista con los distritos paginados
        return view('distrito.index', compact('distritos'))
            ->with('i', (request()->input('page', 1) - 1) * $distritos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distrito = new Distrito();// Crear una nueva instancia de Distrito
        $d_provincia = Provincia::all();// Obtener todas las provincias disponibles
        $d_canton = Canton::all();// Obtener todos los cantones disponibles
        $d_parroquia = Parroquia::all();// Obtener todas las parroquias disponibles

        $edicion = false;// Variable para indicar que no es una edición

        // Devolver la vista con el formulario de creación
        return view('distrito.create', compact('distrito', 'd_provincia', 'd_canton', 'd_parroquia', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Distrito::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {

            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = Distrito::where('nombre', $request->input('nombre'))->first();// Se busca si ya existe un cantón con el mismo nombre
            if ($nombre) {
                return redirect()->route('distritos.create')->with('error', 'El distrito ya está registrado.');
            }
    
            // Verificar si el estado ya está presente en la solicitud
            $estado = $request->input('estado_id');
            if (empty($estado)) {
                // Si no se proporciona un estado, en este caso 1 = Activo
                $request->merge(['estado_id' => '1']);
            }
    
            Distrito::create($request->all());// Crear el distrito con los datos proporcionados
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de distritos con un mensaje de éxito
            return redirect()->route('distritos.index')->with('success', 'Distrito creado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('distritos.index')->with('error', 'Error al crear el distrito: ' . $e->getMessage());
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
            $distrito = Distrito::findOrFail($id);// Buscar el distrito por su ID

            return view('distrito.show', compact('distrito'));// Devolver la vista que muestra los detalles del distrito

        } catch (ModelNotFoundException $e) {
            // En caso de que el distrito no exista, redirigir a la lista de distritos con un mensaje de error
            return redirect()->route('distritos.index')->with('error', 'El distrito no existe.');
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
            $distrito = Distrito::findOrFail($id);// Buscar el distrito por su ID
            $d_provincia = Provincia::all();// Obtener todas las provincias disponibles
            $d_canton = Canton::all();// Obtener todos los cantones disponibles
            $d_parroquia = Parroquia::all();// Obtener todas las parroquias disponibles

            $d_estado = Estado::all();// Obtener todos los estados disponibles

            $edicion = true;// Establecer la variable de edición en verdadero

            // Devolver la vista que muestra el formulario de edición del distrito
            return view('distrito.edit', compact('distrito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_estado', 'edicion'));
        } catch (ModelNotFoundException $e) {
             // En caso de que el distrito no exista, redirigir a la lista de distritos con un mensaje de error
            return redirect()->route('distritos.index')->with('error', 'El distrito no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Distrito $distrito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distrito $distrito)
    {
        $validator = Validator::make($request->all(), Distrito::$rules);// Validar los datos del formulario

         // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del Distrito

            // Verificar si ya existe un Distrito con el mismo nombre pero distinto ID
            $distritoExistente = Distrito::where('nombre', $nombre)->where('id', '!=', $distrito->id)->first();
            if ($distritoExistente) {
                return redirect()->route('distritos.index')->with('error', 'Ya existe un distrito con ese nombre.');
            }

            $distrito->update($request->all());// Actualizar los datos del cantón con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de Distritos con un mensaje de éxito
            return redirect()->route('distritos.index')->with('success', 'Distrito actualizado exitosamente.');
        } catch (\Exception $e) {

            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('distritos.index')->with('error', 'Error al actualizar el distrito: ' . $e->getMessage());
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

            $distrito = Distrito::findOrFail($id);// Buscar el cantón por su ID
            $distrito->delete();// Eliminar el Distrito

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de Distritos con un mensaje de éxito
            return redirect()->route('distritos.index')->with('success', 'Distrito borrado exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el Distrito no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('distritos.index')->with('error', 'El distrito no existe.');

        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('distritos.index')->with('error', 'El distrito no puede eliminarse, tiene datos asociados.');
            
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('distritos.index')->with('error', 'Error al eliminar el distrito: ' . $e->getMessage());
        }
    }



    public function getCantonesd($provinciaId) {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getParroquiasd($cantonId) {
        try {
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    
}
