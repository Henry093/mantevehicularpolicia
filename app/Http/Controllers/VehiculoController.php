<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tvehiculo;
use App\Models\Vcarga;
use App\Models\Vehiculo;
use App\Models\Vpasajero;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * Class VehiculoController
 * @package App\Http\Controllers
 */
class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = Vehiculo::paginate(10);

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
        $vehiculo = new Vehiculo();
        $d_vehiculo = Tvehiculo::all();
        $d_marca = Marca::all();
        $d_modelo = Modelo::all();
        $d_carga = Vcarga::all();
        $d_pasajero = Vpasajero::all();
        $d_estado = Estado::all();

        $edicion = false;

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
        request()->validate(Vehiculo::$rules);

        $placa = Vehiculo::where('placa', $request->input('placa'))->first();
        $chasis = Vehiculo::where('chasis', $request->input('chasis'))->first();
        $motor = Vehiculo::where('motor', $request->input('motor'))->first();

        if($placa){
            return redirect()->route('vehiculos.create')->with('error', 'La placa ya está registrada.');
        }elseif($chasis){
            return redirect()->route('vehiculos.create')->with('error', 'El Chasis ya está registrado.');
        }elseif($motor){
            return redirect()->route('vehiculos.create')->with('error', 'El motor ya está registrado.');
        }

        // Verificar si el estado ya está presente en la solicitud
        $estado = $request->input('estado_id');

        if (empty($estado)) {
            // Si no se proporciona una estado, en este caso 1 = Activo
            $request->merge(['estado_id' => '1']);
        }

        $vehiculo = Vehiculo::create($request->all());

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehiculo = Vehiculo::find($id);

        return view('vehiculo.show', compact('vehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehiculo = Vehiculo::find($id);
        $d_vehiculo = Tvehiculo::all();
        $d_marca = Marca::all();
        $d_modelo = Modelo::all();
        $d_carga = Vcarga::all();
        $d_pasajero = Vpasajero::all();
        $d_estado = Estado::all();

        $edicion = true;

        return view('vehiculo.edit', compact('vehiculo', 'd_vehiculo', 'd_marca', 'd_modelo', 'd_carga', 'd_pasajero', 'd_estado', 'edicion'));
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
        
        request()->validate($rules);

        $vehiculo->update($request->all());

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehículo actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehiculo = Vehiculo::find($id);

        if (!$vehiculo) {
            return redirect()->route('vehiculos.index')
                ->with('error', 'Vehículo no existe.');
        }

        try {
            // Verificar si el vehículo está asignado a algún subcircuito
            if ($vehiculo->vsubcircuitos()->exists()) {
                return redirect()->route('vehiculos.index')
                    ->with('error', 'No se puede eliminar. El vehículo está asignada a un Subcircuito.');
            }

            $vehiculo->delete();

            return redirect()->route('vehiculos.index')
                ->with('success', 'Vehículo borrado exitosamente.');

        } catch (QueryException $e) {
            // Captura cualquier otro error de la base de datos que pueda ocurrir durante la eliminación
            return redirect()->route('vehiculos.index')
                ->with('error', 'Hubo un problema al intentar eliminar el vehíiculo.');
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
