<?php

namespace App\Http\Controllers;

use App\Models\Nmantenimiento;
use Illuminate\Http\Request;

/**
 * Class NmantenimientoController
 * @package App\Http\Controllers
 */
class NmantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nmantenimientos = Nmantenimiento::paginate(10);

        return view('nmantenimiento.index', compact('nmantenimientos'))
            ->with('i', (request()->input('page', 1) - 1) * $nmantenimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $nmantenimiento = new Nmantenimiento();
        return view('nmantenimiento.create', compact('nmantenimiento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Nmantenimiento::$rules);

        $nmantenimiento = Nmantenimiento::create($request->all());

        return redirect()->route('nmantenimientos.index')
            ->with('success', 'Nmantenimiento created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $nmantenimiento = Nmantenimiento::find($id);

        return view('nmantenimiento.show', compact('nmantenimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $nmantenimiento = Nmantenimiento::find($id);

        return view('nmantenimiento.edit', compact('nmantenimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Nmantenimiento $nmantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nmantenimiento $nmantenimiento)
    {
        request()->validate(Nmantenimiento::$rules);

        $nmantenimiento->update($request->all());

        return redirect()->route('nmantenimientos.index')
            ->with('success', 'Nmantenimiento updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $nmantenimiento = Nmantenimiento::find($id)->delete();

        return redirect()->route('nmantenimientos.index')
            ->with('success', 'Nmantenimiento deleted successfully');
    }
}
