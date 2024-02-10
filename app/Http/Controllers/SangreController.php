<?php

namespace App\Http\Controllers;

use App\Models\Sangre;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class SangreController
 * @package App\Http\Controllers
 */
class SangreController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:sangres.index')->only('index');
        $this->middleware('can:sangres.create')->only('create', 'store');
        $this->middleware('can:sangres.edit')->only('edit', 'update');
        $this->middleware('can:sangres.show')->only('show');
        $this->middleware('can:sangres.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Sangre::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $sangres = $query->paginate(12);

        return view('sangre.index', compact('sangres'))
            ->with('i', (request()->input('page', 1) - 1) * $sangres->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sangre = new Sangre();
        return view('sangre.create', compact('sangre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Sangre::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $sangreExistente = Sangre::where('nombre', $nombre)->first();
            if ($sangreExistente) {
                return redirect()->route('sangres.create')->with('error', 'El tipo de sangre ya está registrado.');
            }

            Sangre::create($request->all());

            DB::commit();

            return redirect()->route('sangres.index')->with('success', 'Tipo de sangre creada exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'Error al crear el tipo de sangre: ' . $e->getMessage());
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
            $sangre = Sangre::findOrFail($id);
            return view('sangre.show', compact('sangre'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no existe.');
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
            $sangre = Sangre::findOrFail($id);
            return view('sangre.edit', compact('sangre'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Sangre $sangre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sangre $sangre)
    {
        $validator = Validator::make($request->all(), Sangre::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $sangreExistente = Sangre::where('nombre', $nombre)->where('id', '!=', $sangre->id)->first();
            if ($sangreExistente) {
                return redirect()->route('sangres.index')->with('error', 'Ya existe un tipo de sangre con ese nombre.');
            }

            $sangre->update($request->all());

            DB::commit();

            return redirect()->route('sangres.index')->with('success', 'Tipo de sangre actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'Error al actualizar el tipo de sangre: ' . $e->getMessage());
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

            $sangre = Sangre::findOrFail($id);
            $sangre->delete();

            DB::commit();

            return redirect()->route('sangres.index')->with('success', 'Tipo de sangre borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'El tipo de sangre no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sangres.index')->with('error', 'Error al eliminar el tipo de sangre: ' . $e->getMessage());
        }
    }
}
