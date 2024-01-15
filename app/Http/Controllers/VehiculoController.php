<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tvehiculo;
use App\Models\Vcarga;
use App\Models\Vehiculo;
use App\Models\Vpasajero;
use Illuminate\Http\Request;

/**
 * Class VehiculoController
 * @package App\Http\Controllers
 */
class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiculos = Vehiculo::paginate(10);

        return view('vehiculo.index', compact('vehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $vehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehiculo = new Vehiculo();
        $dvehiculo = Tvehiculo::all();
        $dmarca = Marca::all();
        $dmodelo = Modelo::all();
        $dcarga = Vcarga::all();
        $dpasajero = Vpasajero::all();
        $destado = Estado::all();

        return view('vehiculo.create', compact('vehiculo', 'dvehiculo', 'dmarca', 'dmodelo', 'dcarga', 'dpasajero', 'destado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Vehiculo::$rules);

        $vehiculo = Vehiculo::create($request->all());

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehiculo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehiculo = Vehiculo::find($id);

        return view('vehiculo.show', compact('vehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehiculo = Vehiculo::find($id);
        $dvehiculo = Tvehiculo::all();
        $dmarca = Marca::all();
        $dmodelo = Modelo::all();
        $dcarga = Vcarga::all();
        $dpasajero = Vpasajero::all();
        $destado = Estado::all();

        return view('vehiculo.edit', compact('vehiculo', 'dvehiculo', 'dmarca', 'dmodelo', 'dcarga', 'dpasajero', 'destado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehiculo $vehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehiculo $vehiculo)
    {
        request()->validate(Vehiculo::$rules);

        $vehiculo->update($request->all());

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehiculo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehiculo = Vehiculo::find($id)->delete();

        return redirect()->route('vehiculos.index')
            ->with('success', 'Vehiculo deleted successfully');
    }
}
