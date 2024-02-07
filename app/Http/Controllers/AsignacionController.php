<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use Illuminate\Http\Request;

/**
 * Class AsignacionController
 * @package App\Http\Controllers
 */
class AsignacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:asignacions.index')->only('index');
        $this->middleware('can:asignacions.create')->only('create', 'store');
        $this->middleware('can:asignacions.edit')->only('edit', 'update');
        $this->middleware('can:asignacions.show')->only('show');
        $this->middleware('can:asignacions.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');
        $query = Asignacion::query();

        if($search){
            $query->where('nombre', 'like', '%' . $search . '%');
        }

        $asignacions = $query->paginate(12);

        return view('asignacion.index', compact('asignacions'))
            ->with('i', (request()->input('page', 1) - 1) * $asignacions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asignacion = new Asignacion();
        return view('asignacion.create', compact('asignacion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Asignacion::$rules);

        $asignacion = Asignacion::create($request->all());

        return redirect()->route('asignacions.index')
            ->with('success', 'Asignacion creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asignacion = Asignacion::find($id);

        return view('asignacion.show', compact('asignacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asignacion = Asignacion::find($id);

        return view('asignacion.edit', compact('asignacion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Asignacion $asignacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignacion $asignacion)
    {
        request()->validate(Asignacion::$rules);

        $asignacion->update($request->all());

        return redirect()->route('asignacions.index')
            ->with('success', 'Asignacion actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $asignacion = Asignacion::find($id)->delete();

        return redirect()->route('asignacions.index')
            ->with('success', 'Asignacion borrado exitosamente');
    }
}
