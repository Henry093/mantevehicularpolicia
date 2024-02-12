<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tvehiculo;
use App\Models\Vcarga;
use App\Models\Vehiculo;
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
        $search = request('search');
        $query = Vehiculo::query();
    
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
        $vehiculos = $query->paginate(12);

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
        $validator = Validator::make($request->all(), Vehiculo::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            //Se crea el vehículo en la base de datos
            $placa = Vehiculo::where('placa', $request->input('placa'))->first();
            $chasis = Vehiculo::where('chasis', $request->input('chasis'))->first();
            $motor = Vehiculo::where('motor', $request->input('motor'))->first();
            
            if ($placa) {
                return redirect()->route('vehiculos.create')->with('error', 'La placa ya está registrada.');
            } elseif ($chasis) {
                return redirect()->route('vehiculos.create')->with('error', 'El Chasis ya está registrado.');
            } elseif ($motor) {
                return redirect()->route('vehiculos.create')->with('error', 'El motor ya está registrado.');
            }
    
            // Verificar si el estado ya está presente en la solicitud
            $estado = $request->input('estado_id');
    
            if (empty($estado)) {
                // Si no se proporciona un estado, en este caso 1 = Activo
                $request->merge(['estado_id' => '1']);
            }
    
            DB::beginTransaction();
    
            Vehiculo::create($request->all());
    
            DB::commit();
    
            return redirect()->route('vehiculos.index')->with('success', 'Vehículo creado exitosamente.');
        } catch (\Exception $e) {
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
            $vehiculo = Vehiculo::findOrFail($id);
            return view('vehiculo.show', compact('vehiculo'));
        } catch (ModelNotFoundException $e) {
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
            $vehiculo = Vehiculo::findOrFail($id);
            $d_vehiculo = Tvehiculo::all();
            $d_marca = Marca::all();
            $d_modelo = Modelo::all();
            $d_carga = Vcarga::all();
            $d_pasajero = Vpasajero::all();
            $d_estado = Estado::all();
    
            $edicion = true;
    
            return view('vehiculo.edit', compact('vehiculo', 'd_vehiculo', 'd_marca', 'd_modelo', 'd_carga', 'd_pasajero', 'd_estado', 'edicion'));
        } catch (ModelNotFoundException $e) {
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
        
        $validator = Validator::make($request->all(), $rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $placa = Vehiculo::where('placa', $request->input('placa'))->where('id', '!=', $vehiculo->id)->first();
            $chasis = Vehiculo::where('chasis', $request->input('chasis'))->where('id', '!=', $vehiculo->id)->first();
            $motor = Vehiculo::where('motor', $request->input('motor'))->where('id', '!=', $vehiculo->id)->first();
    
            if ($placa) {
                return redirect()->route('vehiculos.edit', $vehiculo)->with('error', 'La placa ya está registrada.');
            } elseif ($chasis) {
                return redirect()->route('vehiculos.edit', $vehiculo)->with('error', 'El chasis ya está registrado.');
            } elseif ($motor) {
                return redirect()->route('vehiculos.edit', $vehiculo)->with('error', 'El motor ya está registrado.');
            }
    
            $vehiculo->update($request->all());
    
            DB::commit();
    
            return redirect()->route('vehiculos.index')->with('success', 'Vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
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
            DB::beginTransaction();
    
            $vehiculo = Vehiculo::findOrFail($id);
            $vehiculo->delete();
    
            DB::commit();
    
            return redirect()->route('vehiculos.index')->with('success', 'Vehículo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('vehiculos.index')->with('error', 'Vehículo no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('vehiculos.index')->with('error', 'El vehículo no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
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
