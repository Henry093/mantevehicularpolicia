<?php

namespace App\Http\Controllers;

use App\Models\Tvehiculo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class TvehiculoController
 * @package App\Http\Controllers
 */
class TvehiculoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:tvehiculos.index')->only('index');
        $this->middleware('can:tvehiculos.create')->only('create', 'store');
        $this->middleware('can:tvehiculos.edit')->only('edit', 'update');
        $this->middleware('can:tvehiculos.show')->only('show');
        $this->middleware('can:tvehiculos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Tvehiculo::query(); // Se crea una consulta para obtener los tvehiculos
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $tvehiculos = $query->paginate(12);// Se obtienen los tvehiculos paginados

        // Se devuelve la vista con los tvehiculos paginados
        return view('tvehiculo.index', compact('tvehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $tvehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tvehiculo = new Tvehiculo(); // Se crea una nueva instancia de tvehiculo
        return view('tvehiculo.create', compact('tvehiculo'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Tvehiculo::$rules); // Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $nombre = Tvehiculo::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un tvehiculos con el mismo nombre
            if ($nombre) {
                return redirect()->route('tvehiculos.create')->with('error', 'El tipo de vehículo ya está registrado.');
            }

            Tvehiculo::create($request->all()); // Se crea un nuevo tvehiculos con los datos proporcionados

            DB::commit(); // Se confirma la transacción

            // Se redirige a la lista de tvehiculos con un mensaje de éxito
            return redirect()->route('tvehiculos.index')->with('success', 'Tipo de vehículo creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'Error al crear el tipo de vehículo: ' . $e->getMessage());
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
            $tvehiculo = Tvehiculo::findOrFail($id); // Intenta encontrar el tvehiculos por su ID
            return view('tvehiculo.show', compact('tvehiculo')); // Devuelve la vista con los detalles del tvehiculos
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el tvehiculos, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no existe.');
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
            $tvehiculo = Tvehiculo::findOrFail($id); // Intenta encontrar el tvehiculos por su ID
            return view('tvehiculo.edit', compact('tvehiculo')); // Devuelve la vista con el tvehiculos a editar
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el tvehiculos, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tvehiculo $tvehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tvehiculo $tvehiculo)
    {
        $validator = Validator::make($request->all(), Tvehiculo::$rules); // Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del tvehiculos
            
            // Verificar si ya existe un tvehiculos con el mismo nombre pero distinto ID
            $tvehiculoExistente = Tvehiculo::where('nombre', $nombre)->where('id', '!=', $tvehiculo->id)->first();
            if ($tvehiculoExistente) {
                return redirect()->route('tvehiculos.index')->with('error', 'Ya existe un tipo de vehículo con ese nombre.');
            }

            $tvehiculo->update($request->all());// Actualizar los datos del tvehiculos con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de tvehiculos con un mensaje de éxito
            return redirect()->route('tvehiculos.index')->with('success', 'Tipo de vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'Error al actualizar el tipo de vehículo: ' . $e->getMessage());
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

            $tvehiculo = Tvehiculo::findOrFail($id);// Buscar el tvehiculos por su ID
            $tvehiculo->delete();// Eliminar el tvehiculos

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('tvehiculos.index')->with('success', 'Tipo de vehículo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el tvehiculos no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'Error al eliminar el tipo de vehículo: ' . $e->getMessage());
        }
    }
}
