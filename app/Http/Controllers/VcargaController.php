<?php

namespace App\Http\Controllers;

use App\Models\Vcarga;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class VcargaController
 * @package App\Http\Controllers
 */
class VcargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vcargas.index')->only('index');
        $this->middleware('can:vcargas.create')->only('create', 'store');
        $this->middleware('can:vcargas.edit')->only('edit', 'update');
        $this->middleware('can:vcargas.show')->only('show');
        $this->middleware('can:vcargas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Vcarga::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $vcargas = $query->paginate(12);

        return view('vcarga.index', compact('vcargas'))
            ->with('i', (request()->input('page', 1) - 1) * $vcargas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vcarga = new Vcarga();
        return view('vcarga.create', compact('vcarga'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Vcarga::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $vcargaExistente = Vcarga::where('nombre', $nombre)->first();
            if ($vcargaExistente) {
                return redirect()->route('vcargas.create')->with('error', 'La capacidad de carga del vehículo ya está registrada.');
            }

            Vcarga::create($request->all());

            DB::commit();

            return redirect()->route('vcargas.index')->with('success', 'Capacidad de carga del vehículo creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'Error al crear la capacidad de carga del vehículo: ' . $e->getMessage());
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
            $vcarga = Vcarga::findOrFail($id);
            return view('vcarga.show', compact('vcarga'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no existe.');
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
            $vcarga = Vcarga::findOrFail($id);
            return view('vcarga.edit', compact('vcarga'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vcarga $vcarga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vcarga $vcarga)
    {
        $validator = Validator::make($request->all(), Vcarga::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $vcargaExistente = Vcarga::where('nombre', $nombre)->where('id', '!=', $vcarga->id)->first();
            if ($vcargaExistente) {
                return redirect()->route('vcargas.index')->with('error', 'Ya existe una capacidad de carga del vehículo con ese nombre.');
            }

            $vcarga->update($request->all());

            DB::commit();

            return redirect()->route('vcargas.index')->with('success', 'Capacidad de carga del vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'Error al actualizar la capacidad de carga del vehículo: ' . $e->getMessage());
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
    
            $vcarga = Vcarga::findOrFail($id);
            $vcarga->delete();
    
            DB::commit();
    
            return redirect()->route('vcargas.index')->with('success', 'Capacidad de carga del vehículo borrada exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'La capacidad de carga del vehículo no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vcargas.index')->with('error', 'Error al eliminar la capacidad de carga del vehículo: ' . $e->getMessage());
        }
    }
}
