<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class GradoController
 * @package App\Http\Controllers
 */
class GradoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:grados.index')->only('index');
        $this->middleware('can:grados.create')->only('create', 'store');
        $this->middleware('can:grados.edit')->only('edit', 'update');
        $this->middleware('can:grados.show')->only('show');
        $this->middleware('can:grados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Grado::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $grados = $query->paginate(12);

        return view('grado.index', compact('grados'))
            ->with('i', (request()->input('page', 1) - 1) * $grados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grado = new Grado();
        return view('grado.create', compact('grado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Grado::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $gradoExistente = Grado::where('nombre', $nombre)->first();
            if ($gradoExistente) {
                return redirect()->route('grados.create')->with('error', 'El grado ya está registrado.');
            }
    
            Grado::create($request->all());
    
            DB::commit();
    
            return redirect()->route('grados.index')->with('success', 'Grado creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'Error al crear el grado: ' . $e->getMessage());
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
            $grado = Grado::findOrFail($id);
            return view('grado.show', compact('grado'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('grados.index')->with('error', 'El grado no existe.');
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
            $grado = Grado::findOrFail($id);
            return view('grado.edit', compact('grado'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('grados.index')->with('error', 'El grado no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Grado $grado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grado $grado)
    {
        $validator = Validator::make($request->all(), Grado::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $gradoExistente = Grado::where('nombre', $nombre)->where('id', '!=', $grado->id)->first();
            if ($gradoExistente) {
                return redirect()->route('grados.index')->with('error', 'Ya existe un grado con ese nombre.');
            }
    
            $grado->update($request->all());
    
            DB::commit();
    
            return redirect()->route('grados.index')->with('success', 'Grado actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'Error al actualizar el grado: ' . $e->getMessage());
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

            $grado = Grado::findOrFail($id);
            $grado->delete();

            DB::commit();

            return redirect()->route('grados.index')->with('success', 'Grado borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'El grado no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'El grado no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('grados.index')->with('error', 'Error al eliminar el grado: ' . $e->getMessage());
        }
    }
}
