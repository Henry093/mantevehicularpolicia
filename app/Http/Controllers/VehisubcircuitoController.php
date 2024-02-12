<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use App\Models\Vehiculo;
use App\Models\Vehisubcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class VehisubcircuitoController
 * @package App\Http\Controllers
 */
class VehisubcircuitoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vehisubcircuitos.index')->only('index');
        $this->middleware('can:vehisubcircuitos.create')->only('create', 'store');
        $this->middleware('can:vehisubcircuitos.edit')->only('edit', 'update');
        $this->middleware('can:vehisubcircuitos.show')->only('show');
        $this->middleware('can:vehisubcircuitos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehisubcircuitos = Vehisubcircuito::paginate(10);

        return view('vehisubcircuito.index', compact('vehisubcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $vehisubcircuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            // Obtener todos los usuarios
            $d_vehiculo = Vehiculo::whereNotIn('id', Vehisubcircuito::where('asignacion_id', 1)->pluck('vehiculo_id')->toArray())
                ->whereNotIn('id', Vehisubcircuito::where('asignacion_id', 2)->pluck('vehiculo_id')->toArray())
                ->whereNotIn('estado_id', [2, 3])
                ->get();
    
            $vehisubcircuito = new Vehisubcircuito();
            $d_provincia = Provincia::all();
            $d_canton = Canton::all();
            $d_parroquia = Parroquia::all();
            $d_distrito = Distrito::all();
            $d_circuito = Circuito::all();
            $d_subcircuito = Subcircuito::all();
    
            $edicion = false;
            $edicion2 = true;
    
            return view('vehisubcircuito.create', compact(
                'vehisubcircuito', 
                'd_vehiculo', 
                'd_provincia', 
                'd_canton', 
                'd_parroquia', 
                'd_distrito', 
                'd_circuito', 
                'd_subcircuito', 
                'edicion',
                'edicion2'
            ));
        } catch (\Exception $e) {
            // Manejar la excepción general
            return redirect()->route('error')->with('error', 'Hubo un error al cargar la página de creación: ' . $e->getMessage());
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción específica del modelo
            return redirect()->route('error')->with('error', 'Hubo un error al cargar la página de creación: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los datos de entrada según las reglas definidas en el modelo
        $validator = Validator::make($request->all(), Vehisubcircuito::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
    
            DB::beginTransaction();
    
            $vehiculoId = $request->input('vehiculo_id');
            $vehiculoExistente = Vehisubcircuito::where('vehiculo_id', $vehiculoId)->first();
            if ($vehiculoExistente) {
                return redirect()->route('vehisubcircuitos.create')
                    ->with('error', 'Ya existe un registro para esta Placa.');
            }
    
            $estado = $request->input('asignacion_id');
            if (empty($estado)) {
                $request->merge(['asignacion_id' => '1']);
            }
    
            Vehisubcircuito::create($request->all());
    
            DB::commit();
    
            return redirect()->route('vehisubcircuitos.index')
                ->with('success', 'Vehículo asignado al Subcircuito creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehisubcircuitos.create')
                ->with('error', 'Error al crear el Vehículo asignado al Subcircuito: ' . $e->getMessage());
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
            // Intenta encontrar el Vehisubcircuito con el ID proporcionado
            $vehisubcircuito = Vehisubcircuito::findOrFail($id);
    
            // Si se encuentra, mostrar la vista de detalle del Vehisubcircuito
            return view('vehisubcircuito.show', compact('vehisubcircuito'));
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra, redirigir al usuario a alguna parte a la lista de Vehisubcircuitos
            return redirect()->route('vehisubcircuitos.index')->with('error', 'El Vehículo asignado al subcircuito no existe.');
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
            // Intenta encontrar el Vehisubcircuito con el ID proporcionado
            $vehisubcircuito = Vehisubcircuito::findOrFail($id);
    
            // Obtener datos relacionados
            $d_vehiculo = Vehiculo::all();
            $d_provincia = Provincia::all();
            $d_canton = Canton::all();
            $d_parroquia = Parroquia::all();
            $d_distrito = Distrito::all();
            $d_circuito = Circuito::all();
            $d_subcircuito = Subcircuito::all();
            $d_asignacion = Asignacion::all();
    
            // Establecer variables de edición
            $edicion = true;
            $edicion2 = false;
    
            // Pasar los datos a la vista de edición
            return view('vehisubcircuito.edit', compact(
                'vehisubcircuito',
                'd_vehiculo',
                'd_provincia',
                'd_canton',
                'd_parroquia',
                'd_distrito',
                'd_circuito',
                'd_subcircuito',
                'd_asignacion',
                'edicion',
                'edicion2'
            ));
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el Vehisubcircuito, redirigir al usuario a la lista de Vehisubcircuitos
            return redirect()->route('vehisubcircuitos.index')->with('error', 'El Vehículo asignado al subcircuito no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehisubcircuito $vehisubcircuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehisubcircuito $vehisubcircuito)
    {
        // Validación de los datos de entrada según las reglas definidas en el modelo
        $validator = Validator::make($request->all(), Vehisubcircuito::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            // Reglas de validación
            $rules = [
                'vehiculo_id' => 'required',
                'asignacion_id' => ['required', Rule::in([1, 2])],
            ];
    
            // Validar los datos de la solicitud
            $validatedData = $request->validate($rules);
    
            DB::beginTransaction();
    
            // Verificar si la asignación es igual a 2 (No Asignado)
            if ($validatedData['asignacion_id'] == 2) {
                // Eliminar el registro de la base de datos
                $vehisubcircuito->delete();
    
                DB::commit();
    
                return redirect()->route('vehisubcircuitos.index')->with('success', 'Registro eliminado exitosamente.');
            } elseif ($validatedData['asignacion_id'] == 1) {
                // Actualizar los campos a "Asignado" sin borrar el registro
                $asignadoData = [
                    'provincia_id' => $request->input('provincia_id'),
                    'canton_id' => $request->input('canton_id'),
                    'parroquia_id' => $request->input('parroquia_id'),
                    'distrito_id' => $request->input('distrito_id'),
                    'circuito_id' => $request->input('circuito_id'),
                    'subcircuito_id' => $request->input('subcircuito_id'),
                    'asignacion_id' => 1,
                ];
    
                $vehisubcircuito->update($asignadoData);
    
                DB::commit();
    
                return redirect()->route('vehisubcircuitos.index')->with('success', 'Registro actualizado a "Asignado".');
            }
    
            // Asegurarse de que se proporcionen valores válidos para los campos de ubicación
            $request->validate([
                'provincia_id' => 'required',
                'canton_id' => 'required',
                'parroquia_id' => 'required',
                'distrito_id' => 'required',
                'circuito_id' => 'required',
                'subcircuito_id' => 'required',
            ]);
    
            // Actualizar el Vehisubcircuito con los nuevos datos
            $vehisubcircuito->update($validatedData);
    
            DB::commit();
    
            return redirect()->route('vehisubcircuitos.index')
                ->with('success', 'Vehículo asignado al subcircuito actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehisubcircuitos.index')->with('error', 'Error al actualizar el vehículo asignado al subcircuito: ' . $e->getMessage());
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
            // Buscar el vehisubcircuito
            $vehisubcircuito = Vehisubcircuito::findOrFail($id);
    
            // Eliminar las referencias en asignarvehiculos
            $vehisubcircuito->asignarvehiculos()->delete();
    
            // Eliminar el vehisubcircuito
            $vehisubcircuito->delete();
    
            return redirect()->route('vehisubcircuitos.index')
                ->with('success', 'Vehículo asignado al Subcircuito borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción si no se encuentra el registro
            return redirect()->route('vehisubcircuitos.index')
                ->with('error', 'Vehículo asignado al Subcircuito no encontrado.');        
        } catch (QueryException $e) {
            // Capturar si hay un error de consulta (por ejemplo, restricciones de clave externa) y redirigir al usuario con un mensaje de error
            return redirect()->route('vehisubcircuitos.index')
                ->with('error', 'Error al eliminar el Vehículo asignado al subcircuito, Hay datos asociados.');
        } catch (\Exception $e) {
            // Manejar otras excepciones
            return redirect()->route('vehisubcircuitos.index')
                ->with('error', 'Error al borrar el Vehículo asignado al Subcircuito.');
        }
    }

    public function getCantonesvs($provinciaId)
    {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getParroquiasvs($cantonId)
    {
        try {
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getDistritosvs($parroquiaId)
    {
        try {
            $distritos = Distrito::where('parroquia_id', $parroquiaId)->pluck('nombre', 'id')->toArray();
            return response()->json($distritos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Distritos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getCircuitosvs($distritoId)
    {
        try {
            $circuitos = Circuito::where('distrito_id', $distritoId)->pluck('nombre', 'id')->toArray();
            return response()->json($circuitos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Circuitos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    public function getSubcircuitosvs($circuitoId)
    {
        try {
            $subcircuitos = Subcircuito::where('circuito_id', $circuitoId)->pluck('nombre', 'id')->toArray();
            return response()->json($subcircuitos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'SubCircuitos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getInformacionVehiculo($id)
    {
        try {
            $vehiculo = Vehiculo::findOrFail($id);
            return response()->json([
                'tvehiculo' => $vehiculo->tvehiculo->nombre,
                'placa' => $vehiculo->placa,
                'marca' => $vehiculo->marca->nombre,
                'modelo' => $vehiculo->modelo->nombre,
                'vcarga' => $vehiculo->vcarga->nombre,
                'vpasajero' => $vehiculo->vpasajero->nombre,  
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
}
