<?php

namespace App\Http\Controllers;

use App\Models\Tvehiculo;
use Illuminate\Http\Request;

/**
 * Class TvehiculoController
 * @package App\Http\Controllers
 */
class TvehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tvehiculos = Tvehiculo::paginate(10);

        return view('tvehiculo.index', compact('tvehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $tvehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tvehiculo = new Tvehiculo();
        return view('tvehiculo.create', compact('tvehiculo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Tvehiculo::$rules);

        $tvehiculo = Tvehiculo::create($request->all());

        return redirect()->route('tvehiculos.index')
            ->with('success', 'Tipo de vehículo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tvehiculo = Tvehiculo::find($id);

        return view('tvehiculo.show', compact('tvehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tvehiculo = Tvehiculo::find($id);

        return view('tvehiculo.edit', compact('tvehiculo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tvehiculo $tvehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tvehiculo $tvehiculo)
    {
        request()->validate(Tvehiculo::$rules);

        $tvehiculo->update($request->all());

        return redirect()->route('tvehiculos.index')
            ->with('success', 'Tipo de vehículo actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tvehiculo = Tvehiculo::find($id)->delete();

        return redirect()->route('tvehiculos.index')
            ->with('success', 'Tipo de vehículo borrado exitosamente.');
    }
}
