<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ModeloController
 * @package App\Http\Controllers
 */
class ModeloController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:modelos.index')->only('index');
        $this->middleware('can:modelos.create')->only('create', 'store');
        $this->middleware('can:modelos.edit')->only('edit', 'update');
        $this->middleware('can:modelos.show')->only('show');
        $this->middleware('can:modelos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda
        $query = Modelo::query();// Se crea una consulta para obtener los modelos
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('marca', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $modelos = $query->paginate(12);// Se obtienen los modelos paginados

        // Se devuelve la vista con los modelos paginados
        return view('modelo.index', compact('modelos'))
            ->with('i', (request()->input('page', 1) - 1) * $modelos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelo = new Modelo();// Se crea una nueva instancia de modelo

        $d_marca = Marca::all();// Se obtienen todas las marcas disponibles

        return view('modelo.create', compact('modelo', 'd_marca'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Modelo::$rules);// Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Se inicia una transacción de base de datos
    
            $nombre = Modelo::where('nombre', $request->input('nombre'))->first();// Se busca si ya existe un cantón con el mismo nombre
            if ($nombre) {
                return redirect()->route('modelos.create')->with('error', 'El modelo ya está registrado.');
            }
    
            Modelo::create($request->all());// Se crea un nuevo cantón con los datos proporcionados
    
            DB::commit();// Se confirma la transacción
    
            // Se redirige a la lista de cantones con un mensaje de éxito
            return redirect()->route('modelos.index')->with('success', 'Modelo creado exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('modelos.index')->with('error', 'Error al crear el modelo: ' . $e->getMessage());
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
            $modelo = Modelo::findOrFail($id);// Intenta encontrar el cantón por su ID

            return view('modelo.show', compact('modelo'));// Devuelve la vista con los detalles del modelo

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el modelo, redirige a la lista de modelos con un mensaje de error
            return redirect()->route('modelos.index')->with('error', 'El modelo no existe.');
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
            $modelo = Modelo::findOrFail($id);// Intenta encontrar el modelo por su ID

            $d_marca = Marca::all();// Obtiene todas las marcas disponibles para mostrarlas en el formulario de edición

            return view('modelo.edit', compact('modelo', 'd_marca'));// Devuelve la vista con el modelo a editar y las marcas disponibles

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el modelo, redirige a la lista de modelos con un mensaje de error
            return redirect()->route('modelos.index')->with('error', 'El modelo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Modelo $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modelo $modelo)
    {
        $validator = Validator::make($request->all(), Modelo::$rules);// Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del modelo

            // Verificar si ya existe un modelo con el mismo nombre pero distinto ID
            $modeloExistente = Modelo::where('nombre', $nombre)->where('id', '!=', $modelo->id)->first();
            if ($modeloExistente) {
                return redirect()->route('modelos.index')->with('error', 'Ya existe un modelo con ese nombre.');
            }

            $modelo->update($request->all());// Actualizar los datos del modelo con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de modelos con un mensaje de éxito
            return redirect()->route('modelos.index')->with('success', 'Modelo actualizado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('modelos.index')->with('error', 'Error al actualizar el modelo: ' . $e->getMessage());
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

            $modelo = Modelo::findOrFail($id);// Buscar el modelo por su ID
            $modelo->delete();// Eliminar el modelo

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de modelo con un mensaje de éxito
            return redirect()->route('modelos.index')->with('success', 'Modelo borrado exitosamente.');
            
        } catch (ModelNotFoundException $e) {
            // En caso de que el modelo no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('modelos.index')->with('error', 'El modelo no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('modelos.index')->with('error', 'El modelo no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('modelos.index')->with('error', 'Error al eliminar el modelo: ' . $e->getMessage());
        }
    }
}
