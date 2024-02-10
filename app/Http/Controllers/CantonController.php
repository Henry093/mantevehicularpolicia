<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class CantonController
 * @package App\Http\Controllers
 */
class CantonController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:cantons.index')->only('index');
        $this->middleware('can:cantons.create')->only('create', 'store');
        $this->middleware('can:cantons.edit')->only('edit', 'update');
        $this->middleware('can:cantons.show')->only('show');
        $this->middleware('can:cantons.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');
        $query = Canton::query();
    
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%')
                ->orWhereHas('provincia', function ($q) use ($search) {
                    $q->where('nombre', 'like', '%' . $search . '%');
                });
        }

        $cantons = $query->paginate(12);

        return view('canton.index', compact('cantons'))
            ->with('i', (request()->input('page', 1) - 1) * $cantons->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $canton = new Canton();
        $d_provincia = Provincia::all();
        return view('canton.create', compact('canton', 'd_provincia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Canton::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = Canton::where('nombre', $request->input('nombre'))->first();
            if ($nombre) {
                return redirect()->route('cantons.create')->with('error', 'El cantón ya está registrado.');
            }

            $canton = Canton::create($request->all());

            DB::commit();

            return redirect()->route('cantons.index')
                ->with('success', 'Cantón creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'Error al crear el cantón: ' . $e->getMessage());
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
            $canton = Canton::findOrFail($id);
            return view('canton.show', compact('canton'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('cantons.index')->with('error', 'El cantón no existe.');
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
            $canton = Canton::findOrFail($id);
            $d_provincia = Provincia::all();
            return view('canton.edit', compact('canton', 'd_provincia'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('cantons.index')->with('error', 'El cantón no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Canton $canton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Canton $canton)
    {
        $validator = Validator::make($request->all(), Canton::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $cantonExistente = Canton::where('nombre', $nombre)->where('id', '!=', $canton->id)->first();
            if ($cantonExistente) {
                return redirect()->route('cantons.index')->with('error', 'Ya existe un cantón con ese nombre.');
            }
    
            $canton->update($request->all());
    
            DB::commit();
    
            return redirect()->route('cantons.index')->with('success', 'Cantón actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'Error al actualizar el cantón: ' . $e->getMessage());
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

            $canton = Canton::findOrFail($id);
            $canton->delete();

            DB::commit();

            return redirect()->route('cantons.index')->with('success', 'Cantón borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'El cantón no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'El cantón no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cantons.index')->with('error', 'Error al eliminar el cantón: ' . $e->getMessage());
        }
    }
}
