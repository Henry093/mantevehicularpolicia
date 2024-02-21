<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class AsignacionController
 * @package App\Http\Controllers
 */
class AsignacionController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:asignacions.index')->only('index');
        $this->middleware('can:asignacions.create')->only('create', 'store');
        $this->middleware('can:asignacions.edit')->only('edit', 'update');
        $this->middleware('can:asignacions.show')->only('show');
        $this->middleware('can:asignacions.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda
        $query = Asignacion::query();// Se crea la consulta

        // Si hay un término de búsqueda, se filtra por ese término
        if($search){
            $query->where('nombre', 'like', '%' . $search . '%');
        }
        
        $asignacions = $query->paginate(12);// Se obtienen las asignaciones paginadas

        // Se devuelve la vista con las asignaciones y la paginación
        return view('asignacion.index', compact('asignacions'))->with('i', (request()->input('page', 1) - 1) * $asignacions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Se crea una nueva instancia de Asignacion y se muestra el formulario
        $asignacion = new Asignacion();
        return view('asignacion.create', compact('asignacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Se valida el formulario
        $validator = Validator::make($request->all(), Asignacion::$rules);

        // Si la validación falla, se redirecciona de nuevo al formulario de edición con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {

            DB::beginTransaction(); // Se inicia una transacción de base de datos
    
            
            $nombre = $request->input('nombre');// Se obtiene el nombre de la asignación del formulario
            
            $asignacionExistente = Asignacion::where('nombre', $nombre)->first();// Se verifica si ya existe una asignación con el mismo nombre

            // Si existe, se redirecciona de nuevo al formulario con un mensaje de error
            if ($asignacionExistente) {
                return redirect()->route('asignacions.create')->with('error', 'La asignación ya está registrada.');
            }

            Asignacion::create($request->all());// Si no existe, se crea la nueva asignación  
            
            DB::commit();// Se confirma la transacción de base de datos   

            // Se redirecciona a la lista de asignaciones con un mensaje de éxito    
            return redirect()->route('asignacions.index')->with('success', 'Asignación creada exitosamente.');
        } catch (\Exception $e) {
             // Si ocurre un error durante la transacción, se revierte y se redirecciona con un mensaje de error
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'Error al crear la asignación: ' . $e->getMessage());
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
            
            $asignacion = Asignacion::findOrFail($id);// Se intenta encontrar la asignación con el ID proporcionado

            return view('asignacion.show', compact('asignacion'));// Se devuelve la vista de edición con la asignación encontrada

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra la asignación, se redirecciona a la lista de asignaciones con un mensaje de error
            return redirect()->route('asignacions.index')->with('error', 'La asignación no existe.');
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
            
            $asignacion = Asignacion::findOrFail($id);// Intenta encontrar la asignación con el ID proporcionado
            
            return view('asignacion.edit', compact('asignacion'));// Devuelve la vista de edición con la asignación encontrada

        } catch (ModelNotFoundException $e) {
            // Si la asignación no se encuentra, redirecciona a la lista de asignaciones con un mensaje de error
            return redirect()->route('asignacions.index')->with('error', 'La asignación no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Asignacion $asignacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignacion $asignacion)
    {
        
        $validator = Validator::make($request->all(), Asignacion::$rules);// Se valida el formulario de actualización

        // Si la validación falla, se redirecciona de nuevo al formulario de edición con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            
            DB::beginTransaction();// Se inicia una transacción de base de datos

            
            $nombre = $request->input('nombre');// Se obtiene el nombre de la asignación del formulario

            // Se verifica si ya existe otra asignación con el mismo nombre, pero diferente ID
            $asignacionExistente = Asignacion::where('nombre', $nombre)->where('id', '!=', $asignacion->id)->first();

            // Si existe, se redirecciona de nuevo al formulario de edición con un mensaje de error        
            if ($asignacionExistente) {
                return redirect()->route('asignacions.index')->with('error', 'Ya existe una asignación con ese nombre.');
            }
            
            $asignacion->update($request->all());// Se actualiza la asignación con los datos proporcionados
        
            DB::commit(); // Se confirma la transacción de base de datos

            // Se redirecciona a la lista de asignaciones con un mensaje de éxito
            return redirect()->route('asignacions.index')->with('success', 'Asignación actualizada exitosamente.');

        } catch (\Exception $e) {
            // Si ocurre un error durante la transacción, se revierte y se redirecciona con un mensaje de error
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'Error al actualizar la asignación: ' . $e->getMessage());
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
            
            DB::beginTransaction();// Se inicia una transacción de base de datos

            $asignacion = Asignacion::findOrFail($id);// Se encuentra la asignación con el ID proporcionado
            
            $asignacion->delete();// Se elimina la asignación

            
            DB::commit();// Se confirma la transacción de base de datos

            // Se redirecciona a la lista de asignaciones con un mensaje de éxito
            return redirect()->route('asignacions.index')->with('success', 'Asignación borrado exitosamente.');
            
        } catch (ModelNotFoundException $e) {
            // Si la asignación no se encuentra, se revierte la transacción y se redirecciona con un mensaje de error
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'La asignación no existe.');

        } catch (QueryException $e) {
            // Si hay un error de consulta, se revierte la transacción y se redirecciona con un mensaje de error        
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'La asignación no puede eliminarse, tiene datos asociados.');

        } catch (\Exception $e) {
            // Si ocurre un error inesperado, se revierte la transacción y se redirecciona con un mensaje de error
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'Error al eliminar la asignación: ' . $e->getMessage());
        }
    }
}
