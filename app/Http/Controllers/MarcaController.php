<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Tvehiculo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MarcaController
 * @package App\Http\Controllers
 */
class MarcaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:marcas.index')->only('index');
        $this->middleware('can:marcas.create')->only('create', 'store');
        $this->middleware('can:marcas.edit')->only('edit', 'update');
        $this->middleware('can:marcas.show')->only('show');
        $this->middleware('can:marcas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Marca::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('tvehiculo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
    
        $marcas = $query->paginate(12);
    
        return view('marca.index', compact('marcas'))
            ->with('i', ($marcas->currentPage() - 1) * $marcas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $marca = new Marca();

        $tvehiculos = Tvehiculo::all();
        return view('marca.create', compact('marca', 'tvehiculos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Marca::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
    
            // Verificar si la marca ya está registrada para tvehiculo = 1
            $marcaRegistradaTvehiculo1 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 1);
                })
                ->exists();
    
            // Verificar si la marca ya está registrada para tvehiculo = 2
            $marcaRegistradaTvehiculo2 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 2);
                })
                ->exists();
            
                // Verificar si la marca ya está registrada para tvehiculo = 2
            $marcaRegistradaTvehiculo3 = Marca::where('nombre', $nombre)
            ->whereHas('tvehiculo', function ($query) {
                $query->where('id', 3);
            })
            ->exists();
    
            if ($marcaRegistradaTvehiculo1 && $request->input('tvehiculo_id') == 1) {
                // La marca ya está registrada para tvehiculo = 1
                return redirect()->route('marcas.create')->with('error', 'La marca ya está registrada en automovil.');
            }
    
            if ($marcaRegistradaTvehiculo2 && $request->input('tvehiculo_id') == 2) {
                // La marca ya está registrada para tvehiculo = 2
                return redirect()->route('marcas.create')->with('error', 'La marca ya está registrada en camioneta.');
            }
    
            if ($marcaRegistradaTvehiculo3 && $request->input('tvehiculo_id') == 3) {
                // La marca ya está registrada para tvehiculo = 2
                return redirect()->route('marcas.create')->with('error', 'La marca ya está registrada en motocicleta.');
            }
    
            Marca::create($request->all());
    
            DB::commit();
    
            return redirect()->route('marcas.index')->with('success', 'Marca creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'Error al crear la marca: ' . $e->getMessage());
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
            $marca = Marca::findOrFail($id);
            return view('marca.show', compact('marca'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('marcas.index')->with('error', 'La marca no existe.');
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
            $marca = Marca::findOrFail($id);
            $tvehiculos = Tvehiculo::all();
            return view('marca.edit', compact('marca', 'tvehiculos'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('marcas.index')->with('error', 'La marca no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marca $marca)
    {
        $validator = Validator::make($request->all(), Marca::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
    
            // Verificar si la marca ya está registrada para tvehiculo = 1
            $marcaRegistradaTvehiculo1 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 1);
                })
                ->where('id', '!=', $marca->id)
                ->exists();
    
            // Verificar si la marca ya está registrada para tvehiculo = 2
            $marcaRegistradaTvehiculo2 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 2);
                })
                ->where('id', '!=', $marca->id)
                ->exists();
    
            // Verificar si la marca ya está registrada para tvehiculo = 3
            $marcaRegistradaTvehiculo3 = Marca::where('nombre', $nombre)
                ->whereHas('tvehiculo', function ($query) {
                    $query->where('id', 3);
                })
                ->where('id', '!=', $marca->id)
                ->exists();
    
            // Verificar si la marca ya está registrada para los tipos de vehículo
            if ($marcaRegistradaTvehiculo1 && $request->input('tvehiculo_id') == 1) {
                // La marca ya está registrada para tvehiculo = 1
                return redirect()->route('marcas.index')->with('error', 'La marca ya está registrada en automóvil.');
            }
    
            if ($marcaRegistradaTvehiculo2 && $request->input('tvehiculo_id') == 2) {
                // La marca ya está registrada para tvehiculo = 2
                return redirect()->route('marcas.index')->with('error', 'La marca ya está registrada en camioneta.');
            }
    
            if ($marcaRegistradaTvehiculo3 && $request->input('tvehiculo_id') == 3) {
                // La marca ya está registrada para tvehiculo = 3
                return redirect()->route('marcas.index')->with('error', 'La marca ya está registrada en motocicleta.');
            }
    
            // Si no se encuentra registrada para el tipo de vehículo correspondiente, se procede con la actualización
            $marca->update($request->all());
    
            DB::commit();
    
            return redirect()->route('marcas.index')->with('success', 'Marca actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'Error al actualizar la marca: ' . $e->getMessage());
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

            $marca = Marca::findOrFail($id);
            $marca->delete();

            DB::commit();

            return redirect()->route('marcas.index')->with('success', 'Marca borrada exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'La marca no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'La marca no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('marcas.index')->with('error', 'Error al eliminar la marca: ' . $e->getMessage());
        }
    }
}
