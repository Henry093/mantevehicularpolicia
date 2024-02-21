<?php

namespace App\Http\Controllers;

use App\Models\Mantestado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MantestadoController
 * @package App\Http\Controllers
 */
class MantestadoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:mantestados.index')->only('index');
        $this->middleware('can:mantestados.create')->only('create', 'store');
        $this->middleware('can:mantestados.edit')->only('edit', 'update');
        $this->middleware('can:mantestados.show')->only('show');
        $this->middleware('can:mantestados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda

        $query = Mantestado::query();// Se crea una consulta para obtener los mantestado
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $mantestados = $query->paginate(12);// Se obtienen los cantones paginados

        // Se devuelve la vista con los cantones paginados
        return view('mantestado.index', compact('mantestados'))
            ->with('i', (request()->input('page', 1) - 1) * $mantestados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mantestado = new Mantestado();// Se crea una nueva instancia de mantestado

        return view('mantestado.create', compact('mantestado'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Mantestado::$rules);// Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Se inicia una transacción de base de datos

            $nombre = Mantestado::where('nombre', $request->input('nombre'))->first();// Se busca si ya existe un cantón con el mismo nombre
            if ($nombre) {
                return redirect()->route('mantestados.create')->with('error', 'El estado de mantenimiento ya está registrado.');
            }

            Mantestado::create($request->all());// Se crea un nuevo mantestado con los datos proporcionados

            DB::commit();// Se confirma la transacción

            // Se redirige a la lista de mantestados con un mensaje de éxito
            return redirect()->route('mantestados.index')->with('success', 'Estado mantenimiento creado exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'Error al crear el estado de mantenimiento: ' . $e->getMessage());
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
            $mantestado = Mantestado::findOrFail($id);// Intenta encontrar el cantón por su ID

            return view('mantestado.show', compact('mantestado'));// Devuelve la vista con los detalles del mantestado

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el cantón, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no existe.');
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
            $mantestado = Mantestado::findOrFail($id);// Intenta encontrar el cantón por su ID
            
            return view('mantestado.edit', compact('mantestado'));// Devuelve la vista con los detalles del mantestado

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el cantón, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantestado $mantestado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantestado $mantestado)
    {
        $validator = Validator::make($request->all(), Mantestado::$rules);// Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del mantestado

            // Verificar si ya existe un mantestado con el mismo nombre pero distinto ID
            $mantestadoExistente = Mantestado::where('nombre', $nombre)->where('id', '!=', $mantestado->id)->first();
            if ($mantestadoExistente) {
                return redirect()->route('mantestados.index')->with('error', 'Ya existe un estado de mantenimiento con ese nombre.');
            }

            $mantestado->update($request->all());// Actualizar los datos del mantestado con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de mantestado con un mensaje de éxito
            return redirect()->route('mantestados.index')->with('success', 'Estado mantenimiento actualizado exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'Error al actualizar el estado de mantenimiento: ' . $e->getMessage());
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

            $mantestado = Mantestado::findOrFail($id);// Buscar el mantestado por su ID
            $mantestado->delete();// Eliminar el mantestado

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de mantestado con un mensaje de éxito
            return redirect()->route('mantestados.index')->with('success', 'Estado mantenimiento borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el mantestado no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'Error al eliminar el estado de mantenimiento: ' . $e->getMessage());
        }
    }
}
