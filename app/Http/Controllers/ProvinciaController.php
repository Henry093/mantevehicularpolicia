<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Http\Request;

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
        request()->validate(Provincia::$rules);

        $provincia = Provincia::create($request->all());

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $provincia = Provincia::find($id);

        return view('provincia.show', compact('provincia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $provincia = Provincia::find($id);

        return view('provincia.edit', compact('provincia'));
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
        request()->validate(Provincia::$rules);

        $provincia->update($request->all());

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia actualizada exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $provincia = Provincia::find($id)->delete();

        return redirect()->route('provincias.index')
            ->with('success', 'Provincia borrada exitosamente.');
    }

    public function getCantones($provinciaId) {
        
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
