<?php

namespace App\Http\Controllers;

use App\Models\Vehientrega;
use App\Models\Vehirecepcione;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
/**
 * Class VehientregaController
 * @package App\Http\Controllers
 */
class VehientregaController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:vehientregas.index')->only('index');
        $this->middleware('can:vehientregas.create')->only('create', 'store');
        $this->middleware('can:vehientregas.edit')->only('edit', 'update');
        $this->middleware('can:vehientregas.show')->only('show');
        $this->middleware('can:vehientregas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Vehientrega::query(); // Se crea una consulta para obtener los provincias
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('fecha_entrega', 'like', '%' . $search . '%')
                    ->orWhere('p_retiro', 'like', '%' . $search . '%')
                    ->orWhere('km_actual', 'like', '%' . $search . '%')
                    ->orWhere('km_proximo', 'like', '%' . $search . '%')
                    ->orWhere('observaciones', 'like', '%' . $search . '%')
                    ->orWhereHas('vehirecepciones_id', function ($q) use ($search) {
                        $q->where('placa', 'like', '%' . $search . '%');
                    });
            });
        }
    
        $vehientregas = $query->paginate(10);// Se obtienen los provincias paginados
        
        // Se devuelve la vista con los provincias paginados
        return view('vehientrega.index', compact('vehientregas'))
            ->with('i', (request()->input('page', 1) - 1) * $vehientregas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehientrega = new Vehientrega(); // Se crea una nueva instancia de provincia

        $d_vehirecepciones = Vehirecepcione::all();
        $edicion = true;
    
        // Obtener las órdenes ya seleccionadas
        $ordenesSeleccionadas = Vehientrega::pluck('vehirecepciones_id')->toArray();
        // Se devuelve la vista con el formulario de creación
        return view('vehientrega.create', compact('vehientrega', 'd_vehirecepciones', 'ordenesSeleccionadas', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Vehientrega::$rules);// Se validan los datos del formulario
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            
            DB::beginTransaction();// Iniciar la transacción de base de datos
    
            // Cálculo de km_proximo
            $mantetipo = Vehirecepcione::find($request->input('vehirecepciones_id'))->mantetipo;
    
            // Calcular el km_proximo según el tipo de mantenimiento
            if ($mantetipo->id == 1 || $mantetipo->id == 2 || $mantetipo->id == 4) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 5000]);
            } elseif ($mantetipo->id == 3) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 2000]);
            }
    
            
            Vehientrega::create($request->all());// Crear un nuevo registro de vehientrega con los datos validados
    
            // Actualizar el estado del mantenimiento en la tabla mantenimientos
            $mantenimiento = Vehirecepcione::find($request->input('vehirecepciones_id'))->mantenimiento;
            $mantenimiento->update(['mantestado_id' => 5]);
    
            
            DB::commit();// Confirmar la transacción de base de datos
    
            // Redirigir a la página de índice de vehientregas con un mensaje de éxito
            return redirect()->route('vehientregas.index')->with('success', 'Entrega de vehículo creado exitosamente.');

        } catch (\Exception $e) {
            // Revertir la transacción de base de datos en caso de error
            DB::rollBack();
    
            // Manejar el error en caso de que ocurra durante la transacción
            return redirect()->route('vehientregas.index')->with('error', 'Error al crear la entrega de vehículo: ' . $e->getMessage());
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
            $vehientrega = Vehientrega::findOrFail($id); // Intenta encontrar el vehientrega por su ID
            return view('vehientrega.show', compact('vehientrega')); // Devuelve la vista con los detalles del vehientrega
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vehientrega, redirige a la lista de vehientrega con un mensaje de error
            return redirect()->route('vehientrega.index')->with('error', 'El vehículo de entrega no existe.');
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
            
            $vehientrega = Vehientrega::findOrFail($id);// Obtener el vehículo de entrega con el ID proporcionado
            
            $d_vehirecepciones = Vehirecepcione::all();// Obtener todas las recepciones de vehículos disponibles
            
            $edicion = false;

            return view('vehientrega.edit', compact('vehientrega', 'd_vehirecepciones', 'edicion')); // Devuelve la vista con el vehientrega a editar
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vehientrega, redirige a la lista de vehientrega con un mensaje de error
            return redirect()->route('vehientrega.index')->with('error', 'El vehículo de entrega no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehientrega $vehientrega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehientrega $vehientrega)
    {
        $validator = Validator::make($request->all(), Vehientrega::$rules); // Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            
            DB::beginTransaction();// Iniciar la transacción de base de datos
    
            // Lógica de cálculo de km_proximo
            $mantetipo = Vehirecepcione::find($request->input('vehirecepciones_id'))->mantetipo;
    
            if ($mantetipo->id == 1 || $mantetipo->id == 2 || $mantetipo->id == 4) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 5000]);
            } elseif ($mantetipo->id == 3) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 2000]);
            }
            
            $vehientrega->update($request->all());// Actualizar la Vehientrega con los datos validados
    
            DB::commit();// Confirmar la transacción de base de datos
    
            // Redirigir a la página de índice de vehientregas con un mensaje de éxito
            return redirect()->route('vehientregas.index')->with('success', 'Entrega de vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
            // Revertir la transacción de base de datos en caso de error
            DB::rollBack();
    
            // Manejar el error en caso de que ocurra durante la transacción
            return redirect()->route('vehientregas.index')->with('error', 'Error al actualizar la entrega de vehículo: ' . $e->getMessage());
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
            
            $vehientrega = Vehientrega::findOrFail($id);// Buscar el vehientrega por su ID
    
            // Verificar si el estado del mantenimiento es 5 (finalizado)
            $mantestado = $vehientrega->vehirecepcione->mantenimiento->mantestado_id;
            if ($mantestado == 5) {
                throw new \Exception('No se puede eliminar la orden de mantenimiento si se encuentra en estado "' . $vehientrega->vehirecepcione->mantenimiento->mantestado->nombre . '".');
            }
    
            $vehientrega->delete();// Eliminar el vehientrega
            
            DB::commit();// Confirmar la transacción
            
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('vehientregas.index')->with('success', 'Entrega del vehículo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el provincia no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehientregas.index')->with('error', 'Entrega del vehículo no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehientregas.index')->with('error', 'Error: No se puede eliminar, el mantenimiento se encuentra "' . $vehientrega->vehirecepcion->mantenimiento->mantestado->nombre . '".' . $e->getMessage());
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('vehientregas.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    
    public function pdf($id){
        try {
            $vehientrega = Vehientrega::findOrFail($id);// Buscar el vehientrega por su ID
            
            $pdf = PDF::loadView('vehientrega.pdf', compact('vehientrega'));
        
            return $pdf->stream();
        } catch (\Exception $e) {
            // Manejar la excepción aquí, por ejemplo, redirigir a una página de error o mostrar un mensaje al usuario
            return response()->json(['error' => 'Error al generar el PDF: ' . $e->getMessage()], 500);
        }
    }

}
