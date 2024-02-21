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
use App\Models\User;
/**
 * Class MantenimientoController
 * @package App\Http\Controllers
 */
class MantenimientoController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
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
        $search = request('search'); // Se obtiene el término de búsqueda
    
        $user_id = Auth::id();// Obtener el ID del usuario autenticado
    
        $user_roles = User::find($user_id)->roles->pluck('id')->toArray();// Obtener los roles del usuario autenticado
        
        $query = Mantenimiento::query();// Iniciar la consulta para el modelo Mantenimiento
    
        // Si el usuario tiene roles del 1 al 4, mostrar todos los registros
        if (in_array($user_roles, [1, 2, 3, 4])) {

            // No se hace ninguna restricción adicional, se muestran todos los registros

        } elseif (in_array(5, $user_roles)) { // Si el usuario tiene el rol 5
            
            $query->where('user_id', $user_id);// Mostrar solo los registros del usuario actual

        }
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
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

        $mantenimientos = $query->paginate(10);// Se obtienen los cantones paginados
    
        $subcircuito = Vehisubcircuito::all();// Obtener los datos necesarios para la vista
    
        // Se devuelve la vista con los cantones paginados
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

        $mantenimiento = new Mantenimiento();// Se crea una nueva instancia de mantenimiento
        $d_mantestado = Mantestado::all();// Se obtienen todas las mantestado disponibles
        $edicion = false;// Indicador de edición

        // Se devuelve la vista con el formulario de creación
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
    
        $validator = Validator::make($request->all(), Mantenimiento::$rules);// Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        $request = $this->getInfo($request);// Obtener información adicional del mantenimiento
        
        $estado = $request->input('mantestado_id');// Obtener el estado del mantenimiento desde el formulario
    
        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['mantestado_id' => '1']);
        }
    
        try {
            DB::beginTransaction();// Se inicia una transacción de base de datos
    
            $ultimaOrden = Mantenimiento::latest('orden')->value('orden'); // Obtener el último valor del campo "orden" de la tabla "mantenimientos"
    
            $nuevaOrden = $ultimaOrden + 1;// Incrementar el último valor del campo "orden" en 1
    
            $request->merge(['orden' => $nuevaOrden]);// Asignar el nuevo valor al atributo "orden" del objeto $request
    
            $mantenimiento = Mantenimiento::create($request->all());// Se crea un nuevo cantón con los datos proporcionados
    
            DB::commit();// Se confirma la transacción
    
            // Se redirige a la lista de mantenimientos con un mensaje de éxito
            return redirect()->route('mantenimientos.show', ['mantenimiento' => $mantenimiento->id])
                ->with('success', 'Orden de mantenimiento creado exitosamente.');
        } catch (\Exception $e) {
             // En caso de error, se deshace la transacción y se redirige con un mensaje de error
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
            $mantenimiento = Mantenimiento::findOrFail($id);// Intenta encontrar el cantón por su ID

            return view('mantenimiento.show', compact('mantenimiento'));// Devuelve la vista con los detalles del mantenimiento
        
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el mantenimiento, redirige a la lista de mantenimientos con un mensaje de error
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
            $mantenimiento = Mantenimiento::findOrFail($id);// Intenta encontrar el cantón por su ID
            
            // Verificar si el estado del mantenimiento es 1 (Nuevo)
            if ($mantenimiento->mantestado_id != 1) {
                return redirect()->route('mantenimientos.index')->with('error', 'No puedes editar esta orden de mantenimiento porque esta en estado "' . $mantenimiento->mantestado->nombre . '".');
            }
    
            $d_mantestado = Mantestado::all();// Obtener todas las opciones de estado de mantenimiento
            $user = auth()->user();// Obtener información del usuario autenticado
            $d_vehiculo = Asignarvehiculo::where('user_id', $user->id)->first();// Obtener el vehículo asignado al usuario
            $edicion = true;// Indicador de edición
    
            // Devolver la vista de edición con los datos del mantenimiento y las opciones disponibles
            return view('mantenimiento.edit', compact('mantenimiento', 'edicion', 'd_mantestado', 'user', 'd_vehiculo'));
        
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el mantenimiento, redirige a la lista de mantenimientos con un mensaje de error
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
        $validator = Validator::make($request->all(), Mantenimiento::$rules);// Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        $request = $this->getInfo($request);// Obtener información adicional del request

        // Validar si el nuevo estado seleccionado es 2, 3, 4 o 5 (Aceptado, Reasignado, En Proceso, Finalizado)
        if (in_array($request->input('mantestado_id'), [2, 3, 4, 5])) {
            return back()->with('error', 'No puedes cambiar el estado de esta orden de mantenimiento.');
        }

        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos

            $mantenimiento->update($request->all());// Actualizar los datos del mantenimiento con los proporcionados en el formulario

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('mantenimientos.index')
                ->with('success', 'Orden de mantenimiento actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
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
            DB::beginTransaction();// Iniciar una transacción de base de datos
        
            $mantenimiento = Mantenimiento::findOrFail($id);// Buscar el mantenimiento por su ID
    
            // Verificar si el mantestado es igual a 2 (Aceptado) o 3 (Reasignado)
            if (in_array($mantenimiento->mantestado_id, [2, 3])) {
                return redirect()->route('mantenimientos.index')->with('error', 'No se puede eliminar la orden de mantenimiento porque esta "' . $mantenimiento->mantestado->nombre . '".');
            }

            $mantenimiento->delete();// Eliminar el mantenimiento
        
            DB::commit();// Confirmar la transacción
        
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('mantenimientos.index')->with('success', 'Orden de Mantenimiento borrado exitosamente.');
        
        } catch (ModelNotFoundException $e) {
             // En caso de que el mantenimiento no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Orden de mantenimiento no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error: No se puede eliminar, la orden de mantenimiento se encuentra "' . $mantenimiento->mantestado->nombre . '".');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error al eliminar la orden de mantenimiento: ' . $e->getMessage());
        }
    }


    private function getInfo(Request $request)
    {
        
        $user_id = Auth::id();// Obtener el ID del usuario autenticado
        $request->merge(['user_id' => $user_id]);// Agregar el ID del usuario al request
    
        $placa = $request->input('vehiculo_id'); // Obtener el ID del vehículo desde la relación
        $vehiculo_id = Vehiculo::where('placa', $placa)->value('id');// Buscar el ID del vehículo por su placa
        $request->merge(['vehiculo_id' => $vehiculo_id]);// Agregar el ID del vehículo al request
    
        return $request; // Devolver el request con la información adicional agregada
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
            DB::beginTransaction();// Iniciar una transacción de base de datos
            $mantenimiento = Mantenimiento::findOrFail($id);// Buscar el mantenimiento por su ID
    
            // Verificar si el mantestado actual es 3, 4 o 5 (Re-Asignado, En Proceso y Finalizado)
            if ($mantenimiento->mantestado_id == 3 || $mantenimiento->mantestado_id == 4 || $mantenimiento->mantestado_id == 5) {
                return redirect()->route('mantenimientos.index')->with('error', 'No se puede aceptar la orden de mantenimiento porque está "' . $mantenimiento->mantestado->nombre . '".');
            }
            // Verificar si el mantestado actual es 2 (Aceptado)
            if ($mantenimiento->mantestado_id == 2) {
                return redirect()->route('mantenimientos.index')->with('error', 'La orden de mantenimiento ya ha sido "' . $mantenimiento->mantestado->nombre . '".');
            }

            $mantenimiento->update(['mantestado_id' => 2]);// Actualizar el estado del mantenimiento a "Aceptado"

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('mantenimientos.index')->with('success', 'Orden de mantenimiento aceptada exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
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
            $id = $request->input('id');// Obtener el ID del mantenimiento a reasignar desde la solicitud
            $fecha = $request->input('fecha');// Obtener la nueva fecha desde la solicitud
            $hora = $request->input('hora');// Obtener la nueva hora desde la solicitud

            DB::beginTransaction();// Iniciar una transacción de base de datos

            $mantenimiento = Mantenimiento::findOrFail($id);// Buscar el mantenimiento por su ID

            // // Verificar si el estado actual del mantenimiento es 4 o 5 (En-Proceso o Finalizado)
            if ($mantenimiento->mantestado_id == 4 || $mantenimiento->mantestado_id == 5) {
                return redirect()->route('mantenimientos.index')->with('error', 'No se puede reasignar la orden de mantenimiento porque está "' . $mantenimiento->mantestado->nombre . '".');
            }

            // Actualizar la fecha, hora y estado del mantenimiento a "Re-Asignado"
            $mantenimiento->update(['fecha' => $fecha, 'hora' => $hora, 'mantestado_id' => 3]);

            DB::commit(); // Confirmar la transacción

            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('mantenimientos.index')->with('success', 'Orden de mantenimiento reasignado exitosamente.');
        
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('mantenimientos.index')->with('error', 'Error al reasignar la orden de mantenimiento.');
        }
    }


    public function pdf($id){
        try {
            $mantenimiento = Mantenimiento::findOrFail($id);// Buscar el mantenimiento por su ID
            
            $pdf = PDF::loadView('mantenimiento.pdf', compact('mantenimiento'));// Cargar la vista del PDF con los datos del mantenimiento
        
            return $pdf->stream();// Mostrar el PDF al usuario

        } catch (\Exception $e) {
            //En caso de error, redirigir con un mensaje de error
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }
}
