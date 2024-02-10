<?php

namespace App\Http\Controllers;

use App\Models\Mantestado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MantestadoController
 * @package App\Http\Controllers
 */
class MantestadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantestados.index')->only('index');
        $this->middleware('can:mantestados.create')->only('create', 'store');
        $this->middleware('can:mantestados.edit')->only('edit', 'update');
        $this->middleware('can:mantestados.show')->only('show');
        $this->middleware('can:mantestados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Mantestado::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $mantestados = $query->paginate(12);

        return view('mantestado.index', compact('mantestados'))
            ->with('i', (request()->input('page', 1) - 1) * $mantestados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mantestado = new Mantestado();
        return view('mantestado.create', compact('mantestado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Mantestado::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $mantestadoExistente = Mantestado::where('nombre', $nombre)->first();
            if ($mantestadoExistente) {
                return redirect()->route('mantestados.create')->with('error', 'El estado de mantenimiento ya está registrado.');
            }

            Mantestado::create($request->all());

            DB::commit();

            return redirect()->route('mantestados.index')->with('success', 'Estado mantenimiento creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'Error al crear el estado de mantenimiento: ' . $e->getMessage());
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
            $mantestado = Mantestado::findOrFail($id);
            return view('mantestado.show', compact('mantestado'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no existe.');
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
            $mantestado = Mantestado::findOrFail($id);
            return view('mantestado.edit', compact('mantestado'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantestado $mantestado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantestado $mantestado)
    {
        $validator = Validator::make($request->all(), Mantestado::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $mantestadoExistente = Mantestado::where('nombre', $nombre)->where('id', '!=', $mantestado->id)->first();
            if ($mantestadoExistente) {
                return redirect()->route('mantestados.index')->with('error', 'Ya existe un estado de mantenimiento con ese nombre.');
            }

            $mantestado->update($request->all());

            DB::commit();

            return redirect()->route('mantestados.index')->with('success', 'Estado mantenimiento actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'Error al actualizar el estado de mantenimiento: ' . $e->getMessage());
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

            $mantestado = Mantestado::findOrFail($id);
            $mantestado->delete();

            DB::commit();

            return redirect()->route('mantestados.index')->with('success', 'Estado mantenimiento borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'El estado de mantenimiento no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantestados.index')->with('error', 'Error al eliminar el estado de mantenimiento: ' . $e->getMessage());
        }
    }
}
