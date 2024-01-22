<?php

namespace App\Http\Controllers;

use App\Models\Tmantenimiento;
use Illuminate\Http\Request;

/**
 * Class TmantenimientoController
 * @package App\Http\Controllers
 */
class TmantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tmantenimientos = Tmantenimiento::paginate(10);

        return view('tmantenimiento.index', compact('tmantenimientos'))
            ->with('i', (request()->input('page', 1) - 1) * $tmantenimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tmantenimiento = new Tmantenimiento();
        return view('tmantenimiento.create', compact('tmantenimiento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Tmantenimiento::$rules);

        $tmantenimiento = Tmantenimiento::create($request->all());

        return redirect()->route('tmantenimientos.index')
            ->with('success', 'Tipo de mantenimientocreado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tmantenimiento = Tmantenimiento::find($id);

        return view('tmantenimiento.show', compact('tmantenimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tmantenimiento = Tmantenimiento::find($id);

        return view('tmantenimiento.edit', compact('tmantenimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tmantenimiento $tmantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tmantenimiento $tmantenimiento)
    {
        request()->validate(Tmantenimiento::$rules);

        $tmantenimiento->update($request->all());

        return redirect()->route('tmantenimientos.index')
            ->with('success', 'Tipo de mantenimiento actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tmantenimiento = Tmantenimiento::find($id)->delete();

        return redirect()->route('tmantenimientos.index')
            ->with('success', 'Tipo de mantenimiento borrado exitosamente.');
    }
}
