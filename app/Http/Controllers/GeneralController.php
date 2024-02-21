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
    public function __construct()
    {
        // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
        $this->middleware('can:general.index')->only('index');
        $this->middleware('can:general.create')->only('create', 'store');
        $this->middleware('can:general.edit')->only('edit', 'update');
        $this->middleware('can:general.show')->only('show');
        $this->middleware('can:general.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener el total de dependencias, usuarios, vehículos, mantenimientos, recepciones, entregas y reclamos
        $totalDependencias = Subcircuito::count();
        $totalUsuarios = User::count();
        $totalVehiculos = Vehiculo::count();
        $totalMantenimientos = Mantenimiento::count();
        $totalRecepciones = Vehirecepcione::count();
        $totalEntregas = Vehientrega::count();
        $totalReclamos = Reclamo::count();

        // Devolver la vista con los totales de cada recurso
        return view('reporte.general.general', compact('totalDependencias',
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
