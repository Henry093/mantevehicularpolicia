<?php

namespace App\Http\Controllers;

use App\Models\Tvehiculo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class TvehiculoController
 * @package App\Http\Controllers
 */
class TvehiculoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tvehiculos.index')->only('index');
        $this->middleware('can:tvehiculos.create')->only('create', 'store');
        $this->middleware('can:tvehiculos.edit')->only('edit', 'update');
        $this->middleware('can:tvehiculos.show')->only('show');
        $this->middleware('can:tvehiculos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Tvehiculo::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $tvehiculos = $query->paginate(12);

        return view('tvehiculo.index', compact('tvehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $tvehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tvehiculo = new Tvehiculo();
        return view('tvehiculo.create', compact('tvehiculo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Tvehiculo::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $tvehiculoExistente = Tvehiculo::where('nombre', $nombre)->first();
            if ($tvehiculoExistente) {
                return redirect()->route('tvehiculos.create')->with('error', 'El tipo de vehículo ya está registrado.');
            }

            Tvehiculo::create($request->all());

            DB::commit();

            return redirect()->route('tvehiculos.index')->with('success', 'Tipo de vehículo creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'Error al crear el tipo de vehículo: ' . $e->getMessage());
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
            $tvehiculo = Tvehiculo::findOrFail($id);
            return view('tvehiculo.show', compact('tvehiculo'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no existe.');
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
            $tvehiculo = Tvehiculo::findOrFail($id);
            return view('tvehiculo.edit', compact('tvehiculo'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tvehiculo $tvehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tvehiculo $tvehiculo)
    {
        $validator = Validator::make($request->all(), Tvehiculo::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $tvehiculoExistente = Tvehiculo::where('nombre', $nombre)->where('id', '!=', $tvehiculo->id)->first();
            if ($tvehiculoExistente) {
                return redirect()->route('tvehiculos.index')->with('error', 'Ya existe un tipo de vehículo con ese nombre.');
            }

            $tvehiculo->update($request->all());

            DB::commit();

            return redirect()->route('tvehiculos.index')->with('success', 'Tipo de vehículo actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'Error al actualizar el tipo de vehículo: ' . $e->getMessage());
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

            $tvehiculo = Tvehiculo::findOrFail($id);
            $tvehiculo->delete();

            DB::commit();

            return redirect()->route('tvehiculos.index')->with('success', 'Tipo de vehículo borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'El tipo de vehículo no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tvehiculos.index')->with('error', 'Error al eliminar el tipo de vehículo: ' . $e->getMessage());
        }
    }
}
