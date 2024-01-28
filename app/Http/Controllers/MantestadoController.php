<?php

namespace App\Http\Controllers;

use App\Models\Mantestado;
use Illuminate\Http\Request;

/**
 * Class MantestadoController
 * @package App\Http\Controllers
 */
class MantestadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mantestados = Mantestado::paginate(10);

        return view('mantestado.index', compact('mantestados'))
            ->with('i', (request()->input('page', 1) - 1) * $mantestados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mantestado = new Mantestado();
        return view('mantestado.create', compact('mantestado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Mantestado::$rules);

        $mantestado = Mantestado::create($request->all());

        return redirect()->route('mantestados.index')
            ->with('success', 'Mantestado created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mantestado = Mantestado::find($id);

        return view('mantestado.show', compact('mantestado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mantestado = Mantestado::find($id);

        return view('mantestado.edit', compact('mantestado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantestado $mantestado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantestado $mantestado)
    {
        request()->validate(Mantestado::$rules);

        $mantestado->update($request->all());

        return redirect()->route('mantestados.index')
            ->with('success', 'Mantestado updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mantestado = Mantestado::find($id)->delete();

        return redirect()->route('mantestados.index')
            ->with('success', 'Mantestado deleted successfully');
    }
}
