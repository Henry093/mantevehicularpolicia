<?php

namespace App\Http\Controllers;

use App\Models\Asignarvehiculo;
use App\Models\Usersubcircuito;
use App\Models\Vehisubcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class AsignarvehiculoController
 * @package App\Http\Controllers
 */
class AsignarvehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asignarvehiculos = Asignarvehiculo::with('user')->paginate(10);
        $d_vehiculo = Vehisubcircuito::paginate(10);
        $d_user = Usersubcircuito::whereHas('subcircuito')->whereDoesntHave('asignar')->get();

        // Obtener información de subcircuito para cada vehículo
        $subcircuitos = Vehisubcircuito::pluck('subcircuito_id', 'id');

        return view('asignarvehiculo.index', compact('asignarvehiculos', 'd_vehiculo', 'd_user', 'subcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $asignarvehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehisubcircuito_id' => 'required|exists:vehisubcircuitos,id',
            'usuarios' => 'required|array|max:4',
            'usuarios.*' => 'exists:usersubcircuitos,id',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }


        DB::beginTransaction();

    
        try {
            // Paso 1: Recuperar el vehículo y usuarios seleccionados
            $vehiculo = Vehisubcircuito::findOrFail($request->input('vehisubcircuito_id'));
            $usuariosIds = $request->input('usuarios');
    
            // Paso 2: Verificar si los usuarios ya están asignados a otro vehículo
            $usuariosAsignados = Asignarvehiculo::whereIn('user_id', $usuariosIds)->get();
    
            foreach ($usuariosAsignados as $asignacion) {
                if ($asignacion->vehisubcircuito_id != $vehiculo->id) {
                    return redirect()->route('asignarvehiculos.index')
                        ->with('error', 'Uno o más usuarios ya están asignados a otro vehículo');
                }
            }
    
            // Paso 3: Verificar límite de asignación
            $asignacionesExistentes = $vehiculo->asignar()->count();
            $usuariosNuevos = count($usuariosIds);
    
            if ($asignacionesExistentes + $usuariosNuevos > 4) {
                return redirect()->route('asignarvehiculos.index')
                    ->with('error', 'No se pueden asignar más de cuatro usuarios');
            }
    
            // Paso 4: Asignar usuarios al vehículo
            foreach ($usuariosIds as $usuarioId) {
                $asignacion = new Asignarvehiculo();
                $asignacion->vehisubcircuito_id = $vehiculo->id;
                $asignacion->user_id = $usuarioId; 
                $asignacion->save();
            }
    
            DB::commit();
            // Paso 5: Redirigir con éxito
            return back()->with('success', 'Asignación exitosa');

        } catch (\Exception $e) {
            // Rollback en caso de error
            DB::rollBack();

            // Redirigir con error
            return back()->with('error', 'Error al procesar la asignación');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Asignarvehiculo $asignarvehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignarvehiculo $asignarvehiculo)
    {
        //
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Request $request, $id)
    {
        $request->validate([
            'usuarios' => 'required|array',
            'usuarios.*' => 'exists:usersubcircuitos,id',
        ]);
    
        try {
            // Paso 1: Obtener el modelo del vehículo
            $vehiculo = Vehisubcircuito::findOrFail($id);
    
            // Paso 2: Desasignar usuarios del vehículo eliminando las asignaciones
            $usuariosIds = $request->input('usuarios');
            $vehiculo->asignar()->whereIn('user_id', $usuariosIds)->delete();
    
            DB::commit();
            // Paso 3: Redirigir con éxito
            return back()->with('success', 'Desasignación exitosa');
        } catch (ModelNotFoundException $e) {
            // Manejar la excepción específica para el caso en que el vehículo no existe
            return redirect()->route('asignarvehiculos.index')->with('error', 'Error: El vehículo no existe');
        } catch (\Exception $e) {
            DB::rollBack();
            // Manejar cualquier otra excepción
            return redirect()->route('asignarvehiculos.index')->with('error', 'Error al procesar la desasignación');
        }
    }

    
}
