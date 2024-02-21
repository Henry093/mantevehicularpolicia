<?php

namespace App\Http\Controllers;

use App\Models\Vehieliminacion;
use Illuminate\Http\Request;

/**
 * Class VehieliminacionController
 * @package App\Http\Controllers
 */
class VehieliminacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vehieliminacions.index')->only('index');
        $this->middleware('can:vehieliminacions.create')->only('create', 'store');
        $this->middleware('can:vehieliminacions.edit')->only('edit', 'update');
        $this->middleware('can:vehieliminacions.show')->only('show');
        $this->middleware('can:vehieliminacions.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Vehieliminacion::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('placa', 'like', '%' . $search . '%')
                    ->orWhere('chasis', 'like', '%' . $search . '%')
                    ->orWhere('motor', 'like', '%' . $search . '%')
                    ->orWhere('motivo', 'like', '%' . $search . '%');
            });
        }
    
        $vehieliminacions = $query->paginate(10);
    
        return view('vehieliminacion.index', compact('vehieliminacions'))
            ->with('i', (request()->input('page', 1) - 1) * $vehieliminacions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehieliminacion = Vehieliminacion::find($id);

        return view('vehieliminacion.show', compact('vehieliminacion'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehieliminacion $vehieliminacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehieliminacion $vehieliminacion)
    {
        //
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        //
    }
}
