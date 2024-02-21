<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class GradoController
 * @package App\Http\Controllers
 */
class GradoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:grados.index')->only('index');
        $this->middleware('can:grados.create')->only('create', 'store');
        $this->middleware('can:grados.edit')->only('edit', 'update');
        $this->middleware('can:grados.show')->only('show');
        $this->middleware('can:grados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda
        $query = Grado::query();// Se crea una consulta para obtener los grados
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $grados = $query->paginate(12);// Se obtienen los grados paginados

        // Se devuelve la vista con los cantones paginados
        return view('grado.index', compact('grados'))
            ->with('i', (request()->input('page', 1) - 1) * $grados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grado = new Grado();// Se crea una nueva instancia de grado

        return view('grado.create', compact('grado'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Grado::$rules);// Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Se inicia una transacción de base de datos
    
            $nombre = Grado::where('nombre', $request->input('nombre'))->first();// Se busca si ya existe un grado con el mismo nombre
            if ($nombre) {
                return redirect()->route('grados.create')->with('error', 'El grado ya está registrado.');
            }
    
            Grado::create($request->all());// Se crea un nuevo cantón con los datos proporcionados
    
            DB::commit();// Se confirma la transacción
    
            // Se redirige a la lista de cantones con un mensaje de éxito
            return redirect()->route('grados.index')->with('success', 'Grado creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'Error al crear el grado: ' . $e->getMessage());
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
            $grado = Grado::findOrFail($id);// Intenta encontrar el cantón por su ID
            return view('grado.show', compact('grado'));// Devuelve la vista con los detalles del grado

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el cantón, redirige a la lista de grados con un mensaje de error
            return redirect()->route('grados.index')->with('error', 'El grado no existe.');
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
            $grado = Grado::findOrFail($id);// Intenta encontrar el grado por su ID

            return view('grado.edit', compact('grado'));// Devuelve la vista con el grado a editar

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el grado, redirige a la lista de grados con un mensaje de error
            return redirect()->route('grados.index')->with('error', 'El grado no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Grado $grado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grado $grado)
    {
        $validator = Validator::make($request->all(), Grado::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del grado

            // Verificar si ya existe un grado con el mismo nombre pero distinto ID
            $gradoExistente = Grado::where('nombre', $nombre)->where('id', '!=', $grado->id)->first();
            if ($gradoExistente) {
                return redirect()->route('grados.index')->with('error', 'Ya existe un grado con ese nombre.');
            }
    
            $grado->update($request->all());// Actualizar los datos del grado con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de grados con un mensaje de éxito
            return redirect()->route('grados.index')->with('success', 'Grado actualizado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'Error al actualizar el grado: ' . $e->getMessage());
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

            $grado = Grado::findOrFail($id);// Buscar el grado por su ID
            $grado->delete();// Eliminar el grado

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de grados con un mensaje de éxito
            return redirect()->route('grados.index')->with('success', 'Grado borrado exitosamente.');
        
        } catch (ModelNotFoundException $e) {
             // En caso de que el grado no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'El grado no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'El grado no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'Error al eliminar el grado: ' . $e->getMessage());
        }
    }
}
