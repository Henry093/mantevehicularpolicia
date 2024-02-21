<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ParroquiaController
 * @package App\Http\Controllers
 */
class ParroquiaController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:parroquias.index')->only('index');
        $this->middleware('can:parroquias.create')->only('create', 'store');
        $this->middleware('can:parroquias.edit')->only('edit', 'update');
        $this->middleware('can:parroquias.show')->only('show');
        $this->middleware('can:parroquias.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Parroquia::query(); // Se crea una consulta para obtener los parroquias
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('provincia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('canton', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $parroquias = $query->paginate(12);// Se obtienen los parroquias paginados

        // Se devuelve la vista con los parroquias paginados
        return view('parroquia.index', compact('parroquias'))
            ->with('i', (request()->input('page', 1) - 1) * $parroquias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parroquia = new Parroquia();// Se crea una nueva instancia de parroquia
        $d_provincia = Provincia::all();// Se obtienen todas las provincias disponibles
        $d_canton = Canton::all();// Se obtienen todas las cantones disponibles

        return view('parroquia.create', compact('parroquia', 'd_provincia', 'd_canton'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Parroquia::$rules); // Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $nombre = Parroquia::where('nombre', $request->input('nombre'))->first(); // Se busca si ya existe un cantón con el mismo nombre
            if ($nombre) {
                return redirect()->route('parroquias.create')->with('error', 'La parroquia ya está registrada.');
            }

            Parroquia::create($request->all()); // Se crea un nuevo parroquia con los datos proporcionados

            DB::commit(); // Se confirma la transacción

            // Se redirige a la lista de parroquias con un mensaje de éxito
            return redirect()->route('parroquias.index')->with('success', 'Parroquia creada exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'Error al crear la parroquia: ' . $e->getMessage());
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
            $parroquia = Parroquia::findOrFail($id); // Intenta encontrar el cantón por su ID
            
            return view('parroquia.show', compact('parroquia')); // Devuelve la vista con los detalles del cantón

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el parroquias, redirige a la lista de parroquias con un mensaje de error
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no existe.');
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
            $parroquia = Parroquia::findOrFail($id); // Intenta encontrar el cantón por su ID
            $d_provincia = Provincia::all(); // Obtiene todas las provincias disponibles para mostrarlas en el formulario de edición
            $d_canton = Canton::all(); // Obtiene todas las cantones disponibles para mostrarlas en el formulario de edición

            return view('parroquia.edit', compact('parroquia', 'd_provincia', 'd_canton')); // Devuelve la vista con el parroquia a editar.

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el parroquia, redirige a la lista de parroquias con un mensaje de error
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Parroquia $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parroquia $parroquia)
    {
        $validator = Validator::make($request->all(), Parroquia::$rules); // Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del parroquia

            // Verificar si ya existe un parroquia con el mismo nombre pero distinto ID
            $parroquiaExistente = Parroquia::where('nombre', $nombre)->where('id', '!=', $parroquia->id)->first();
            if ($parroquiaExistente) {
                return redirect()->route('parroquias.index')->with('error', 'Ya existe una parroquia con ese nombre.');
            }
    
            $parroquia->update($request->all());// Actualizar los datos del parroquia con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de parroquia con un mensaje de éxito
            return redirect()->route('parroquias.index')->with('success', 'Parroquia actualizada exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'Error al actualizar la parroquia: ' . $e->getMessage());
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

            $parroquia = Parroquia::findOrFail($id);// Buscar el parroquia por su ID
            $parroquia->delete();// Eliminar el parroquia

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de parroquias con un mensaje de éxito
            return redirect()->route('parroquias.index')->with('success', 'Parroquia borrada exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el parroquia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'Error al eliminar la parroquia: ' . $e->getMessage());
        }
    }
}
