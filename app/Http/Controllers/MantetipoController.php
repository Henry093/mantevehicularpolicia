<?php

namespace App\Http\Controllers;

use App\Models\Mantetipo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MantetipoController
 * @package App\Http\Controllers
 */
class MantetipoController extends Controller
{
     // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:mantetipos.index')->only('index');
        $this->middleware('can:mantetipos.create')->only('create', 'store');
        $this->middleware('can:mantetipos.edit')->only('edit', 'update');
        $this->middleware('can:mantetipos.show')->only('show');
        $this->middleware('can:mantetipos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');// Se obtiene el término de búsqueda
        $query = Mantetipo::query();// Se crea una consulta para obtener los cantones
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('valor', 'like', '%' . $search . '%')
                    ->orWhere('descripcion', 'like', '%' . $search . '%');
            });
        }
        $mantetipos = $query->paginate(12);// Se obtienen los cantones paginados

        // Se devuelve la vista con los cantones paginados
        return view('mantetipo.index', compact('mantetipos'))
            ->with('i', (request()->input('page', 1) - 1) * $mantetipos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mantetipo = new Mantetipo();// Se crea una nueva instancia de mantetipo

        return view('mantetipo.create', compact('mantetipo'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Mantetipo::$rules);// Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Se inicia una transacción de base de datos

            $nombre = Mantetipo::where('nombre', $request->input('nombre'))->first();// Se busca si ya existe un mantetipo con el mismo nombre
            if ($nombre) {
                return redirect()->route('mantetipos.create')->with('error', 'El tipo de mantenimiento ya está registrado.');
            }

            Mantetipo::create($request->all());// Se crea un nuevo cantón con los datos proporcionados

            DB::commit();// Se confirma la transacción

            // Se redirige a la lista de cantones con un mensaje de éxito
            return redirect()->route('mantetipos.index')->with('success', 'Tipo de mantenimiento creado exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'Error al crear el tipo de mantenimiento: ' . $e->getMessage());
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
            $mantetipo = Mantetipo::findOrFail($id);// Intenta encontrar el mantetipo por su ID

            return view('mantetipo.show', compact('mantetipo'));// Devuelve la vista con los detalles del mantetipo

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el mantetipo, redirige a la lista de mantetipos con un mensaje de error
            return redirect()->route('mantetipos.index')->with('error', 'Tipo de mantenimiento no existe.');
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
            $mantetipo = Mantetipo::findOrFail($id);// Intenta encontrar el mantetipo por su ID

            return view('mantetipo.edit', compact('mantetipo'));// Devuelve la vista con el mantetipo a editar y las provincias disponibles

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el mantetipo, redirige a la lista de mantetipos con un mensaje de error
            return redirect()->route('mantetipos.index')->with('error', 'Tipo de mantenimiento no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantetipo $mantetipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantetipo $mantetipo)
    {
        $validator = Validator::make($request->all(), Mantetipo::$rules);// Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del mantetipo

            // Verificar si ya existe un mantetipo con el mismo nombre pero distinto ID
            $mantetipoExistente = Mantetipo::where('nombre', $nombre)->where('id', '!=', $mantetipo->id)->first();
            if ($mantetipoExistente) {
                return redirect()->route('mantetipos.index')->with('error', 'Ya existe un tipo de mantenimiento con ese nombre.');
            }

            $mantetipo->update($request->all());// Actualizar los datos del mantetipo con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de mantetipo con un mensaje de éxito
            return redirect()->route('mantetipos.index')->with('success', 'Tipo de mantenimiento actualizado exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'Error al actualizar el tipo de mantenimiento: ' . $e->getMessage());
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
    
            $mantetipo = Mantetipo::findOrFail($id);// Buscar el mantetipo por su ID
            $mantetipo->delete();// Eliminar el mantetipo
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de mantetipo con un mensaje de éxito
            return redirect()->route('mantetipos.index')->with('success', 'Tipo de mantenimiento borrado exitosamente.');
        
        } catch (ModelNotFoundException $e) {
            // En caso de que el mantetipo no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'El tipo de mantenimiento no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'El tipo de mantenimiento no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'Error al eliminar el tipo de mantenimiento: ' . $e->getMessage());
        }
    }
}
