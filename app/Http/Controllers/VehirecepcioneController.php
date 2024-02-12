<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Mantetipo;
use App\Models\Vehirecepcione;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class VehirecepcioneController
 * @package App\Http\Controllers
 */
class VehirecepcioneController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vehirecepciones.index')->only('index');
        $this->middleware('can:vehirecepciones.create')->only('create', 'store');
        $this->middleware('can:vehirecepciones.edit')->only('edit', 'update');
        $this->middleware('can:vehirecepciones.show')->only('show');
        $this->middleware('can:vehirecepciones.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Vehirecepcione::whereHas('mantenimiento', function ($q) {
            $q->where('mantestado_id', 4);
        });
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('fecha_ingreso', 'like', '%' . $search . '%')
                    ->orWhere('hora_ingreso', 'like', '%' . $search . '%')
                    ->orWhere('kilometraje', 'like', '%' . $search . '%')
                    ->orWhere('asunto', 'like', '%' . $search . '%')
                    ->orWhere('detalle', 'like', '%' . $search . '%')
                    ->orWhereHas('mantenimiento', function ($q) use ($search) {
                        $q->where('orden', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('mantetipo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $vehirecepciones = $query->paginate(12);
    
        return view('vehirecepcione.index', compact('vehirecepciones'))
            ->with('i', (request()->input('page', 1) - 1) * $vehirecepciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d_mantetipos = Mantetipo::all();
    
        // Verificar si hay registros de vehículos recibidos
        $vehirecepcionesIds = Vehirecepcione::pluck('mantenimientos_id')->toArray();
        $d_mantenimientos = Mantenimiento::whereNotIn('id', $vehirecepcionesIds)->get();
        
        $vehirecepcione = new Vehirecepcione();
    
        return view('vehirecepcione.create', compact('vehirecepcione', 'd_mantetipos', 'd_mantenimientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Vehirecepcione::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            $request->validate([
                'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // ajusta los formatos y tamaños según necesites
            ]);
    
            $input = $request->all();
    
            DB::beginTransaction();
    
            if ($request->hasFile('imagen')) {
                $image = $request->file('imagen');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('images') . '/' . $imageName;
    
                if ($image->move(public_path('images'), $imageName)) {
                    // Guardar la ruta de la imagen en el array de entrada
                    $input['imagen'] = 'images/' . $imageName;
                } else {
                    // Si la imagen no se guardó correctamente, devolver un mensaje de error
                    return redirect()->route('vehirecepciones.index')
                        ->with('error', 'Error al guardar la imagen en el servidor.');
                }
            }
    
            // Crear el nuevo registro de Vehiregistro
            $vehiregistro = Vehirecepcione::create($input);
    
            // Actualizar el campo mantestado_id en el mantenimiento relacionado
            $mantenimiento = $vehiregistro->mantenimiento;
            $mantenimiento->update(['mantestado_id' => 4]);
    
            DB::commit();
    
            return redirect()->route('vehirecepciones.index')
                ->with('success', 'Recepción del vehículo creado exitosamente.');
        } catch (QueryException $e) {
            DB::rollback();
            // Capturar la excepción y manejar el error de la base de datos
            return redirect()->route('vehirecepciones.create')
                ->with('error', 'Error no existe la orden de mantenimiento');
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
            $vehirecepcione = Vehirecepcione::findOrFail($id);
            return view('vehirecepcione.show', compact('vehirecepcione'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vehirecepciones.index')->with('error', 'El registro de recepción de vehículo no existe.');
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
            $vehirecepcione = Vehirecepcione::findOrFail($id);
                // Verificar si el estado del mantenimiento es 1 (Nuevo)
            if ($vehirecepcione->mantenimiento->mantestado_id != 4) {
                return redirect()->route('vehirecepciones.index')->with('error', 'No puedes editar esta orden de mantenimiento porque esta en estado "' . $vehirecepcione->mantenimiento->mantestado->nombre . '".');
            }
            $d_mantetipos = Mantetipo::all();
            $d_mantenimientos = Mantenimiento::all();
    
            return view('vehirecepcione.edit', compact('vehirecepcione', 'd_mantetipos', 'd_mantenimientos'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vehirecepciones.index')->with('error', 'El registro de recepción de vehículo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehirecepcione $vehirecepcione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehirecepcione $vehirecepcione)
    {
        $validator = Validator::make($request->all(), Vehirecepcione::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            
            // Verificar si se ha seleccionado una nueva imagen
            if ($request->hasFile('imagen')) {
                // Eliminar la imagen anterior del servidor
                if ($vehirecepcione->imagen) {
                    unlink(public_path($vehirecepcione->imagen));
                }
        
                // Guardar la nueva imagen en el servidor y en la base de datos
                $image = $request->file('imagen');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $imagePath = public_path('images') . '/' . $imageName;
        
                if ($image->move(public_path('images'), $imageName)) {
                    // Actualizar el campo 'imagen' con la nueva ruta de la imagen
                    $input['imagen'] = 'images/' . $imageName;
                } else {
                    // Si la imagen no se guardó correctamente, devolver un mensaje de error
                    return redirect()->route('vehirecepciones.edit', $vehirecepcione->id)
                        ->with('error', 'Error al guardar la imagen en el servidor.');
                }
            } else {
                // Si no se ha seleccionado una nueva imagen, mantener la imagen actual
                $input['imagen'] = $vehirecepcione->imagen;
            }
            
            // Actualizar los demás campos del registro
            DB::beginTransaction();

            $vehirecepcione->update($input);

            DB::commit();
        
            return redirect()->route('vehirecepciones.index')
                ->with('success', 'Recepción del vehículo actualizado  exitosamente.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('vehirecepciones.edit', $vehirecepcione->id)
                ->with('error', 'Error al actualizar la recepción del vehículo: ' . $e->getMessage());
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vehirecepciones.edit', $vehirecepcione->id)
                ->with('error', 'Error al actualizar la recepción del vehículo: ' . $e->getMessage());
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
        
            $vehirecepcione = Vehirecepcione::findOrFail($id);

            // Verificar si el mantestado es igual a 2, 3
            if (in_array($vehirecepcione->mantenimiento->mantestado_id, [4, 5])) {
                return redirect()->route('vehirecepciones.index')->with('error', 'No se puede eliminar la orden de mantenimiento porque esta "' . $vehirecepcione->mantenimiento->mantestado->nombre . '".');
            }
    
            // Eliminar el registro de recepción de vehículo
            $vehirecepcione->delete();
        
            DB::commit();
        
            return redirect()->route('vehirecepciones.index')
                ->with('success', 'Recepción del vehículo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Manejar el caso donde el registro de recepción de vehículo no existe
            DB::rollBack();
            return redirect()->route('vehirecepciones.index')->with('error', 'El registro de recepción de vehículo no existe.');
        } catch (QueryException $e) {
            // Manejar errores relacionados con consultas de base de datos
            DB::rollBack();
            return redirect()->route('vehirecepciones.index')->with('error', 'Error al borrar la recepción del vehículo: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Manejar otros errores inesperados
            DB::rollBack();
            return redirect()->route('vehirecepciones.index')->with('error', 'Error al borrar la recepción del vehículo: ' . $e->getMessage());
        }
    }


}
