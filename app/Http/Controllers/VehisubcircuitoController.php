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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class VehisubcircuitoController
 * @package App\Http\Controllers
 */
class VehisubcircuitoController extends Controller
{
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
        // Obtener todos los usuarios
        $d_vehiculo = Vehiculo::whereNotIn('id', Vehisubcircuito::where('asignacion_id', 1)->pluck('vehiculo_id')->toArray())
        ->whereNotIn('id', Vehisubcircuito::where('asignacion_id', 2)->pluck('vehiculo_id')->toArray())
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //request()->validate(Vehisubcircuito::$rules);

        $vehiculoId = $request->input('vehiculo_id');
        $VehiculoEx = Vehisubcircuito::where('vehiculo_id', $vehiculoId)->first();

        if ($VehiculoEx) {
            return redirect()->route('vehisubcircuitos.create')
                ->with('error', 'Ya existe un registro para esta Placa.');
        }

        // Si no hay un registro existente, procede con la creación del nuevo registro
        request()->validate(Vehisubcircuito::$rules);


        $estado = $request->input('asignacion_id');

        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['asignacion_id' => '1']);
        }
        
        $vehisubcircuito = Vehisubcircuito::create($request->all());

        return redirect()->route('vehisubcircuitos.index')
            ->with('success', 'Vehículo Subcircuito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehisubcircuito = Vehisubcircuito::find($id);

        return view('vehisubcircuito.show', compact('vehisubcircuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehisubcircuito = Vehisubcircuito::find($id);
        $d_vehiculo = Vehiculo::all();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $d_subcircuito = Subcircuito::all();
        $d_asignacion = Asignacion::all();

        $edicion = true;
        $edicion2 = false;
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
        // Reglas de validación
        $rules = [
            'vehiculo_id' => 'required',
            'provincia_id' => 'required',
            'canton_id' => 'required',
            'parroquia_id' => 'required',
            'distrito_id' => 'required',
            'circuito_id' => 'required',
            'subcircuito_id' => 'required',
            'asignacion_id' => 'required',
        ];

        // Validar los datos de la solicitud
        $validatedData = $request->validate($rules);

        // Verificar si la asignación es igual a 2 (No Asignado)
        if ($request->input('asignacion_id') == 2) {
            // Actualizar los campos a "No Asignado" sin borrar el registro
            $vehisubcircuito->update([
                'provincia_id' => null,
                'canton_id' => null,
                'parroquia_id' => null,
                'distrito_id' => null,
                'circuito_id' => null,
                'subcircuito_id' => null,
                'asignacion_id' => 2,

            ]);

            return redirect()->route('vehisubcircuitos.index')->with('success', 'Registro actualizado a "No Asignado".');
        }

        // Actualizar el Usersubcircuito con los nuevos datos
        $vehisubcircuito->update($validatedData);

        return redirect()->route('vehisubcircuitos.index')
            ->with('success', 'Vehículo Subcircuito actualizado exitosamente.');
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
                ->with('success', 'Vehículo Subcircuito borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción si no se encuentra el registro
            return redirect()->route('vehisubcircuitos.index')
                ->with('error', 'Vehículo Subcircuito no encontrado.');
        } catch (\Exception $e) {
            // Manejar otras excepciones
            return redirect()->route('vehisubcircuitos.index')
                ->with('error', 'Error al borrar Vehículo Subcircuito.');
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
