<?php

namespace App\Http\Controllers;

use App\Models\Vehientrega;
use App\Models\Vehirecepcione;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class VehientregaController
 * @package App\Http\Controllers
 */
class VehientregaController extends Controller
{
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
        $vehientregas = Vehientrega::paginate(10);

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
        $vehientrega = new Vehientrega();
        $d_vehirecepciones = Vehirecepcione::all();
        $edicion = true;
    
        // Obtener las órdenes ya seleccionadas
        $ordenesSeleccionadas = Vehientrega::pluck('vehirecepciones_id')->toArray();
    
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
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), Vehientrega::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            // Iniciar la transacción de base de datos
            DB::beginTransaction();
    
            // Cálculo de km_proximo
            $mantetipo = Vehirecepcione::find($request->input('vehirecepciones_id'))->mantetipo;
    
            // Calcular el km_proximo según el tipo de mantenimiento
            if ($mantetipo->id == 1 || $mantetipo->id == 2 || $mantetipo->id == 4) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 5000]);
            } elseif ($mantetipo->id == 3) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 2000]);
            }
    
            // Crear un nuevo registro de vehientrega con los datos validados
            Vehientrega::create($request->all());
    
            // Actualizar el estado del mantenimiento en la tabla mantenimientos
            $mantenimiento = Vehirecepcione::find($request->input('vehirecepciones_id'))->mantenimiento;
            $mantenimiento->update(['mantestado_id' => 5]);
    
            // Confirmar la transacción de base de datos
            DB::commit();
    
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
            $vehientrega = Vehientrega::findOrFail($id);
            return view('vehientrega.show', compact('vehientrega'));
        } catch (ModelNotFoundException $e) {
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
            // Obtener el vehículo de entrega con el ID proporcionado
            $vehientrega = Vehientrega::findOrFail($id);
            
            // Obtener todas las recepciones de vehículos disponibles
            $d_vehirecepciones = Vehirecepcione::all();
            
            $edicion = false;

            return view('vehientrega.edit', compact('vehientrega', 'd_vehirecepciones', 'edicion'));
        } catch (ModelNotFoundException $e) {
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
        // Validar los datos de entrada
        $validator = Validator::make($request->all(), Vehientrega::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            // Iniciar la transacción de base de datos
            DB::beginTransaction();
    
            // Lógica de cálculo de km_proximo
            $mantetipo = Vehirecepcione::find($request->input('vehirecepciones_id'))->mantetipo;
    
            if ($mantetipo->id == 1 || $mantetipo->id == 2 || $mantetipo->id == 4) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 5000]);
            } elseif ($mantetipo->id == 3) {
                $request->merge(['km_proximo' => $request->input('km_actual') + 2000]);
            }
    
            // Actualizar la Vehientrega con los datos validados
            $vehientrega->update($request->all());
    
            // Confirmar la transacción de base de datos
            DB::commit();
    
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
            DB::beginTransaction();
            
            $vehientrega = Vehientrega::findOrFail($id);
    
            // Verificar si el estado del mantenimiento es 5 (finalizado)
            $mantestado = $vehientrega->vehirecepcione->mantenimiento->mantestado_id;
            if ($mantestado == 5) {
                throw new \Exception('No se puede eliminar la orden de mantenimiento si se encuentra en estado "' . $vehientrega->vehirecepcione->mantenimiento->mantestado->nombre . '".');
            }
    
            $vehientrega->delete();
            
            DB::commit();
            
            return redirect()->route('vehientregas.index')->with('success', 'Entrega del vehículo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('vehientregas.index')->with('error', 'Entrega del vehículo no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('vehientregas.index')->with('error', 'Error: No se puede eliminar, el mantenimiento se encuentra "' . $vehientrega->vehirecepcion->mantenimiento->mantestado->nombre . '".' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehientregas.index')->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
