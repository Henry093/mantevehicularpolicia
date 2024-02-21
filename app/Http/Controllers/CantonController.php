<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class CantonController
 * @package App\Http\Controllers
 */
class CantonController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:cantons.index')->only('index');
        $this->middleware('can:cantons.create')->only('create', 'store');
        $this->middleware('can:cantons.edit')->only('edit', 'update');
        $this->middleware('can:cantons.show')->only('show');
        $this->middleware('can:cantons.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        
        $query = Canton::query(); // Se crea una consulta para obtener los cantones
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%')
                ->orWhereHas('provincia', function ($q) use ($search) {
                    $q->where('nombre', 'like', '%' . $search . '%');
                });
        }

        $cantons = $query->paginate(12);// Se obtienen los cantones paginados

        // Se devuelve la vista con los cantones paginados
        return view('canton.index', compact('cantons'))
            ->with('i', (request()->input('page', 1) - 1) * $cantons->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $canton = new Canton(); // Se crea una nueva instancia de Canton
        
        $d_provincia = Provincia::all();// Se obtienen todas las provincias disponibles
        
        return view('canton.create', compact('canton', 'd_provincia'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Canton::$rules); // Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            
            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $nombre = Canton::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un cantón con el mismo nombre
            if ($nombre) {
                return redirect()->route('cantons.create')->with('error', 'El cantón ya está registrado.');
            }
            Canton::create($request->all()); // Se crea un nuevo cantón con los datos proporcionados

            DB::commit(); // Se confirma la transacción

            // Se redirige a la lista de cantones con un mensaje de éxito
            return redirect()->route('cantons.index')->with('success', 'Cantón creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'Error al crear el cantón: ' . $e->getMessage());
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
            
            $canton = Canton::findOrFail($id); // Intenta encontrar el cantón por su ID
            
            return view('canton.show', compact('canton')); // Devuelve la vista con los detalles del cantón

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el cantón, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('cantons.index')->with('error', 'El cantón no existe.');
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
            
            $canton = Canton::findOrFail($id); // Intenta encontrar el cantón por su ID
            
            $d_provincia = Provincia::all(); // Obtiene todas las provincias disponibles para mostrarlas en el formulario de edición
            
            return view('canton.edit', compact('canton', 'd_provincia')); // Devuelve la vista con el cantón a editar

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el cantón, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('cantons.index')->with('error', 'El cantón no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Canton $canton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Canton $canton)
    {
        
        $validator = Validator::make($request->all(), Canton::$rules); // Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del cantón
            
            // Verificar si ya existe un cantón con el mismo nombre pero distinto ID
            $cantonExistente = Canton::where('nombre', $nombre)->where('id', '!=', $canton->id)->first();
            if ($cantonExistente) {
                return redirect()->route('cantons.index')->with('error', 'Ya existe un cantón con ese nombre.');
            }   
            
            $canton->update($request->all());// Actualizar los datos del cantón con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('cantons.index')->with('success', 'Cantón actualizado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'Error al actualizar el cantón: ' . $e->getMessage());
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

            $canton = Canton::findOrFail($id);// Buscar el cantón por su ID
            $canton->delete();// Eliminar el cantón

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('cantons.index')->with('success', 'Cantón borrado exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el cantón no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'El cantón no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'El cantón no puede eliminarse, tiene datos asociados.');
            
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'Error al eliminar el cantón: ' . $e->getMessage());
        }
    }
}
