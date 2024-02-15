<?php

namespace App\Http\Controllers;

use App\Models\Asignarvehiculo;
use App\Models\Mantenimiento;
use App\Models\Mantestado;
use App\Models\Subcircuito;
use App\Models\Vehiculo;
use App\Models\Vehisubcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
/**
 * Class MantenimientoController
 * @package App\Http\Controllers
 */
class MantenimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantenimientos.index')->only('index');
        $this->middleware('can:mantenimientos.create')->only('create', 'store');
        $this->middleware('can:mantenimientos.edit')->only('edit', 'update');
        $this->middleware('can:mantenimientos.show')->only('show');
        $this->middleware('can:mantenimientos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Obtener el término de búsqueda de la solicitud HTTP
    
        // Obtener el ID del usuario autenticado
        $user_id = Auth::id();
    
        // Iniciar la consulta para el modelo Mantenimiento
        $query = Mantenimiento::where('user_id', $user_id);
    
        // Aplicar la búsqueda si hay un término de búsqueda
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('fecha', 'like', '%' . $search . '%')
                    ->orWhere('hora', 'like', '%' . $search . '%')
                    ->orWhere('kilometraje', 'like', '%' . $search . '%')
                    ->orWhere('observaciones', 'like', '%' . $search . '%')
                    ->orWhere('orden', 'like', '%' . $search . '%')
                    ->orWhereHas('mantestado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                });
            });
        }
    
        // Paginar los resultados de la consulta
        $mantenimientos = $query->paginate(10);
    
        // Obtener los datos necesarios para la vista
        $subcircuito = Vehisubcircuito::all();
    
        // Pasar los resultados paginados y otros datos a la vista
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
    
        $validator = Validator::make($request->all(), Mantenimiento::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $request = $this->getInfo($request);
        
        $estado = $request->input('mantestado_id');
    
        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['mantestado_id' => '1']);
        }
    
        try {
            DB::beginTransaction();
    
            // Obtener el último valor del campo "orden" de la tabla "mantenimientos"
            $ultimaOrden = Mantenimiento::latest('orden')->value('orden');
    
            // Incrementar el último valor del campo "orden" en 1
            $nuevaOrden = $ultimaOrden + 1;
    
            // Asignar el nuevo valor al atributo "orden" del objeto $request
            $request->merge(['orden' => $nuevaOrden]);
    
            $mantenimiento = Mantenimiento::create($request->all());
    
            DB::commit();
    
            return redirect()->route('mantenimientos.show', ['mantenimiento' => $mantenimiento->id])
                ->with('success', 'Orden de mantenimiento creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error al crear la orden de mantenimiento: ' . $e->getMessage());
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
            $mantenimiento = Mantenimiento::findOrFail($id);
            return view('mantenimiento.show', compact('mantenimiento'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mantenimientos.index')->with('error', 'La orden de mantenimiento no existe.');
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
            $mantenimiento = Mantenimiento::findOrFail($id);
            
            // Verificar si el estado del mantenimiento es 1 (Nuevo)
            if ($mantenimiento->mantestado_id != 1) {
                return redirect()->route('mantenimientos.index')->with('error', 'No puedes editar esta orden de mantenimiento porque esta en estado "' . $mantenimiento->mantestado->nombre . '".');
            }
    
            $d_mantestado = Mantestado::all();
            $user = auth()->user();
            $d_vehiculo = Asignarvehiculo::where('user_id', $user->id)->first();
    
            $edicion = true;
    
            return view('mantenimiento.edit', compact('mantenimiento', 'edicion', 'd_mantestado', 'user', 'd_vehiculo'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mantenimientos.index')->with('error', 'La orden de mantenimiento no existe.');
        }
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
        $validator = Validator::make($request->all(), Mantenimiento::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $request = $this->getInfo($request);

        // Validar si el nuevo estado seleccionado es 2, 3, 4 o 5
        if (in_array($request->input('mantestado_id'), [2, 3, 4, 5])) {
            return back()->with('error', 'No puedes cambiar el estado de esta orden de mantenimiento.');
        }

        try {
            DB::beginTransaction();

            $mantenimiento->update($request->all());

            DB::commit();

            return redirect()->route('mantenimientos.index')
                ->with('success', 'Orden de mantenimiento actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error al actualizar la orden de mantenimiento: ' . $e->getMessage());
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
        
            $mantenimiento = Mantenimiento::findOrFail($id);
    
            // Verificar si el mantestado es igual a 2, 3
            if (in_array($mantenimiento->mantestado_id, [2, 3])) {
                return redirect()->route('mantenimientos.index')->with('error', 'No se puede eliminar la orden de mantenimiento porque esta "' . $mantenimiento->mantestado->nombre . '".');
            }

            $mantenimiento->delete();
        
            DB::commit();
        
            return redirect()->route('mantenimientos.index')->with('success', 'Orden de Mantenimiento borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Orden de mantenimiento no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error: No se puede eliminar, la orden de mantenimiento se encuentra "' . $mantenimiento->mantestado->nombre . '".');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error al eliminar la orden de mantenimiento: ' . $e->getMessage());
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

        /**
     * Cambiar el estado del mantenimiento a "Aceptar".
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function aceptar($id)
    {
        try {
            DB::beginTransaction();
            $mantenimiento = Mantenimiento::findOrFail($id);
    
            // Verificar si el mantestado actual es 3, 4 o 5
            if ($mantenimiento->mantestado_id == 3 || $mantenimiento->mantestado_id == 4 || $mantenimiento->mantestado_id == 5) {
                return redirect()->route('mantenimientos.index')->with('error', 'No se puede aceptar la orden de mantenimiento porque está "' . $mantenimiento->mantestado->nombre . '".');
            }
            // Verificar si el mantestado actual es 2 (Aceptado)
            if ($mantenimiento->mantestado_id == 2) {
                return redirect()->route('mantenimientos.index')->with('error', 'La orden de mantenimiento ya ha sido "' . $mantenimiento->mantestado->nombre . '".');
            }
            //Actualiza a Aceptado
            $mantenimiento->update(['mantestado_id' => 2]);

            DB::commit();
            return redirect()->route('mantenimientos.index')->with('success', 'Orden de mantenimiento aceptada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error al aceptar la orden de mantenimiento.');
        }
    }

        /**
     * Mostrar el modal de reasignación.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function reasignar(Request $request)
    {
        try {
            $id = $request->input('id');
            $fecha = $request->input('fecha');
            $hora = $request->input('hora');

            DB::beginTransaction();

            $mantenimiento = Mantenimiento::findOrFail($id);

            // Verificar si el mantestado actual es 4 o 5
            if ($mantenimiento->mantestado_id == 4 || $mantenimiento->mantestado_id == 5) {
                return redirect()->route('mantenimientos.index')->with('error', 'No se puede reasignar la orden de mantenimiento porque está "' . $mantenimiento->mantestado->nombre . '".');
            }

            $mantenimiento->update(['fecha' => $fecha, 'hora' => $hora, 'mantestado_id' => 3]);

            DB::commit();

            return redirect()->route('mantenimientos.index')->with('success', 'Orden de mantenimiento reasignado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error al reasignar la orden de mantenimiento.');
        }
    }


    public function pdf($id){
        try {
            $mantenimiento = Mantenimiento::findOrFail($id);
            
            $pdf = PDF::loadView('mantenimiento.pdf', compact('mantenimiento'));
        
            return $pdf->stream();
        } catch (\Exception $e) {
            // Manejar la excepción aquí, por ejemplo, redirigir a una página de error o mostrar un mensaje al usuario
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }
}
