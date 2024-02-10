<?php

namespace App\Http\Controllers;

use App\Models\Tnovedade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class TnovedadeController
 * @package App\Http\Controllers
 */
class TnovedadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tnovedades.index')->only('index');
        $this->middleware('can:tnovedades.create')->only('create', 'store');
        $this->middleware('can:tnovedades.edit')->only('edit', 'update');
        $this->middleware('can:tnovedades.show')->only('show');
        $this->middleware('can:tnovedades.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Tnovedade::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $tnovedades = $query->paginate(12);

        return view('tnovedade.index', compact('tnovedades'))
            ->with('i', (request()->input('page', 1) - 1) * $tnovedades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tnovedade = new Tnovedade();
        return view('tnovedade.create', compact('tnovedade'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Tnovedade::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $tnovedadeExistente = Tnovedade::where('nombre', $nombre)->first();
            if ($tnovedadeExistente) {
                return redirect()->route('tnovedades.create')->with('error', 'El tipo de novedad ya está registrado.');
            }
    
            Tnovedade::create($request->all());
    
            DB::commit();
    
            return redirect()->route('tnovedades.index')->with('success', 'Tipo de novedad creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'Error al crear el tipo de novedad: ' . $e->getMessage());
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
            $tnovedade = Tnovedade::findOrFail($id);
            return view('tnovedade.show', compact('tnovedade'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no existe.');
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
            $tnovedade = Tnovedade::findOrFail($id);
            return view('tnovedade.edit', compact('tnovedade'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tnovedade $tnovedade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tnovedade $tnovedade)
    {
        $validator = Validator::make($request->all(), Tnovedade::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $tnovedadeExistente = Tnovedade::where('nombre', $nombre)->where('id', '!=', $tnovedade->id)->first();
            if ($tnovedadeExistente) {
                return redirect()->route('tnovedades.index')->with('error', 'Ya existe un tipo de novedad con ese nombre.');
            }
    
            $tnovedade->update($request->all());
    
            DB::commit();
    
            return redirect()->route('tnovedades.index')->with('success', 'Tipo de novedad actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'Error al actualizar el tipo de novedad: ' . $e->getMessage());
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
    
            $tnovedade = Tnovedade::findOrFail($id);
            $tnovedade->delete();
    
            DB::commit();
    
            return redirect()->route('tnovedades.index')->with('success', 'Tipo de novedad borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'El tipo de novedad no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('tnovedades.index')->with('error', 'Error al eliminar el tipo de novedad: ' . $e->getMessage());
        }
    }
}
