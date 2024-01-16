<?php

namespace App\Http\Controllers;

use App\Models\Circuito;
use App\Models\Reclamo;
use App\Models\Subcircuito;
use App\Models\Treclamo;
use Illuminate\Http\Request;

class FormularioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $reclamos = Reclamo::all();
    $dcircuito = Circuito::all();
    $dsubcircuito = Subcircuito::all();
    $dtreclamo = Treclamo::all();

    // Crear un objeto Reclamo vacío
    $reclamo = new Reclamo();

    return view('reclamo.indexPublic', compact('reclamos', 'dcircuito', 'dsubcircuito', 'dtreclamo', 'reclamo'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $reclamo = new Reclamo();

        $reclamo->circuito_id = $request->circuito_id;
        $reclamo->subcircuito_id = $request->subcircuito_id;
        $reclamo->treclamo_id = $request->treclamo_id;
        $reclamo->detalle = $request->detalle;
        $reclamo->contacto = $request->contacto;
        $reclamo->apellidos = $request->apellidos;
        $reclamo->nombres = $request->nombres;

        $reclamo->save();

        return redirect()->route('reclamo.indexPublic')
                ->with('success', 'Información enviada correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getSubcircuitos($circuitoId) {
        $subcircuitos = Subcircuito::where('circuito_id', $circuitoId)->pluck('nombre', 'id')->toArray();
        return response()->json($subcircuitos);
    }
    
}
