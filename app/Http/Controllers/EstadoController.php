<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class EstadoController
 * @package App\Http\Controllers
 */
class EstadoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:estados.index')->only('index');
        $this->middleware('can:estados.create')->only('create', 'store');
        $this->middleware('can:estados.edit')->only('edit', 'update');
        $this->middleware('can:estados.show')->only('show');
        $this->middleware('can:estados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda

        $query = Estado::query();// Se crea una consulta para obtener los cantones
    
        // Si hay un término de búsqueda, se aplica el filtro de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $estados = $query->paginate(12);// Se obtienen los estados paginados

        // Se devuelve la vista con los estados paginados
        return view('estado.index', compact('estados'))
            ->with('i', (request()->input('page', 1) - 1) * $estados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estado = new Estado();// Se crea una nueva instancia de estado

        return view('estado.create', compact('estado'));// Se devuelve la vista con el formulario de creación 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Estado::$rules);// Se validan los datos del formulario 
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Se inicia una transacción de base de datos
    
            $nombre = Estado::where('nombre', $request->input('nombre'))->first();// Se busca si ya existe un cantón con el mismo nombre
            if ($nombre) {
                return redirect()->route('estados.create')->with('error', 'El estado ya está registrado.');
            }
    
            Estado::create($request->all());// Se crea un nuevo cantón con los datos proporcionados
    
            DB::commit();// Se confirma la transacción
    
            // Se redirige a la lista de cantones con un mensaje de éxito
            return redirect()->route('estados.index')->with('success', 'Estado creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'Error al crear el estado: ' . $e->getMessage());
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
            $estado = Estado::findOrFail($id);// Intenta encontrar el cantón por su ID

            return view('estado.show', compact('estado'));// Devuelve la vista 'canton.show' con los detalles del cantón

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el cantón, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('estados.index')->with('error', 'El estado no existe.');
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
            $estado = Estado::findOrFail($id);// Intenta encontrar el Estado por su ID

            return view('estado.edit', compact('estado'));// Devuelve la vista con el estado a editar

        } catch (ModelNotFoundException $e) {
             // Si no se encuentra el estado, redirige a la lista de estados con un mensaje de error
            return redirect()->route('estados.index')->with('error', 'El estado no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Estado $estado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estado $estado)
    {
        $validator = Validator::make($request->all(), Estado::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del estado

            // Verificar si ya existe un estado con el mismo nombre pero distinto ID
            $estadoExistente = Estado::where('nombre', $nombre)->where('id', '!=', $estado->id)->first();
            if ($estadoExistente) {
                return redirect()->route('estados.index')->with('error', 'Ya existe un estado con ese nombre.');
            }
    
            $estado->update($request->all());// Actualizar los datos del estado con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de estados con un mensaje de éxito
            return redirect()->route('estados.index')->with('success', 'Estado actualizado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
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

            $estado = Estado::findOrFail($id);// Buscar el estado por su ID
            $estado->delete();// Eliminar el estado

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de estados con un mensaje de éxito
            return redirect()->route('estados.index')->with('success', 'Estado borrado exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el estado no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'El estado no existe.');

        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'El estado no puede eliminarse, tiene datos asociados.');

        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'Error al eliminar el estado: ' . $e->getMessage());
        }
    }
}
