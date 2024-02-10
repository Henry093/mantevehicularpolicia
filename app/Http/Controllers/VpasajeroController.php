<?php

namespace App\Http\Controllers;

use App\Models\Vpasajero;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class VpasajeroController
 * @package App\Http\Controllers
 */
class VpasajeroController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:vpasajeros.index')->only('index');
        $this->middleware('can:vpasajeros.create')->only('create', 'store');
        $this->middleware('can:vpasajeros.edit')->only('edit', 'update');
        $this->middleware('can:vpasajeros.show')->only('show');
        $this->middleware('can:vpasajeros.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Vpasajero::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $vpasajeros = $query->paginate(12);

        return view('vpasajero.index', compact('vpasajeros'))
            ->with('i', (request()->input('page', 1) - 1) * $vpasajeros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vpasajero = new Vpasajero();
        return view('vpasajero.create', compact('vpasajero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Vpasajero::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $vpasajeroExistente = Vpasajero::where('nombre', $nombre)->first();
            if ($vpasajeroExistente) {
                return redirect()->route('vpasajeros.create')->with('error', 'La capacidad de pasajeros ya está registrada.');
            }

            Vpasajero::create($request->all());

            DB::commit();

            return redirect()->route('vpasajeros.index')->with('success', 'Capacidad de pasajeros creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'Error al crear la capacidad de pasajeros: ' . $e->getMessage());
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
            $vpasajero = Vpasajero::findOrFail($id);
            return view('vpasajero.show', compact('vpasajero'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no existe.');
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
            $vpasajero = Vpasajero::findOrFail($id);
            return view('vpasajero.edit', compact('vpasajero'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vpasajero $vpasajero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vpasajero $vpasajero)
    {
        $validator = Validator::make($request->all(), Vpasajero::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $vpasajeroExistente = Vpasajero::where('nombre', $nombre)->where('id', '!=', $vpasajero->id)->first();
            if ($vpasajeroExistente) {
                return redirect()->route('vpasajeros.index')->with('error', 'Ya existe una capacidad de pasajeros con ese nombre.');
            }

            $vpasajero->update($request->all());

            DB::commit();

            return redirect()->route('vpasajeros.index')->with('success', 'Capacidad de pasajeros actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'Error al actualizar la capacidad de pasajeros: ' . $e->getMessage());
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

            $vpasajero = Vpasajero::findOrFail($id);
            $vpasajero->delete();

            DB::commit();

            return redirect()->route('vpasajeros.index')->with('success', 'Capacidad de pasajeros borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'La capacidad de pasajeros no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vpasajeros.index')->with('error', 'Error al eliminar la capacidad de pasajeros: ' . $e->getMessage());
        }
    }
}
