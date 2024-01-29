<?php

namespace App\Http\Controllers;

use App\Models\Asignarvehiculo;
use App\Models\Mantenimiento;
use App\Models\Mantestado;
use App\Models\Subcircuito;
use App\Models\Vehiculo;
use App\Models\Vehisubcircuito;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class MantenimientoController
 * @package App\Http\Controllers
 */
class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener el ID del usuario autenticado
        $user_id = Auth::id();
        $mantenimientos = Mantenimiento::where('user_id', $user_id)->paginate(10);
        $subcircuito = Vehisubcircuito::all();
    
        return view('mantenimiento.index', compact('mantenimientos', 'subcircuito'))
            ->with('i', (request()->input('page', 1) - 1) * $mantenimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtener información del usuario logeado
        $user = auth()->user();
        $d_vehiculo = Asignarvehiculo::where('user_id', $user->id)->first();

        $mantenimiento = new Mantenimiento();
        $d_mantestado = Mantestado::all();
        $edicion = false;


        return view('mantenimiento.create', compact('mantenimiento', 'd_mantestado', 'user', 'd_vehiculo', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = $this->getInfo($request);
    
        request()->validate(Mantenimiento::$rules);
    
        $estado = $request->input('mantestado_id');
    
        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['mantestado_id' => '1']);
        }
    
        $mantenimiento = Mantenimiento::create($request->all());
    
        return redirect()->route('mantenimientos.show', ['mantenimiento' => $mantenimiento->id])
            ->with('success', 'Mantenimiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mantenimiento = Mantenimiento::find($id);

        return view('mantenimiento.show', compact('mantenimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $d_mantestado = Mantestado::all();
        $user = auth()->user();
        $d_vehiculo = Asignarvehiculo::where('user_id', $user->id)->first();

        $d_mantestado = Mantestado::all();
        $edicion = true;

        return view('mantenimiento.edit', compact('mantenimiento', 'edicion', 'd_mantestado', 'user', 'd_vehiculo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantenimiento $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $request = $this->getInfo($request);
    
        request()->validate(Mantenimiento::$rules);
    
        $mantenimiento->update($request->all());
    
        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            $mantenimiento = Mantenimiento::find($id);
            $mantenimiento->delete();
    
            return redirect()->route('mantenimientos.index')
                ->with('success', 'Mantenimiento borrado exitosamente.');
        } catch (QueryException $e) {
            // Captura la excepción de integridad referencial (foreign key constraint)
            return redirect()->route('mantenimientos.index')
                ->with('error', 'Error no se puede eliminar, se encuentra en proceso de mantenimiento');
        }
    }


    private function getInfo(Request $request)
    {
        // Obtener el ID del usuario autenticado
        $user_id = Auth::id();
        $request->merge(['user_id' => $user_id]);
    
        // Obtener el ID del vehículo desde la relación
        $placa = $request->input('vehiculo_id');
        $vehiculo_id = Vehiculo::where('placa', $placa)->value('id');
        $request->merge(['vehiculo_id' => $vehiculo_id]);
    
        return $request;
    }
}
