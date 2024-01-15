<?php

namespace App\Http\Controllers;

use App\Models\Emantenimiento;
use App\Models\Rmantenimiento;
use App\Models\Vsubcircuito;
use Illuminate\Http\Request;

/**
 * Class RmantenimientoController
 * @package App\Http\Controllers
 */
class RmantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rmantenimientos = Rmantenimiento::paginate(10);

        return view('rmantenimiento.index', compact('rmantenimientos'))
            ->with('i', (request()->input('page', 1) - 1) * $rmantenimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rmantenimiento = new Rmantenimiento();

        $dvsubcircuito = Vsubcircuito::all();
        $demantenimiento = Emantenimiento::all();
        return view('rmantenimiento.create', compact('rmantenimiento', 'dvsubcircuito', 'demantenimiento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Rmantenimiento::$rules);

        $rmantenimiento = Rmantenimiento::create($request->all());

        return redirect()->route('rmantenimientos.show',['id' => $rmantenimiento->id])
            ->with('success', 'Rmantenimiento created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rmantenimiento = Rmantenimiento::find($id);

        return view('rmantenimiento.show', compact('rmantenimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rmantenimiento = Rmantenimiento::find($id);

        $dvsubcircuito = Vsubcircuito::all();
        $demantenimiento = Emantenimiento::all();
        return view('rmantenimiento.edit', compact('rmantenimiento', 'dvsubcircuito', 'demantenimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Rmantenimiento $rmantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rmantenimiento $rmantenimiento)
    {
        request()->validate(Rmantenimiento::$rules);

        $rmantenimiento->update($request->all());

        return redirect()->route('rmantenimientos.index')
            ->with('success', 'Rmantenimiento updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $rmantenimiento = Rmantenimiento::find($id)->delete();

        return redirect()->route('rmantenimientos.index')
            ->with('success', 'Rmantenimiento deleted successfully');
    }
}
