<?php

namespace App\Http\Controllers;

use App\Models\Vpasajero;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class VpasajeroController
 * @package App\Http\Controllers
 */
class VpasajeroController extends Controller
{

    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:vpasajeros.index')->only('index');
        $this->middleware('can:vpasajeros.create')->only('create', 'store');
        $this->middleware('can:vpasajeros.edit')->only('edit', 'update');
        $this->middleware('can:vpasajeros.show')->only('show');
        $this->middleware('can:vpasajeros.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Vpasajero::query(); // Se crea una consulta para obtener los provincias
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $vpasajeros = $query->paginate(12);// Se obtienen los provincias paginados

        // Se devuelve la vista con los provincias paginados
        return view('vpasajero.index', compact('vpasajeros'))
            ->with('i', (request()->input('page', 1) - 1) * $vpasajeros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vpasajero = new Vpasajero(); // Se crea una nueva instancia de vpasajero
        return view('vpasajero.create', compact('vpasajero')); // Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Vpasajero::$rules); // Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $nombre = Vpasajero::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un provincia con el mismo nombre
            if ($nombre) {
                return redirect()->route('vpasajeros.create')->with('error', 'La capacidad de pasajeros ya está registrada.');
            }

            Vpasajero::create($request->all()); // Se crea un nuevo vpasajero con los datos proporcionados

            DB::commit(); // Se confirma la transacción

            // Se redirige a la lista de vpasajero con un mensaje de éxito
            return redirect()->route('vpasajeros.index')->with('success', 'Capacidad de pasajeros creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'Error al crear la capacidad de pasajeros: ' . $e->getMessage());
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
            $vpasajero = Vpasajero::findOrFail($id); // Intenta encontrar el vpasajero por su ID
            return view('vpasajero.show', compact('vpasajero')); // Devuelve la vista con los detalles del vpasajero
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vpasajero, redirige a la lista de vpasajero con un mensaje de error
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no existe.');
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
            $vpasajero = Vpasajero::findOrFail($id); // Intenta encontrar el vpasajeros por su ID
            return view('vpasajero.edit', compact('vpasajero')); // Devuelve la vista con el vpasajeros a editar
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vpasajeros, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vpasajero $vpasajero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vpasajero $vpasajero)
    {
        $validator = Validator::make($request->all(), Vpasajero::$rules); // Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del Vpasajero

            // Verificar si ya existe un vpasajeros con el mismo nombre pero distinto ID
            $vpasajeroExistente = Vpasajero::where('nombre', $nombre)->where('id', '!=', $vpasajero->id)->first();
            if ($vpasajeroExistente) {
                return redirect()->route('vpasajeros.index')->with('error', 'Ya existe una capacidad de pasajeros con ese nombre.');
            }

            $vpasajero->update($request->all());// Actualizar los datos del vpasajeros con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('vpasajeros.index')->with('success', 'Capacidad de pasajeros actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'Error al actualizar la capacidad de pasajeros: ' . $e->getMessage());
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

            $vpasajero = Vpasajero::findOrFail($id);// Buscar el vpasajeros por su ID
            $vpasajero->delete();// Eliminar el vpasajeros

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('vpasajeros.index')->with('success', 'Capacidad de pasajeros borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el vpasajeros no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'Error al eliminar la capacidad de pasajeros: ' . $e->getMessage());
        }
    }
}
