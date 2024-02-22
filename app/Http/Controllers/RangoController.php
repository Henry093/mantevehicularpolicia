<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Rango;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class RangoController
 * @package App\Http\Controllers
 */
class RangoController extends Controller
{
        // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:rangos.index')->only('index');
        $this->middleware('can:rangos.create')->only('create', 'store');
        $this->middleware('can:rangos.edit')->only('edit', 'update');
        $this->middleware('can:rangos.show')->only('show');
        $this->middleware('can:rangos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda
        $query = Rango::query(); // Se crea una consulta para obtener los provincias

        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('grado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $rangos = $query->paginate(12); // Se obtienen los provincias paginados

        // Se devuelve la vista con los provincias paginados
        return view('rango.index', compact('rangos'))
            ->with('i', (request()->input('page', 1) - 1) * $rangos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rango = new Rango(); // Se crea una nueva instancia de rango

        $d_grado = Grado::all();

        return view('rango.create', compact('rango', 'd_grado'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Rango::$rules); // Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $nombre = Rango::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un provincia con el mismo nombre

            if ($nombre) {
                return redirect()->route('rangos.create')->with('error', 'El rango ya está registrado.');
            }

            Rango::create($request->all()); // Se crea un nuevo provincia con los datos proporcionados

            DB::commit(); // Se confirma la transacción

            // Se redirige a la lista de provincias con un mensaje de éxito
            return redirect()->route('rangos.index')->with('success', 'Rango creado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'Error al crear el rango: ' . $e->getMessage());
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
            $rango = Rango::findOrFail($id); // Intenta encontrar el provincia por su ID
            return view('rango.show', compact('rango')); // Devuelve la vista con los detalles del provincia
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el provincia, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('rangos.index')->with('error', 'El rango no existe.');
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
            $rango = Rango::findOrFail($id); // Intenta encontrar el rango por su ID
            $d_grado = Grado::all();
            return view('rango.edit', compact('rango', 'd_grado'));// Devuelve la vista con el provincia a editar
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el rango, redirige a la lista de rangos con un mensaje de error
            return redirect()->route('rangos.index')->with('error', 'El rango no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Rango $rango
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rango $rango)
    {
        $validator = Validator::make($request->all(), Rango::$rules); // Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del provincia
            
            // Verificar si ya existe un provincia con el mismo nombre pero distinto ID
            $rangoExistente = Rango::where('nombre', $nombre)->where('id', '!=', $rango->id)->first();
            if ($rangoExistente) {
                return redirect()->route('rangos.index')->with('error', 'Ya existe un rango con ese nombre.');
            }

            $rango->update($request->all());// Actualizar los datos del provincia con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('rangos.index')->with('success', 'Rango actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'Error al actualizar el rango: ' . $e->getMessage());
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

            $rango = Rango::findOrFail($id);// Buscar el rango por su ID
            $rango->delete();// Eliminar el rango

            DB::commit();// Confirmar la transacción

            
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('rangos.index')->with('success', 'Rango borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el provincia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'El rango no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'El rango no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'Error al eliminar el rango: ' . $e->getMessage());
        }
    }
}
