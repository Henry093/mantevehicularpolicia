<?php

namespace App\Http\Controllers;

use App\Models\Dependencia;
use App\Models\Reclamo;
use App\Models\Rmantenimiento;
use App\Models\Subcircuito;
use App\Models\User;
use App\Models\Vehiculo;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalDependencias = Subcircuito::count();
        $totalUsuarios = User::count();
        $totalVehiculos = Vehiculo::count();
        $totalReclamos = Reclamo::count();
        
        return view('home', compact('totalDependencias', 'totalUsuarios', 'totalVehiculos', 'totalReclamos'));
    }
}
