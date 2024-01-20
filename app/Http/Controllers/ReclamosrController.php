<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Reclamo;
use App\Models\Subcircuito;
use Illuminate\Http\Request;
use App\Models\Circuito;
use App\Models\Treclamo;

class ReclamosrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reclamos = Reclamo::paginate(20);

        return view('reclamo.reporteReclamo', compact('reclamos'))
        ->with('i', (request()->input('page', 1) - 1) * $reclamos->perPage());;
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

    public function filtro(Request $request){

        $fechaIni = $request->fechaIni;
        $fechaFin = $request->fechaFin;
    
        $reclamos = Reclamo::whereDate('created_at', '>=', $fechaIni)
                            ->whereDate('created_at', '<=', $fechaFin)
                            ->select('treclamo_id', 'circuito_id', 'subcircuito_id', DB::raw('count(*) as total'))
                            ->groupBy('treclamo_id', 'circuito_id', 'subcircuito_id')
                            ->paginate(10);
    
            return view('reclamo.reporteReclamo', compact('reclamos'))
            ->with('i', (request()->input('page', 1) - 1) * $reclamos->perPage());;
        

    }

}
