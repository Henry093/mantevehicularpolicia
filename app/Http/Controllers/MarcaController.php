<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Tvehiculo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MarcaController
 * @package App\Http\Controllers
 */
class MarcaController extends Controller
{
     // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:marcas.index')->only('index');
        $this->middleware('can:marcas.create')->only('create', 'store');
        $this->middleware('can:marcas.edit')->only('edit', 'update');
        $this->middleware('can:marcas.show')->only('show');
        $this->middleware('can:marcas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda
        $query = Marca::query();// Se crea una consulta para obtener las marcas
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('tvehiculo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
    
        $marcas = $query->paginate(12);// Se obtienen los marcas paginados
    
        // Se devuelve la vista con los marcas paginados
        return view('marca.index', compact('marcas'))
            ->with('i', ($marcas->currentPage() - 1) * $marcas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marca = new Marca();// Se crea una nueva instancia de marca

        $tvehiculos = Tvehiculo::all();// Se obtienen todas las tvehiculos disponibles

        return view('marca.create', compact('marca', 'tvehiculos'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Marca::$rules);// Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Se inicia una transacción de base de datos
    
            $nombre = $request->input('nombre');
    
            // Verificar si la marca ya está registrada para tvehiculo = 1
            $marcaRegistradaTvehiculo1 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 1);
                })
                ->exists();
    
            // Verificar si la marca ya está registrada para tvehiculo = 2
            $marcaRegistradaTvehiculo2 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 2);
                })
                ->exists();
            
            // Verificar si la marca ya está registrada para tvehiculo = 3
            $marcaRegistradaTvehiculo3 = Marca::where('nombre', $nombre)
            ->whereHas('tvehiculo', function ($query) {
                $query->where('id', 3);
            })

            ->exists();
    
            if ($marcaRegistradaTvehiculo1 && $request->input('tvehiculo_id') == 1) {
                // La marca ya está registrada para tvehiculo = 1
                return redirect()->route('marcas.create')->with('error', 'La marca ya está registrada en automovil.');
            }
    
            if ($marcaRegistradaTvehiculo2 && $request->input('tvehiculo_id') == 2) {
                // La marca ya está registrada para tvehiculo = 2
                return redirect()->route('marcas.create')->with('error', 'La marca ya está registrada en camioneta.');
            }
    
            if ($marcaRegistradaTvehiculo3 && $request->input('tvehiculo_id') == 3) {
                // La marca ya está registrada para tvehiculo = 2
                return redirect()->route('marcas.create')->with('error', 'La marca ya está registrada en motocicleta.');
            }
    
            Marca::create($request->all());// Se crea una nueva marca con los datos proporcionados
    
            DB::commit();// Se confirma la transacción
    
            // Se redirige a la lista de cantones con un mensaje de éxito
            return redirect()->route('marcas.index')->with('success', 'Marca creada exitosamente.');

        } catch (\Exception $e) {
             // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'Error al crear la marca: ' . $e->getMessage());
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
            $marca = Marca::findOrFail($id);// Intenta encontrar el marca por su ID

            return view('marca.show', compact('marca'));// Devuelve la vista con los detalles del marca

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el marca, redirige a la lista de marcas con un mensaje de error
            return redirect()->route('marcas.index')->with('error', 'La marca no existe.');
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
            $marca = Marca::findOrFail($id);// Intenta encontrar el cantón por su ID

            $tvehiculos = Tvehiculo::all();// Obtiene todas las tvehiculos disponibles para mostrarlas en el formulario de edición

            return view('marca.edit', compact('marca', 'tvehiculos'));// Devuelve la vista con el marcas a editar y las tvehiculos disponibles

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el marcas, redirige a la lista de marcas con un mensaje de error
            return redirect()->route('marcas.index')->with('error', 'La marca no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        $validator = Validator::make($request->all(), Marca::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('nombre');// Obtener el nuevo nombre del cantón
    
            // Verificar si la marca ya está registrada para tvehiculo = 1
            $marcaRegistradaTvehiculo1 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 1);
                })
                ->where('id', '!=', $marca->id)
                ->exists();
    
            // Verificar si la marca ya está registrada para tvehiculo = 2
            $marcaRegistradaTvehiculo2 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 2);
                })
                ->where('id', '!=', $marca->id)
                ->exists();
    
            // Verificar si la marca ya está registrada para tvehiculo = 3
            $marcaRegistradaTvehiculo3 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 3);
                })
                ->where('id', '!=', $marca->id)
                ->exists();
    
            // Verificar si la marca ya está registrada para los tipos de vehículo
            if ($marcaRegistradaTvehiculo1 && $request->input('tvehiculo_id') == 1) {
                // La marca ya está registrada para tvehiculo = 1
                return redirect()->route('marcas.index')->with('error', 'La marca ya está registrada en automóvil.');
            }
    
            if ($marcaRegistradaTvehiculo2 && $request->input('tvehiculo_id') == 2) {
                // La marca ya está registrada para tvehiculo = 2
                return redirect()->route('marcas.index')->with('error', 'La marca ya está registrada en camioneta.');
            }
    
            if ($marcaRegistradaTvehiculo3 && $request->input('tvehiculo_id') == 3) {
                // La marca ya está registrada para tvehiculo = 3
                return redirect()->route('marcas.index')->with('error', 'La marca ya está registrada en motocicleta.');
            }
    
            // Si no se encuentra registrada para el tipo de vehículo correspondiente, se procede con la actualización
            $marca->update($request->all());
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('marcas.index')->with('success', 'Marca actualizada exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'Error al actualizar la marca: ' . $e->getMessage());
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

            $marca = Marca::findOrFail($id);// Buscar el marca por su ID
            $marca->delete();// Eliminar el marca

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de marcas con un mensaje de éxito
            return redirect()->route('marcas.index')->with('success', 'Marca borrada exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el marca no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'La marca no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'La marca no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'Error al eliminar la marca: ' . $e->getMessage());
        }
    }
}
