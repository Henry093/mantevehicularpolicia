<?php

namespace App\Http\Controllers;

use App\Models\Vsubcircuito;
use Illuminate\Http\Request;

/**
 * Class VsubcircuitoController
 * @package App\Http\Controllers
 */
class VsubcircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vsubcircuitos = Vsubcircuito::paginate(10);

        return view('vsubcircuito.index', compact('vsubcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $vsubcircuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vsubcircuito = new Vsubcircuito();
        return view('vsubcircuito.create', compact('vsubcircuito'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Vsubcircuito::$rules);

        $vsubcircuito = Vsubcircuito::create($request->all());

        return redirect()->route('vsubcircuitos.index')
            ->with('success', 'Vsubcircuito created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vsubcircuito = Vsubcircuito::find($id);

        return view('vsubcircuito.show', compact('vsubcircuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vsubcircuito = Vsubcircuito::find($id);

        return view('vsubcircuito.edit', compact('vsubcircuito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vsubcircuito $vsubcircuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vsubcircuito $vsubcircuito)
    {
        request()->validate(Vsubcircuito::$rules);

        $vsubcircuito->update($request->all());

        return redirect()->route('vsubcircuitos.index')
            ->with('success', 'Vsubcircuito updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vsubcircuito = Vsubcircuito::find($id)->delete();

        return redirect()->route('vsubcircuitos.index')
            ->with('success', 'Vsubcircuito deleted successfully');
    }
}
