<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Dependencia;
use App\Models\Distrito;
use App\Models\Estado;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use Illuminate\Http\Request;

/**
 * Class DependenciaController
 * @package App\Http\Controllers
 */
class DependenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dependencias = Dependencia::paginate(10);

        return view('dependencia.index', compact('dependencias'))
            ->with('i', (request()->input('page', 1) - 1) * $dependencias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dependencia = new Dependencia();
        $dprovincia = Provincia::all();
        $dcanton = Canton::all();
        $dparroquia = Parroquia::all();
        $ddistrito = Distrito::all();
        $dcircuito = Circuito::all();
        $dsubcircuito = Subcircuito::all();
        $destado = Estado::all();

        return view('dependencia.create', compact('dependencia', 'dprovincia', 'dcanton', 'dparroquia', 'ddistrito', 'dcircuito', 'dsubcircuito', 'destado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Dependencia::$rules);

        $dependencia = Dependencia::create($request->all());

        return redirect()->route('dependencias.index')
            ->with('success', 'Dependencia created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $dependencia = Dependencia::find($id);

        return view('dependencia.show', compact('dependencia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $dependencia = Dependencia::find($id);
        $dprovincia = Provincia::all();
        $dcanton = Canton::all();
        $dparroquia = Parroquia::all();
        $ddistrito = Distrito::all();
        $dcircuito = Circuito::all();
        $dsubcircuito = Subcircuito::all();
        $destado = Estado::all();

        return view('dependencia.edit', compact('dependencia', 'dprovincia', 'dcanton', 'dparroquia', 'ddistrito', 'dcircuito', 'dsubcircuito', 'destado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Dependencia $dependencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dependencia $dependencia)
    {
        request()->validate(Dependencia::$rules);

        $dependencia->update($request->all());

        return redirect()->route('dependencias.index')
            ->with('success', 'Dependencia updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $dependencia = Dependencia::find($id)->delete();

        return redirect()->route('dependencias.index')
            ->with('success', 'Dependencia deleted successfully');
    }
}
