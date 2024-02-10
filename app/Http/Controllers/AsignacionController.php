<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class AsignacionController
 * @package App\Http\Controllers
 */
class AsignacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:asignacions.index')->only('index');
        $this->middleware('can:asignacions.create')->only('create', 'store');
        $this->middleware('can:asignacions.edit')->only('edit', 'update');
        $this->middleware('can:asignacions.show')->only('show');
        $this->middleware('can:asignacions.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');
        $query = Asignacion::query();

        if($search){
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        $asignacions = $query->paginate(12);

        return view('asignacion.index', compact('asignacions'))
            ->with('i', (request()->input('page', 1) - 1) * $asignacions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asignacion = new Asignacion();
        return view('asignacion.create', compact('asignacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Asignacion::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $asignacionExistente = Asignacion::where('nombre', $nombre)->first();
            if ($asignacionExistente) {
                return redirect()->route('asignacions.create')->with('error', 'La asignación ya está registrada.');
            }
    
            Asignacion::create($request->all());
    
            DB::commit();
    
            return redirect()->route('asignacions.index')->with('success', 'Asignación creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'Error al crear la asignación: ' . $e->getMessage());
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
            $asignacion = Asignacion::findOrFail($id);
            return view('asignacion.show', compact('asignacion'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('asignacions.index')->with('error', 'La asignación no existe.');
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
            $asignacion = Asignacion::findOrFail($id);
            return view('asignacion.edit', compact('asignacion'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('asignacions.index')->with('error', 'La asignación no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Asignacion $asignacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignacion $asignacion)
    {
        $validator = Validator::make($request->all(), Asignacion::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $asignacionExistente = Asignacion::where('nombre', $nombre)->where('id', '!=', $asignacion->id)->first();
            if ($asignacionExistente) {
                return redirect()->route('asignacions.index')->with('error', 'Ya existe una asignación con ese nombre.');
            }

            $asignacion->update($request->all());

            DB::commit();

            return redirect()->route('asignacions.index')->with('success', 'Asignación actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'Error al actualizar la asignación: ' . $e->getMessage());
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

            $asignacion = Asignacion::findOrFail($id);
            $asignacion->delete();

            DB::commit();

            return redirect()->route('asignacions.index')->with('success', 'Asignación borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'La asignación no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'La asignación no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('asignacions.index')->with('error', 'Error al eliminar la asignación: ' . $e->getMessage());
        }
    }
}
