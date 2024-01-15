<?php

namespace App\Http\Controllers;

use App\Models\Asignacione;
use Illuminate\Http\Request;

/**
 * Class AsignacioneController
 * @package App\Http\Controllers
 */
class AsignacioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asignaciones = Asignacione::paginate(10);

        return view('asignacione.index', compact('asignaciones'))
            ->with('i', (request()->input('page', 1) - 1) * $asignaciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asignacione = new Asignacione();
        return view('asignacione.create', compact('asignacione'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Asignacione::$rules);

        $asignacione = Asignacione::create($request->all());

        return redirect()->route('asignaciones.index')
            ->with('success', 'Asignaciones creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asignacione = Asignacione::find($id);

        return view('asignacione.show', compact('asignacione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asignacione = Asignacione::find($id);

        return view('asignacione.edit', compact('asignacione'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Asignacione $asignacione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignacione $asignacione)
    {
        request()->validate(Asignacione::$rules);

        $asignacione->update($request->all());

        return redirect()->route('asignaciones.index')
            ->with('success', 'Asignaciones actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $asignacione = Asignacione::find($id)->delete();

        return redirect()->route('asignaciones.index')
            ->with('success', 'Asignaciones borrado exitosamente.');
    }
}
