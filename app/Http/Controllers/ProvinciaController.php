<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ProvinciaController
 * @package App\Http\Controllers
 */
class ProvinciaController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:provincias.index')->only('index');
        $this->middleware('can:provincias.create')->only('create', 'store');
        $this->middleware('can:provincias.edit')->only('edit', 'update');
        $this->middleware('can:provincias.show')->only('show');
        $this->middleware('can:provincias.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Provincia::query(); // Se crea una consulta para obtener los provincias
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $provincias = $query->paginate(12);// Se obtienen los provincias paginados

        // Se devuelve la vista con los provincias paginados
        return view('provincia.index', compact('provincias'))
            ->with('i', (request()->input('page', 1) - 1) * $provincias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provincia = new Provincia(); // Se crea una nueva instancia de provincia

        return view('provincia.create', compact('provincia'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Provincia::$rules); // Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos
    
            $nombre = Provincia::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un provincia con el mismo nombre
            if ($nombre) {
                return redirect()->route('provincias.create')->with('error', 'La provincia ya está registrada.');
            }
    
            Provincia::create($request->all()); // Se crea un nuevo provincia con los datos proporcionados
    
            DB::commit(); // Se confirma la transacción
    
            // Se redirige a la lista de provincias con un mensaje de éxito
            return redirect()->route('provincias.index')->with('success', 'Provincia creada exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'Error al crear la provincia: ' . $e->getMessage());
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
            $provincia = Provincia::findOrFail($id); // Intenta encontrar el provincia por su ID

            return view('provincia.show', compact('provincia')); // Devuelve la vista con los detalles del provincia

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el provincia, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('provincias.index')->with('error', 'La provincia no existe.');
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
            $provincia = Provincia::findOrFail($id); // Intenta encontrar el provincia por su ID

            return view('provincia.edit', compact('provincia')); // Devuelve la vista con el provincia a editar

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el provincia, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('provincias.index')->with('error', 'La provincia no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Provincia $provincia
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Provincia $provincia)
    {
        $validator = Validator::make($request->all(), Provincia::$rules); // Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del provincia
            
            // Verificar si ya existe un provincia con el mismo nombre pero distinto ID
            $provinciaExistente = Provincia::where('nombre', $nombre)->where('id', '!=', $provincia->id)->first();
            if ($provinciaExistente) {
                return redirect()->route('provincias.index')->with('error', 'Ya existe una provincia con ese nombre.');
            }

            $provincia->update($request->all());// Actualizar los datos del provincia con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('provincias.index')->with('success', 'Provincia actualizada exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'Error al actualizar la provincia: ' . $e->getMessage());
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

            $provincia = Provincia::findOrFail($id);// Buscar el provincia por su ID
            $provincia->delete();// Eliminar el provincia

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('provincias.index')->with('success', 'Provincia borrada exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el provincia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'La provincia no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'La provincia no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'Error al eliminar la provincia: ' . $e->getMessage());
        }
    }
    
    public function getCantonesc($provinciaId) {
        try {
            // Intenta recuperar los cantones correspondientes a la provincia proporcionada
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();

            return response()->json($cantones);// Devuelve una respuesta JSON con los cantones encontrados

        } catch (ModelNotFoundException $e) {
            // Si no se encuentran los cantones, devuelve una respuesta JSON con un mensaje de error 404
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            // Si ocurre un error interno del servidor, devuelve una respuesta JSON con un mensaje de error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
}
