<?php

namespace App\Http\Controllers;

use App\Models\Rmantenimiento;
use App\Models\Rvehiculo;
use App\Models\Tmantenimiento;
use Illuminate\Http\Request;

/**
 * Class RvehiculoController
 * @package App\Http\Controllers
 */
class RvehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rvehiculos = Rvehiculo::paginate(10);

        return view('rvehiculo.index', compact('rvehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $rvehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rvehiculo = new Rvehiculo();
        $rmantenimientos = Rmantenimiento::all();
        $tmantenimientos = Tmantenimiento::all();
        return view('rvehiculo.create', compact('rvehiculo', 'rmantenimientos', 'tmantenimientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Rvehiculo::$rules);

        $rvehiculo = Rvehiculo::create($request->all());

        return redirect()->route('rvehiculos.index')
            ->with('success', 'Rvehiculo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rvehiculo = Rvehiculo::find($id);

        return view('rvehiculo.show', compact('rvehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rvehiculo = Rvehiculo::find($id);
        $rmantenimientos = Rmantenimiento::all();
        $tmantenimientos = Tmantenimiento::all();

        return view('rvehiculo.edit', compact('rvehiculo', 'rmantenimientos', 'tmantenimientos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Rvehiculo $rvehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rvehiculo $rvehiculo)
    {
        request()->validate(Rvehiculo::$rules);

        $rvehiculo->update($request->all());

        return redirect()->route('rvehiculos.index')
            ->with('success', 'Rvehiculo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $rvehiculo = Rvehiculo::find($id)->delete();

        return redirect()->route('rvehiculos.index')
            ->with('success', 'Rvehiculo deleted successfully');
    }
}
