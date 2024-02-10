<?php

namespace App\Http\Controllers;

use App\Models\Mantetipo;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class MantetipoController
 * @package App\Http\Controllers
 */
class MantetipoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantetipos.index')->only('index');
        $this->middleware('can:mantetipos.create')->only('create', 'store');
        $this->middleware('can:mantetipos.edit')->only('edit', 'update');
        $this->middleware('can:mantetipos.show')->only('show');
        $this->middleware('can:mantetipos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');
        $query = Mantetipo::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('valor', 'like', '%' . $search . '%')
                    ->orWhere('descripcion', 'like', '%' . $search . '%');
            });
        }
        $mantetipos = $query->paginate(12);

        return view('mantetipo.index', compact('mantetipos'))
            ->with('i', (request()->input('page', 1) - 1) * $mantetipos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mantetipo = new Mantetipo();
        return view('mantetipo.create', compact('mantetipo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Mantetipo::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $mantetipoExistente = Mantetipo::where('nombre', $nombre)->first();
            if ($mantetipoExistente) {
                return redirect()->route('mantetipos.create')->with('error', 'El tipo de mantenimiento ya está registrado.');
            }

            Mantetipo::create($request->all());

            DB::commit();

            return redirect()->route('mantetipos.index')->with('success', 'Tipo de mantenimiento creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'Error al crear el tipo de mantenimiento: ' . $e->getMessage());
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
            $mantetipo = Mantetipo::findOrFail($id);
            return view('mantetipo.show', compact('mantetipo'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mantetipos.index')->with('error', 'Tipo de mantenimiento no existe.');
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
            $mantetipo = Mantetipo::findOrFail($id);
            return view('mantetipo.edit', compact('mantetipo'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('mantetipos.index')->with('error', 'Tipo de mantenimiento no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantetipo $mantetipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantetipo $mantetipo)
    {
        $validator = Validator::make($request->all(), Mantetipo::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $nombre = $request->input('nombre');
            $mantetipoExistente = Mantetipo::where('nombre', $nombre)->where('id', '!=', $mantetipo->id)->first();
            if ($mantetipoExistente) {
                return redirect()->route('mantetipos.index')->with('error', 'Ya existe un tipo de mantenimiento con ese nombre.');
            }

            $mantetipo->update($request->all());

            DB::commit();

            return redirect()->route('mantetipos.index')->with('success', 'Tipo de mantenimiento actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'Error al actualizar el tipo de mantenimiento: ' . $e->getMessage());
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
    
            $mantetipo = Mantetipo::findOrFail($id);
            $mantetipo->delete();
    
            DB::commit();
    
            return redirect()->route('mantetipos.index')->with('success', 'Tipo de mantenimiento borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'El tipo de mantenimiento no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'El tipo de mantenimiento no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('mantetipos.index')->with('error', 'Error al eliminar el tipo de mantenimiento: ' . $e->getMessage());
        }
    }
}
