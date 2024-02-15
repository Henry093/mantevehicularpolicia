<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Subcircuito;
use App\Models\Vehiculo;
use App\Models\Vehientrega;
use App\Models\Vehirecepcione;
use App\Models\User;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $view = $request->get('view');
    
        switch ($view) {
            case 'personas':
                $data = User::paginate(10);
                break;
            case 'vehiculos':
                $data = Vehiculo::paginate(10);
                break;
            case 'mantenimientos':
                $data = Mantenimiento::paginate(10);
                break;
            case 'recepciones':
                $data = Vehirecepcione::paginate(10);
                break;
            case 'entregas':
                $data = Vehientrega::paginate(10);
                break;
            default:
                $data = Subcircuito::paginate(10); // Por defecto, mostrar dependencias
                break;
        }
    
        return view('reporte.index', compact('data', 'view'));
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
