<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class ParroquiaController
 * @package App\Http\Controllers
 */
class ParroquiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:parroquias.index')->only('index');
        $this->middleware('can:parroquias.create')->only('create', 'store');
        $this->middleware('can:parroquias.edit')->only('edit', 'update');
        $this->middleware('can:parroquias.show')->only('show');
        $this->middleware('can:parroquias.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Parroquia::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('provincia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('canton', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $parroquias = $query->paginate(12);

        return view('parroquia.index', compact('parroquias'))
            ->with('i', (request()->input('page', 1) - 1) * $parroquias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parroquia = new Parroquia();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        return view('parroquia.create', compact('parroquia', 'd_provincia', 'd_canton'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Parroquia::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = Parroquia::where('nombre', $request->input('nombre'))->first();
            if ($nombre) {
                return redirect()->route('parroquias.create')->with('error', 'La parroquia ya está registrada.');
            }

            $parroquia = Parroquia::create($request->all());

            DB::commit();

            return redirect()->route('parroquias.index')->with('success', 'Parroquia creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'Error al crear la parroquia: ' . $e->getMessage());
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
            $parroquia = Parroquia::findOrFail($id);
            return view('parroquia.show', compact('parroquia'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no existe.');
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
            $parroquia = Parroquia::findOrFail($id);
            $d_provincia = Provincia::all();
            $d_canton = Canton::all();
            return view('parroquia.edit', compact('parroquia', 'd_provincia', 'd_canton'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Parroquia $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parroquia $parroquia)
    {
        $validator = Validator::make($request->all(), Parroquia::$rules);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $nombre = $request->input('nombre');
            $parroquiaExistente = Parroquia::where('nombre', $nombre)->where('id', '!=', $parroquia->id)->first();
            if ($parroquiaExistente) {
                return redirect()->route('parroquias.index')->with('error', 'Ya existe una parroquia con ese nombre.');
            }
    
            $parroquia->update($request->all());
    
            DB::commit();
    
            return redirect()->route('parroquias.index')->with('success', 'Parroquia actualizada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'Error al actualizar la parroquia: ' . $e->getMessage());
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

            $parroquia = Parroquia::findOrFail($id);
            $parroquia->delete();

            DB::commit();

            return redirect()->route('parroquias.index')->with('success', 'Parroquia borrada exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'La parroquia no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('parroquias.index')->with('error', 'Error al eliminar la parroquia: ' . $e->getMessage());
        }
    }
}
