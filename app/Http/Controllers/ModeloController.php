<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ModeloController
 * @package App\Http\Controllers
 */
class ModeloController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:modelos.index')->only('index');
        $this->middleware('can:modelos.create')->only('create', 'store');
        $this->middleware('can:modelos.edit')->only('edit', 'update');
        $this->middleware('can:modelos.show')->only('show');
        $this->middleware('can:modelos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Modelo::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('marca', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $modelos = $query->paginate(12);

        return view('modelo.index', compact('modelos'))
            ->with('i', (request()->input('page', 1) - 1) * $modelos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modelo = new Modelo();

        $d_marca = Marca::all();
        return view('modelo.create', compact('modelo', 'd_marca'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Modelo::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $modeloExistente = Modelo::where('nombre', $nombre)->first();
            if ($modeloExistente) {
                return redirect()->route('modelos.create')->with('error', 'El modelo ya está registrado.');
            }
    
            Modelo::create($request->all());
    
            DB::commit();
    
            return redirect()->route('modelos.index')->with('success', 'Modelo creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('modelos.index')->with('error', 'Error al crear el modelo: ' . $e->getMessage());
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
            $modelo = Modelo::findOrFail($id);
            return view('modelo.show', compact('modelo'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('modelos.index')->with('error', 'El modelo no existe.');
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
            $modelo = Modelo::findOrFail($id);
            $d_marca = Marca::all();
            return view('modelo.edit', compact('modelo', 'd_marca'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('modelos.index')->with('error', 'El modelo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Modelo $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modelo $modelo)
    {
        $validator = Validator::make($request->all(), Modelo::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $modeloExistente = Modelo::where('nombre', $nombre)->where('id', '!=', $modelo->id)->first();
            if ($modeloExistente) {
                return redirect()->route('modelos.index')->with('error', 'Ya existe un modelo con ese nombre.');
            }

            $modelo->update($request->all());

            DB::commit();

            return redirect()->route('modelos.index')->with('success', 'Modelo actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('modelos.index')->with('error', 'Error al actualizar el modelo: ' . $e->getMessage());
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
            $modelo = Modelo::findOrFail($id);
            $modelo->delete();

            return redirect()->route('modelos.index')->with('success', 'Modelo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            return redirect()->route('modelos.index')->with('error', 'El modelo no existe.');
        } catch (QueryException $e) {
            return redirect()->route('modelos.index')->with('error', 'El modelo no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            return redirect()->route('modelos.index')->with('error', 'Error al eliminar el modelo: ' . $e->getMessage());
        }
    }
}
