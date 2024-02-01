<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\Mantenimiento;
use App\Models\Reclamo;
use App\Models\Subcircuito;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Vehientrega;
use App\Models\Vehirecepcione;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalDependencias = Subcircuito::count();
        $totalUsuarios = User::count();
        $totalVehiculos = Vehiculo::count();
        $totalMantenimientos = Mantenimiento::count();
        $totalRecepciones = Vehirecepcione::count();
        $totalEntregas = Vehientrega::count();
        $totalReclamos = Reclamo::count();

        return view('reporte.general', compact('totalDependencias',
            'totalUsuarios',
            'totalVehiculos',
            'totalMantenimientos',
            'totalRecepciones',
            'totalEntregas',
            'totalReclamos'
        ));

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
        //
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
}
