<?php

namespace App\Http\Controllers;

use App\Models\Tnovedade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class TnovedadeController
 * @package App\Http\Controllers
 */
class TnovedadeController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:tnovedades.index')->only('index');
        $this->middleware('can:tnovedades.create')->only('create', 'store');
        $this->middleware('can:tnovedades.edit')->only('edit', 'update');
        $this->middleware('can:tnovedades.show')->only('show');
        $this->middleware('can:tnovedades.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Tnovedade::query(); // Se crea una consulta para obtener los tnovedades
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $tnovedades = $query->paginate(12);// Se obtienen los tnovedades paginados

        // Se devuelve la vista con los tnovedades paginados
        return view('tnovedade.index', compact('tnovedades'))
            ->with('i', (request()->input('page', 1) - 1) * $tnovedades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tnovedade = new Tnovedade();// Se crea una nueva instancia de tnovedade
        return view('tnovedade.create', compact('tnovedade'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Tnovedade::$rules); // Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos
    
            $nombre = Tnovedade::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un provincia con el mismo nombre
            if ($nombre) {
                return redirect()->route('tnovedades.create')->with('error', 'El tipo de novedad ya está registrado.');
            }
    
            Tnovedade::create($request->all()); // Se crea un nuevo Tnovedade con los datos proporcionados
    
            DB::commit();// Se confirma la transacción
    
            // Se redirige a la lista de tnovedades con un mensaje de éxito
            return redirect()->route('tnovedades.index')->with('success', 'Tipo de novedad creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'Error al crear el tipo de novedad: ' . $e->getMessage());
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
            $tnovedade = Tnovedade::findOrFail($id); // Intenta encontrar el tnovedades por su ID
            return view('tnovedade.show', compact('tnovedade'));// Devuelve la vista con los detalles del tnovedades
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el tnovedades, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no existe.');
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
            $tnovedade = Tnovedade::findOrFail($id); // Intenta encontrar el tnovedades por su ID
            return view('tnovedade.edit', compact('tnovedade')); // Devuelve la vista con el tnovedades a editar
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el tnovedades, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tnovedade $tnovedade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tnovedade $tnovedade)
    {
        $validator = Validator::make($request->all(), Tnovedade::$rules); // Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del tnovedades
            
            // Verificar si ya existe un tnovedades con el mismo nombre pero distinto ID
            $tnovedadeExistente = Tnovedade::where('nombre', $nombre)->where('id', '!=', $tnovedade->id)->first();
            if ($tnovedadeExistente) {
                return redirect()->route('tnovedades.index')->with('error', 'Ya existe un tipo de novedad con ese nombre.');
            }
    
            $tnovedade->update($request->all());// Actualizar los datos del tnovedades con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('tnovedades.index')->with('success', 'Tipo de novedad actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'Error al actualizar el tipo de novedad: ' . $e->getMessage());
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
    
            $tnovedade = Tnovedade::findOrFail($id);// Buscar el tnovedade por su ID
            $tnovedade->delete();// Eliminar el tnovedade
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('tnovedades.index')->with('success', 'Tipo de novedad borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el provincia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'Error al eliminar el tipo de novedad: ' . $e->getMessage());
        }
    }
}
