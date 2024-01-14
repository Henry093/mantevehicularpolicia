<?php

namespace App\Http\Controllers;

use App\Models\Emantenimiento;
use Illuminate\Http\Request;

/**
 * Class EmantenimientoController
 * @package App\Http\Controllers
 */
class EmantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emantenimientos = Emantenimiento::paginate(10);

        return view('emantenimiento.index', compact('emantenimientos'))
            ->with('i', (request()->input('page', 1) - 1) * $emantenimientos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $emantenimiento = new Emantenimiento();
        return view('emantenimiento.create', compact('emantenimiento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Emantenimiento::$rules);

        $emantenimiento = Emantenimiento::create($request->all());

        return redirect()->route('emantenimientos.index')
            ->with('success', 'Emantenimiento created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $emantenimiento = Emantenimiento::find($id);

        return view('emantenimiento.show', compact('emantenimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emantenimiento = Emantenimiento::find($id);

        return view('emantenimiento.edit', compact('emantenimiento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Emantenimiento $emantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emantenimiento $emantenimiento)
    {
        request()->validate(Emantenimiento::$rules);

        $emantenimiento->update($request->all());

        return redirect()->route('emantenimientos.index')
            ->with('success', 'Emantenimiento updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $emantenimiento = Emantenimiento::find($id)->delete();

        return redirect()->route('emantenimientos.index')
            ->with('success', 'Emantenimiento deleted successfully');
    }
}
