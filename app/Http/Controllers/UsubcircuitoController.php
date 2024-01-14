<?php

namespace App\Http\Controllers;

use App\Models\Usubcircuito;
use Illuminate\Http\Request;

/**
 * Class UsubcircuitoController
 * @package App\Http\Controllers
 */
class UsubcircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usubcircuitos = Usubcircuito::paginate(10);

        return view('usubcircuito.index', compact('usubcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $usubcircuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usubcircuito = new Usubcircuito();
        return view('usubcircuito.create', compact('usubcircuito'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Usubcircuito::$rules);

        $usubcircuito = Usubcircuito::create($request->all());

        return redirect()->route('usubcircuitos.index')
            ->with('success', 'Usubcircuito created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usubcircuito = Usubcircuito::find($id);

        return view('usubcircuito.show', compact('usubcircuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usubcircuito = Usubcircuito::find($id);

        return view('usubcircuito.edit', compact('usubcircuito'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Usubcircuito $usubcircuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usubcircuito $usubcircuito)
    {
        request()->validate(Usubcircuito::$rules);

        $usubcircuito->update($request->all());

        return redirect()->route('usubcircuitos.index')
            ->with('success', 'Usubcircuito updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $usubcircuito = Usubcircuito::find($id)->delete();

        return redirect()->route('usubcircuitos.index')
            ->with('success', 'Usubcircuito deleted successfully');
    }
}
