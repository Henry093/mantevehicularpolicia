<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tvehiculo;
use App\Models\Vcarga;
use App\Models\Vehiculo;
use App\Models\Vehieliminacion;
use App\Models\Vpasajero;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class VehiculoController
 * @package App\Http\Controllers
 */
class VehiculoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:vehiculos.index')->only('index');
        $this->middleware('can:vehiculos.create')->only('create', 'store');
        $this->middleware('can:vehiculos.edit')->only('edit', 'update');
        $this->middleware('can:vehiculos.show')->only('show');
        $this->middleware('can:vehiculos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Vehiculo::query(); // Se crea una consulta para obtener los Vehiculo
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('placa', 'like', '%' . $search . '%')
                    ->orWhere('chasis', 'like', '%' . $search . '%')
                    ->orWhere('motor', 'like', '%' . $search . '%')
                    ->orWhere('kilometraje', 'like', '%' . $search . '%')
                    ->orWhere('cilindraje', 'like', '%' . $search . '%')
                    ->orWhereHas('tvehiculo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('marca', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('modelo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('vcarga', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('vpasajero', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $vehiculos = $query->paginate(12);// Se obtienen los vehiculo paginados

        // Se devuelve la vista con los vehiculo paginados
        return view('vehiculo.index', compact('vehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $vehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehiculo = new Vehiculo(); // Se crea una nueva instancia de provincia
        $d_vehiculo = Tvehiculo::all();
        $d_marca = Marca::all();
        $d_modelo = Modelo::all();
        $d_carga = Vcarga::all();
        $d_pasajero = Vpasajero::all();
        $d_estado = Estado::all();

        $edicion = false;
    // Se devuelve la vista con el formulario de creación
        return view('vehiculo.create', compact('vehiculo', 'd_vehiculo', 'd_marca', 'd_modelo', 'd_carga', 'd_pasajero', 'd_estado', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Vehiculo::$rules); // Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            // Verificar existencia en Vehiculo
            $placa = Vehiculo::where('placa', $request->input('placa'))->exists();
            $chasis = Vehiculo::where('chasis', $request->input('chasis'))->exists();
            $motor = Vehiculo::where('motor', $request->input('motor'))->exists();
            
            if ($placa) {
                return redirect()->route('vehiculos.index')->with('error', 'La placa ya está registrada.');
            } elseif ($chasis) {
                return redirect()->route('vehiculos.index')->with('error', 'El Chasis ya está registrado.');
            } elseif ($motor) {
                return redirect()->route('vehiculos.index')->with('error', 'El motor ya está registrado.');
            }

            $placaE = Vehieliminacion::where('placa', $request->input('placa'))->exists();
            $chasisE = Vehieliminacion::where('chasis', $request->input('chasis'))->exists();
            $motorE = Vehieliminacion::where('motor', $request->input('motor'))->exists();

            // Verificar existencia en Vehieliminacions            
            if ($placaE) {
                return redirect()->route('vehiculos.index')->with('error', 'La placa ya está registrada como eliminado.');
            } elseif ($chasisE) {
                return redirect()->route('vehiculos.index')->with('error', 'El Chasis ya está registrado como eliminado.');
            } elseif ($motorE) {
                return redirect()->route('vehiculos.index')->with('error', 'El motor ya está registrado como eliminado.');
            }
    
            // Verificar si el estado ya está presente en la solicitud
            $estado = $request->input('estado_id');
    
            if (empty($estado)) {
                // Si no se proporciona un estado, en este caso 1 = Activo
                $request->merge(['estado_id' => '1']);
            }
    
            DB::beginTransaction(); // Se inicia una transacción de base de datos
    
            Vehiculo::create($request->all()); // Se crea un nuevo vehiculos con los datos proporcionados
    
            DB::commit(); // Se confirma la transacción
    
            // Se redirige a la lista de vehiculos con un mensaje de éxito
            return redirect()->route('vehiculos.index')->with('success', 'Vehículo creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehiculos.index')->with('error', 'Error al crear el vehículo: ' . $e->getMessage());
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
            $vehiculo = Vehiculo::findOrFail($id); // Intenta encontrar el vehiculos por su ID
            return view('vehiculo.show', compact('vehiculo'));// Devuelve la vista con los detalles del vehiculos
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vehiculos, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('vehiculos.index')->with('error', 'El vehículo no existe.');
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
            $vehiculo = Vehiculo::findOrFail($id); // Intenta encontrar el vehiculo por su ID
            $d_vehiculo = Tvehiculo::all();
            $d_marca = Marca::all();
            $d_modelo = Modelo::all();
            $d_carga = Vcarga::all();
            $d_pasajero = Vpasajero::all();
            $d_estado = Estado::all();
    
            $edicion = true;
            // Devuelve la vista con el vehiculo a editar
            return view('vehiculo.edit', compact('vehiculo', 'd_vehiculo', 'd_marca', 'd_modelo', 'd_carga', 'd_pasajero', 'd_estado', 'edicion'));
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vehiculos, redirige a la lista de vehiculos con un mensaje de error
            return redirect()->route('vehiculos.index')->with('error', 'El vehículo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehiculo $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        $rules = [
            'tvehiculo_id' => 'required',
            'placa' => 'required|max:8',
            'chasis' => 'required',
            'marca_id' => 'required',
            'modelo_id' => 'required',
            'motor' => 'required',
            'kilometraje' => 'required|numeric|max:999999',
            'cilindraje' => 'required',
            'vcarga_id' => 'required',
            'vpasajero_id' => 'required',
            'estado_id' => 'required',
        ];
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), $rules);
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            // Verificar existencia en Vehiculo   
            $placa = Vehiculo::where('placa', $request->input('placa'))->where('id', '!=', $vehiculo->id)->exists();
            $chasis = Vehiculo::where('chasis', $request->input('chasis'))->where('id', '!=', $vehiculo->id)->exists();
            $motor = Vehiculo::where('motor', $request->input('motor'))->where('id', '!=', $vehiculo->id)->exists();
    
            if ($placa) {
                return redirect()->route('vehiculos.edit', $vehiculo)->with('error', 'La placa ya está registrada.');
            } elseif ($chasis) {
                return redirect()->route('vehiculos.edit', $vehiculo)->with('error', 'El chasis ya está registrado.');
            } elseif ($motor) {
                return redirect()->route('vehiculos.edit', $vehiculo)->with('error', 'El motor ya está registrado.');
            }
            // Verificar existencia en Vehieliminacions
            $placaE = Vehieliminacion::where('placa', $request->input('placa'))->exists();
            $chasisE = Vehieliminacion::where('chasis', $request->input('chasis'))->exists();
            $motorE = Vehieliminacion::where('motor', $request->input('motor'))->exists();
            
            if ($placaE) {
                return redirect()->route('vehiculos.edit')->with('error', 'La placa ya está registrada como eliminado.');
            } elseif ($chasisE) {
                return redirect()->route('vehiculos.edit')->with('error', 'El Chasis ya está registrado como eliminado.');
            } elseif ($motorE) {
                return redirect()->route('vehiculos.edit')->with('error', 'El motor ya está registrado como eliminado.');
            }

            $vehiculo->update($request->all());// Actualizar los datos del provincia con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehiculos.index')->with('error', 'Error al actualizar el vehículo: ' . $e->getMessage());
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

            $vehiculo = Vehiculo::findOrFail($id);// Buscar el provincia por su ID
            $motivo = request('motivo');// Eliminar el provincia
    
            if (empty($motivo)) {
                throw new \Exception('El motivo de la eliminación es requerido.');
            }
    
            // Crear registro en Vehieliminacions
            Vehieliminacion::create([
                'placa' => $vehiculo->placa,
                'chasis' => $vehiculo->chasis,
                'motor' => $vehiculo->motor,
                'motivo' => $motivo,
            ]);
    
            // Eliminar el vehículo
            $vehiculo->delete();
    
            DB::commit();// Confirmar la transacción
    
            return redirect()->route('vehiculos.index')->with('success', 'Vehículo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el provincia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehiculos.index')->with('error', 'Vehículo no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehiculos.index')->with('error', 'El vehículo no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehiculos.index')->with('error', 'Error al eliminar el vehículo: ' . $e->getMessage());
        }
    }
    
    public function getMarcas($tvehiculoId)
    {
        $marcas = Marca::where('tvehiculo_id', $tvehiculoId)->pluck('nombre', 'id');

        return response()->json($marcas);
    }

    public function getModelos($marcaId)
    {
        $modelos = Modelo::where('marca_id', $marcaId)->pluck('nombre', 'id');

        return response()->json($modelos);
    }
    

}
