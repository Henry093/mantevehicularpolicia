<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class EstadoController
 * @package App\Http\Controllers
 */
class EstadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:estados.index')->only('index');
        $this->middleware('can:estados.create')->only('create', 'store');
        $this->middleware('can:estados.edit')->only('edit', 'update');
        $this->middleware('can:estados.show')->only('show');
        $this->middleware('can:estados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Estado::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $estados = $query->paginate(12);

        return view('estado.index', compact('estados'))
            ->with('i', (request()->input('page', 1) - 1) * $estados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estado = new Estado();
        return view('estado.create', compact('estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Estado::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $estadoExistente = Estado::where('nombre', $nombre)->first();
            if ($estadoExistente) {
                return redirect()->route('estados.create')->with('error', 'El estado ya está registrado.');
            }
    
            Estado::create($request->all());
    
            DB::commit();
    
            return redirect()->route('estados.index')->with('success', 'Estado creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'Error al crear el estado: ' . $e->getMessage());
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
            $estado = Estado::findOrFail($id);
            return view('estado.show', compact('estado'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('estados.index')->with('error', 'El estado no existe.');
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
            $estado = Estado::findOrFail($id);
            return view('estado.edit', compact('estado'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('estados.index')->with('error', 'El estado no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Estado $estado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estado $estado)
    {
        $validator = Validator::make($request->all(), Estado::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $estadoExistente = Estado::where('nombre', $nombre)->where('id', '!=', $estado->id)->first();
            if ($estadoExistente) {
                return redirect()->route('estados.index')->with('error', 'Ya existe un estado con ese nombre.');
            }
    
            $estado->update($request->all());
    
            DB::commit();
    
            return redirect()->route('estados.index')->with('success', 'Estado actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'Error al actualizar el estado: ' . $e->getMessage());
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

            $estado = Estado::findOrFail($id);
            $estado->delete();

            DB::commit();

            return redirect()->route('estados.index')->with('success', 'Estado borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'El estado no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'El estado no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('estados.index')->with('error', 'Error al eliminar el estado: ' . $e->getMessage());
        }
    }
}
