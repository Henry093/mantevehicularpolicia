<?php

namespace App\Http\Controllers;

use App\Models\Evehiculo;
use App\Models\Rmantenimiento;
use App\Models\Rvehiculo;
use Illuminate\Http\Request;

/**
 * Class EvehiculoController
 * @package App\Http\Controllers
 */
class EvehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evehiculos = Evehiculo::paginate(10);

        return view('evehiculo.index', compact('evehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $evehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $evehiculo = new Evehiculo();
        $drmantenimiento = Rmantenimiento::all();
        $drvehiculo = Rvehiculo::all();
        return view('evehiculo.create', compact('evehiculo', 'drmantenimiento', 'drvehiculo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Evehiculo::$rules);

        $evehiculo = Evehiculo::create($request->all());

        return redirect()->route('evehiculos.index')
            ->with('success', 'Evehiculo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evehiculo = Evehiculo::find($id);

        return view('evehiculo.show', compact('evehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $evehiculo = Evehiculo::find($id);
        $drmantenimiento = Rmantenimiento::all();
        $drvehiculo = Rvehiculo::all();
        return view('evehiculo.edit', compact('evehiculo', 'drmantenimiento', 'drvehiculo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Evehiculo $evehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evehiculo $evehiculo)
    {
        request()->validate(Evehiculo::$rules);

        $evehiculo->update($request->all());

        return redirect()->route('evehiculos.index')
            ->with('success', 'Evehiculo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $evehiculo = Evehiculo::find($id)->delete();

        return redirect()->route('evehiculos.index')
            ->with('success', 'Evehiculo deleted successfully');
    }
}
