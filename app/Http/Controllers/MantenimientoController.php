<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Mantestado;
use Illuminate\Http\Request;

/**
 * Class MantenimientoController
 * @package App\Http\Controllers
 */
class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mantenimientos = Mantenimiento::paginate(10);

        return view('mantenimiento.index', compact('mantenimientos'))
            ->with('i', (request()->input('page', 1) - 1) * $mantenimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtener información del usuario logeado
        $user = auth()->user();

        $mantenimiento = new Mantenimiento();
        $d_mantestado = Mantestado::all();
        $edicion = false;


        return view('mantenimiento.create', compact('mantenimiento', 'd_mantestado', 'user', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Mantenimiento::$rules);

        $estado = $request->input('mantestado_id');

        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['mantestado_id' => '1']);
        }

        $mantenimiento = Mantenimiento::create($request->all());

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mantenimiento = Mantenimiento::find($id);

        return view('mantenimiento.show', compact('mantenimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $d_mantestado = Mantestado::all();

        return view('mantenimiento.edit', compact('mantenimiento', 'd_mantestado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantenimiento $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        request()->validate(Mantenimiento::$rules);

        $mantenimiento->update($request->all());

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mantenimiento = Mantenimiento::find($id)->delete();

        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento deleted successfully');
    }
}
