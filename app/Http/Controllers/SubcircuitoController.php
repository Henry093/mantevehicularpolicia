<?php

namespace App\Http\Controllers;

use App\Models\Subcircuito;
use Illuminate\Http\Request;

/**
 * Class SubcircuitoController
 * @package App\Http\Controllers
 */
class SubcircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subcircuitos = Subcircuito::paginate(10);

        return view('subcircuito.index', compact('subcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $subcircuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcircuito = new Subcircuito();
        return view('subcircuito.create', compact('subcircuito'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Subcircuito::$rules);

        $subcircuito = Subcircuito::create($request->all());

        return redirect()->route('subcircuitos.index')
            ->with('success', 'Subcircuito created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcircuito = Subcircuito::find($id);

        return view('subcircuito.show', compact('subcircuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcircuito = Subcircuito::find($id);

        return view('subcircuito.edit', compact('subcircuito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Subcircuito $subcircuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcircuito $subcircuito)
    {
        request()->validate(Subcircuito::$rules);

        $subcircuito->update($request->all());

        return redirect()->route('subcircuitos.index')
            ->with('success', 'Subcircuito updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $subcircuito = Subcircuito::find($id)->delete();

        return redirect()->route('subcircuitos.index')
            ->with('success', 'Subcircuito deleted successfully');
    }
}
