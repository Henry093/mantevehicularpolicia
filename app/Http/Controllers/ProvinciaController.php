<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ProvinciaController
 * @package App\Http\Controllers
 */
class ProvinciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:provincias.index')->only('index');
        $this->middleware('can:provincias.create')->only('create', 'store');
        $this->middleware('can:provincias.edit')->only('edit', 'update');
        $this->middleware('can:provincias.show')->only('show');
        $this->middleware('can:provincias.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Provincia::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $provincias = $query->paginate(12);

        return view('provincia.index', compact('provincias'))
            ->with('i', (request()->input('page', 1) - 1) * $provincias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provincia = new Provincia();
        return view('provincia.create', compact('provincia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Provincia::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $provinciaExistente = Provincia::where('nombre', $nombre)->first();
            if ($provinciaExistente) {
                return redirect()->route('provincias.create')->with('error', 'La provincia ya está registrada.');
            }
    
            Provincia::create($request->all());
    
            DB::commit();
    
            return redirect()->route('provincias.index')->with('success', 'Provincia creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'Error al crear la provincia: ' . $e->getMessage());
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
            $provincia = Provincia::findOrFail($id);
            return view('provincia.show', compact('provincia'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('provincias.index')->with('error', 'La provincia no existe.');
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
            $provincia = Provincia::findOrFail($id);
            return view('provincia.edit', compact('provincia'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('provincias.index')->with('error', 'La provincia no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Provincia $provincia
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Provincia $provincia)
    {
        $validator = Validator::make($request->all(), Provincia::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $provinciaExistente = Provincia::where('nombre', $nombre)->where('id', '!=', $provincia->id)->first();
            if ($provinciaExistente) {
                return redirect()->route('provincias.index')->with('error', 'Ya existe una provincia con ese nombre.');
            }

            $provincia->update($request->all());

            DB::commit();

            return redirect()->route('provincias.index')->with('success', 'Provincia actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'Error al actualizar la provincia: ' . $e->getMessage());
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

            $provincia = Provincia::findOrFail($id);
            $provincia->delete();

            DB::commit();

            return redirect()->route('provincias.index')->with('success', 'Provincia borrada exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'La provincia no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'La provincia no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('provincias.index')->with('error', 'Error al eliminar la provincia: ' . $e->getMessage());
        }
    }
    
    public function getCantonesc($provinciaId) {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
}
