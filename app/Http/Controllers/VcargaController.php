<?php

namespace App\Http\Controllers;

use App\Models\Vcarga;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class VcargaController
 * @package App\Http\Controllers
 */
class VcargaController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:vcargas.index')->only('index');
        $this->middleware('can:vcargas.create')->only('create', 'store');
        $this->middleware('can:vcargas.edit')->only('edit', 'update');
        $this->middleware('can:vcargas.show')->only('show');
        $this->middleware('can:vcargas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Vcarga::query(); // Se crea una consulta para obtener los vcarga
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $vcargas = $query->paginate(12);// Se obtienen los vcarga paginados

        // Se devuelve la vista con los vcarga paginados
        return view('vcarga.index', compact('vcargas'))
            ->with('i', (request()->input('page', 1) - 1) * $vcargas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vcarga = new Vcarga();  // Se crea una nueva instancia de vcarga
        return view('vcarga.create', compact('vcarga')); // Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Vcarga::$rules); // Se validan los datos del formulario
        
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $nombre = Vcarga::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un provincia con el mismo nombre
            if ($nombre) {
                return redirect()->route('vcargas.create')->with('error', 'La capacidad de carga del vehículo ya está registrada.');
            }

            Vcarga::create($request->all()); // Se crea un nuevo provincia con los datos proporcionados

            DB::commit();// Se confirma la transacción

            // Se redirige a la lista de vcargas con un mensaje de éxito
            return redirect()->route('vcargas.index')->with('success', 'Capacidad de carga del vehículo creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'Error al crear la capacidad de carga del vehículo: ' . $e->getMessage());
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
            $vcarga = Vcarga::findOrFail($id); // Intenta encontrar el vcargas por su ID
            return view('vcarga.show', compact('vcarga')); // Devuelve la vista con los detalles del vcargas
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vcargas, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no existe.');
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
            $vcarga = Vcarga::findOrFail($id); // Intenta encontrar el vcargas por su ID
            return view('vcarga.edit', compact('vcarga')); // Devuelve la vista con el vcargas a editar
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vcargas, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vcarga $vcarga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vcarga $vcarga)
    {
        $validator = Validator::make($request->all(), Vcarga::$rules); // Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del vcargas
            
            // Verificar si ya existe un vcargas con el mismo nombre pero distinto ID
            $vcargaExistente = Vcarga::where('nombre', $nombre)->where('id', '!=', $vcarga->id)->first();
            if ($vcargaExistente) {
                return redirect()->route('vcargas.index')->with('error', 'Ya existe una capacidad de carga del vehículo con ese nombre.');
            }

            $vcarga->update($request->all());// Actualizar los datos del vcargas con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de vcargas con un mensaje de éxito
            return redirect()->route('vcargas.index')->with('success', 'Capacidad de carga del vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'Error al actualizar la capacidad de carga del vehículo: ' . $e->getMessage());
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
    
            $vcarga = Vcarga::findOrFail($id);// Buscar el vcargas por su ID
            $vcarga->delete();// Eliminar el vcargas
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de vcargas con un mensaje de éxito
            return redirect()->route('vcargas.index')->with('success', 'Capacidad de carga del vehículo borrada exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el provincia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'Error al eliminar la capacidad de carga del vehículo: ' . $e->getMessage());
        }
    }
}
