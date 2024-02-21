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
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:asignarvehiculos.index')->only('index');
        $this->middleware('can:asignarvehiculos.create')->only('create', 'store');
        $this->middleware('can:asignarvehiculos.edit')->only('edit', 'update');
        $this->middleware('can:asignarvehiculos.show')->only('show');
        $this->middleware('can:asignarvehiculos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $asignarvehiculos = Asignarvehiculo::with('user')->paginate(10);// Se obtienen las asignaciones de vehículos paginadas, junto con la información de usuario asociada
        
        $d_vehiculo = Vehisubcircuito::paginate(10);// Se obtienen los vehículos paginados       
        
        $d_user = Usersubcircuito::whereHas('subcircuito')->get();// Se obtienen los usuarios que pertenecen a un subcircuito
        
        $subcircuitos = Vehisubcircuito::pluck('subcircuito_id', 'id');// Se obtiene información de subcircuito para cada vehículo
    
        // Se devuelve la vista con las asignaciones de vehículos, vehículos, usuarios y subcircuitos
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
        // Validación de los datos de la solicitud
        $validator = Validator::make($request->all(), [
            'vehisubcircuito_id' => 'required|exists:vehisubcircuitos,id',
            'usuarios' => 'required|array|max:4',
            'usuarios.*' => 'exists:usersubcircuitos,id',
        ]);
    
        // Si la validación falla, se redirecciona con errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        
        DB::beginTransaction();// Inicio de una transacción de base de datos

    
        try {
            //Recuperar el vehículo y usuarios seleccionados
            $vehiculo = Vehisubcircuito::findOrFail($request->input('vehisubcircuito_id'));
            $usuariosIds = $request->input('usuarios');

            // Verificar que los usuarios pertenezcan al mismo subcircuito que el vehículo
            $subcircuitoId = $vehiculo->subcircuito_id;
            $usuariosSubcircuito = Usersubcircuito::whereIn('id', $usuariosIds)->where('subcircuito_id', $subcircuitoId)->get();

            if ($usuariosSubcircuito->count() < count($usuariosIds)) {
                return redirect()->route('asignarvehiculos.index')
                    ->with('error', 'Uno o más usuarios no pertenecen al mismo subcircuito que el vehículo');
            }

            //Verificar si los usuarios ya están asignados a otro vehículo
            $usuariosAsignados = Asignarvehiculo::whereIn('user_id', $usuariosIds)
            ->where('vehisubcircuito_id', '<>', $vehiculo->id)
            ->whereHas('vehisubcircuito', function ($query) use ($subcircuitoId) {
                $query->where('subcircuito_id', $subcircuitoId);
            })
            ->get();
    
            if ($usuariosAsignados->isNotEmpty()) {
                return redirect()->route('asignarvehiculos.index')
                    ->with('error', 'Uno o más usuarios ya están asignados a otro vehículo del mismo subcircuito');
            }
    
            //Verificar límite de asignación
            $asignacionesExistentes = $vehiculo->asignar()->count();
            $usuariosNuevos = count($usuariosIds);
    
            if ($asignacionesExistentes + $usuariosNuevos > 4) {
                return redirect()->route('asignarvehiculos.index')
                    ->with('error', 'No se pueden asignar más de cuatro usuarios');
            }
    
            //Asignar usuarios al vehículo
            foreach ($usuariosIds as $usuarioId) {
                // Verificar si el usuario aún existe en la tabla usersubcircuito
                if (Usersubcircuito::where('id', $usuarioId)->exists()) {
                    $asignacion = new Asignarvehiculo();
                    $asignacion->vehisubcircuito_id = $vehiculo->id;
                    $asignacion->user_id = Usersubcircuito::findOrFail($usuarioId)->user_id; // Obtener el ID del usuario correspondiente
                    $asignacion->save();
                } else {
                    // Si el usuario ya no existe en la tabla lo elimina de la asignación
                    Asignarvehiculo::where('user_id', $usuarioId)->delete();
                }
            }
            
            DB::commit();// Confirmar la transacción de base de datos 
            
            return back()->with('success', 'Asignación exitosa');//Redirigir con éxito

        } catch (ModelNotFoundException $e) {
            // Manejar la excepción si el vehículo no existe
            DB::rollBack();
            return redirect()->route('asignarvehiculos.index')->with('error', 'Error: El vehículo no existe');

        } catch (\Exception $e) {
            // Manejar cualquier otra excepción
            DB::rollBack();
            return redirect()->route('asignarvehiculos.index')->with('error', 'Error al procesar la asignación');
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
        // Validación de los datos de la solicitud
        $request->validate([
            'usuarios' => 'required|array',
            'usuarios.*' => 'exists:asignarvehiculos,user_id,vehisubcircuito_id,' . $id,
        ]);
    
        try {
            
            DB::beginTransaction();// Iniciar una transacción de base de datos
            
            $vehiculo = Vehisubcircuito::findOrFail($id);// Obtener el modelo del vehículo
    
            // Desasignar usuarios del vehículo eliminando las asignaciones existentes
            $usuariosIds = $request->input('usuarios');
            $vehiculo->asignar()->whereIn('user_id', $usuariosIds)->delete();
            
            DB::commit();// Confirmar la transacción
    
            return back()->with('success', 'Desasignación exitosa');// Redirigir con éxito

        } catch (ModelNotFoundException $e) {
            // Manejar la excepción específica para el caso en que el vehículo no existe
            DB::rollBack();
            return redirect()->route('asignarvehiculos.index')->with('error', 'Error: El vehículo no existe');

        } catch (\Exception $e) {
            // Manejar cualquier otra excepción
            DB::rollBack();
            return redirect()->route('asignarvehiculos.index')->with('error', 'Error al procesar la desasignación');
        }
    }

    public static function eliminarAsignacion($userId)
    {
        try {
            // Eliminar las asignaciones del usuario
            Asignarvehiculo::where('user_id', $userId)->delete();
        } catch (\Exception $e) {
        }
    }
    
}
