<?php

namespace App\Http\Controllers;

use App\Models\Circuito;
use App\Models\Reclamo;
use App\Models\Subcircuito;
use App\Models\Treclamo;
use Illuminate\Http\Request;

/**
 * Class ReclamoController
 * @package App\Http\Controllers
 */
class ReclamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reclamos = Reclamo::paginate(14);

        return view('reclamo.index', compact('reclamos'))
            ->with('i', (request()->input('page', 1) - 1) * $reclamos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reclamo = new Reclamo();
        $dcircuito = Circuito::all();
        $dsubcircuito = Subcircuito::all();
        $dtreclamo = Treclamo::all();
        return view('reclamo.create', compact('reclamo', 'dcircuito','dsubcircuito','dtreclamo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Reclamo::$rules);

        $reclamo = Reclamo::create($request->all());

        return redirect()->route('reclamos.index')
            ->with('success', 'Reclamo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $reclamo = Reclamo::find($id);

        return view('reclamo.show', compact('reclamo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reclamo = Reclamo::find($id);
        $dcircuito = Circuito::all();
        $dsubcircuito = Subcircuito::all();
        $dtreclamo = Treclamo::all();

        return view('reclamo.edit', compact('reclamo', 'dcircuito','dsubcircuito','dtreclamo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Reclamo $reclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reclamo $reclamo)
    {
        request()->validate(Reclamo::$rules);

        $reclamo->update($request->all());

        return redirect()->route('reclamos.index')
            ->with('success', 'Reclamo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $reclamo = Reclamo::find($id)->delete();

        return redirect()->route('reclamos.index')
            ->with('success', 'Reclamo deleted successfully');
    }

    
}
