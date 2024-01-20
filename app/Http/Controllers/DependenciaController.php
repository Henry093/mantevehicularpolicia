<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Dependencia;
use App\Models\Distrito;
use App\Models\Estado;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * Class DependenciaController
 * @package App\Http\Controllers
 */
class DependenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dependencias = Dependencia::paginate(10);

        return view('dependencia.index', compact('dependencias'))
            ->with('i', (request()->input('page', 1) - 1) * $dependencias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dependencia = new Dependencia();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $d_subcircuito = Subcircuito::all();
        $d_estado = Estado::all();

        return view('dependencia.create', compact('dependencia', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'd_circuito', 'd_subcircuito', 'd_estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Dependencia::$rules);

        $dependencia = Dependencia::create($request->all());

        return redirect()->route('dependencias.index')
            ->with('success', 'Dependencia created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dependencia = Dependencia::find($id);

        return view('dependencia.show', compact('dependencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dependencia = Dependencia::find($id);
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $d_subcircuito = Subcircuito::all();
        $d_estado = Estado::all();

        return view('dependencia.edit', compact('dependencia', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'd_circuito', 'd_subcircuito', 'd_estado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Dependencia $dependencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dependencia $dependencia)
    {
        request()->validate(Dependencia::$rules);

        $dependencia->update($request->all());

        return redirect()->route('dependencias.index')
            ->with('success', 'Dependencia updated successfully');
           
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dependencia = Dependencia::find($id);

        return redirect()->route('dependencias.index')
            ->with('success', 'Dependencia deleted successfully');
        
        if (!$dependencia) {
            return redirect()->route('dependencias.index')
                ->with('error', 'Dependencia no existe.');
        }
    
        try {
            // Verificar si hay personas o vehículos asignados a la dependencia
             if ($dependencia->users()->exists()) {
                return redirect()->route('dependencias.index')
                    ->with('error', 'No se puede eliminar. Hay Usuarios asignados a la Dependencia.');
            }elseif ($dependencia->vehiculos()->exists()) {
                return redirect()->route('dependencias.index')
                    ->with('error', 'No se puede eliminar. Hay vehículos asignados a la Dependencia.');
            }
    
            $dependencia->delete();
    
            return redirect()->route('dependencias.index')
                ->with('success', 'Dependencia borrada exitosamente.');
        } catch (QueryException $e) {
            // Capturar cualquier otro error de la base de datos que pueda ocurrir durante la eliminación
            return redirect()->route('dependencias.index')
                ->with('error', 'Hubo un problema al intentar eliminar la dependencia.');
        } 
    }

    public function getCantones($provinciaId) {
        $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
        return response()->json($cantones);
    }

    public function getParroquias($cantonId) {
        $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
        return response()->json($parroquias);
    }

    public function getDistritos($cantonId) {
        $distritos = Distrito::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
        return response()->json($distritos);
    }
    
    public function getCircuitos($distritoId) {
        $circuitos = Circuito::where('distrito_id', $distritoId)->pluck('nombre', 'id')->toArray();
        return response()->json($circuitos);
    }
    
    public function getSubcircuitos($circuitoId) {
        $subcircuitos = Subcircuito::where('circuito_id', $circuitoId)->pluck('nombre', 'id')->toArray();
        return response()->json($subcircuitos);
    }

}
