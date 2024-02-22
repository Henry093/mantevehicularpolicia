<?php

namespace App\Http\Controllers;

use App\Models\Sangre;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class SangreController
 * @package App\Http\Controllers
 */
class SangreController extends Controller
{

    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:sangres.index')->only('index');
        $this->middleware('can:sangres.create')->only('create', 'store');
        $this->middleware('can:sangres.edit')->only('edit', 'update');
        $this->middleware('can:sangres.show')->only('show');
        $this->middleware('can:sangres.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Sangre::query(); // Se crea una consulta para obtener los sangre
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $sangres = $query->paginate(12);// Se obtienen los sangre paginados

        // Se devuelve la vista con los sangre paginados
        return view('sangre.index', compact('sangres'))
            ->with('i', (request()->input('page', 1) - 1) * $sangres->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sangre = new Sangre(); // Se crea una nueva instancia de sangre
        return view('sangre.create', compact('sangre'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Sangre::$rules);// Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $nombre = Sangre::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un sangres con el mismo nombre
            if ($nombre) {
                return redirect()->route('sangres.create')->with('error', 'El tipo de sangre ya está registrado.');
            }

            Sangre::create($request->all()); // Se crea un nuevo sangres con los datos proporcionados

            DB::commit(); // Se confirma la transacción

            // Se redirige a la lista de sangres con un mensaje de éxito
            return redirect()->route('sangres.index')->with('success', 'Tipo de sangre creada exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'Error al crear el tipo de sangre: ' . $e->getMessage());
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
            $sangre = Sangre::findOrFail($id); // Intenta encontrar el sangres por su ID
            return view('sangre.show', compact('sangre')); // Devuelve la vista con los detalles del sangres
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el sangres, redirige a la lista de sangres con un mensaje de error
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no existe.');
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
            $sangre = Sangre::findOrFail($id); // Intenta encontrar el sangres por su ID
            return view('sangre.edit', compact('sangre')); // Devuelve la vista con el sangres a editar

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el sangres, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Sangre $sangre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sangre $sangre)
    {
        $validator = Validator::make($request->all(), Sangre::$rules); // Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $nombre = $request->input('nombre');// Obtener el nuevo nombre del sangres

            // Verificar si ya existe un sangres con el mismo nombre pero distinto ID
            $sangreExistente = Sangre::where('nombre', $nombre)->where('id', '!=', $sangre->id)->first();
            if ($sangreExistente) {
                return redirect()->route('sangres.index')->with('error', 'Ya existe un tipo de sangre con ese nombre.');
            }

            $sangre->update($request->all());// Actualizar los datos del sangres con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de sangres con un mensaje de éxito
            return redirect()->route('sangres.index')->with('success', 'Tipo de sangre actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'Error al actualizar el tipo de sangre: ' . $e->getMessage());
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

            $sangre = Sangre::findOrFail($id);// Buscar el sangres por su ID
            $sangre->delete();// Eliminar el sangres

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('sangres.index')->with('success', 'Tipo de sangre borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el provincia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'Error al eliminar el tipo de sangre: ' . $e->getMessage());
        }
    }
}
