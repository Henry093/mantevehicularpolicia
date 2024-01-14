<?php

namespace App\Http\Controllers;

use App\Models\Circuito;
use App\Models\Distrito;
use Illuminate\Http\Request;

/**
 * Class CircuitoController
 * @package App\Http\Controllers
 */
class CircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $circuitos = Circuito::paginate(10);

        return view('circuito.index', compact('circuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $circuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $circuito = new Circuito();

        $distritos = Distrito::all();
        return view('circuito.create', compact('circuito', 'distritos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Circuito::$rules);

        $circuito = Circuito::create($request->all());

        return redirect()->route('circuitos.index')
            ->with('success', 'Circuito created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $circuito = Circuito::find($id);

        return view('circuito.show', compact('circuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $circuito = Circuito::find($id);
        $distritos = Distrito::all();

        return view('circuito.edit', compact('circuito', 'distritos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Circuito $circuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circuito $circuito)
    {
        request()->validate(Circuito::$rules);

        $circuito->update($request->all());

        return redirect()->route('circuitos.index')
            ->with('success', 'Circuito updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $circuito = Circuito::find($id)->delete();

        return redirect()->route('circuitos.index')
            ->with('success', 'Circuito deleted successfully');
    }
}
