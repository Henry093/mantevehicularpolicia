<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Rango;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class RangoController
 * @package App\Http\Controllers
 */
class RangoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rangos.index')->only('index');
        $this->middleware('can:rangos.create')->only('create', 'store');
        $this->middleware('can:rangos.edit')->only('edit', 'update');
        $this->middleware('can:rangos.show')->only('show');
        $this->middleware('can:rangos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Rango::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('grado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $rangos = $query->paginate(12);

        return view('rango.index', compact('rangos'))
            ->with('i', (request()->input('page', 1) - 1) * $rangos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rango = new Rango();

        $d_grado = Grado::all();
        return view('rango.create', compact('rango', 'd_grado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Rango::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $rangoExistente = Rango::where('nombre', $nombre)->first();
            if ($rangoExistente) {
                return redirect()->route('rangos.create')->with('error', 'El rango ya está registrado.');
            }

            Rango::create($request->all());

            DB::commit();

            return redirect()->route('rangos.index')->with('success', 'Rango creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'Error al crear el rango: ' . $e->getMessage());
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
            $rango = Rango::findOrFail($id);
            return view('rango.show', compact('rango'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('rangos.index')->with('error', 'El rango no existe.');
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
            $rango = Rango::findOrFail($id);
            $d_grado = Grado::all();
            return view('rango.edit', compact('rango', 'd_grado'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('rangos.index')->with('error', 'El rango no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Rango $rango
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rango $rango)
    {
        $validator = Validator::make($request->all(), Rango::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $rangoExistente = Rango::where('nombre', $nombre)->where('id', '!=', $rango->id)->first();
            if ($rangoExistente) {
                return redirect()->route('rangos.index')->with('error', 'Ya existe un rango con ese nombre.');
            }

            $rango->update($request->all());

            DB::commit();

            return redirect()->route('rangos.index')->with('success', 'Rango actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'Error al actualizar el rango: ' . $e->getMessage());
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

            $rango = Rango::findOrFail($id);
            $rango->delete();

            DB::commit();

            return redirect()->route('rangos.index')->with('success', 'Rango borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'El rango no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'El rango no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('rangos.index')->with('error', 'Error al eliminar el rango: ' . $e->getMessage());
        }
    }
}
