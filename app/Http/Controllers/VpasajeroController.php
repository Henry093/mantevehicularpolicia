<?php

namespace App\Http\Controllers;

use App\Models\Vpasajero;
use Illuminate\Http\Request;

/**
 * Class VpasajeroController
 * @package App\Http\Controllers
 */
class VpasajeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vpasajeros = Vpasajero::paginate(10);

        return view('vpasajero.index', compact('vpasajeros'))
            ->with('i', (request()->input('page', 1) - 1) * $vpasajeros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vpasajero = new Vpasajero();
        return view('vpasajero.create', compact('vpasajero'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Vpasajero::$rules);

        $vpasajero = Vpasajero::create($request->all());

        return redirect()->route('vpasajeros.index')
            ->with('success', 'Vpasajero created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vpasajero = Vpasajero::find($id);

        return view('vpasajero.show', compact('vpasajero'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vpasajero = Vpasajero::find($id);

        return view('vpasajero.edit', compact('vpasajero'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vpasajero $vpasajero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vpasajero $vpasajero)
    {
        request()->validate(Vpasajero::$rules);

        $vpasajero->update($request->all());

        return redirect()->route('vpasajeros.index')
            ->with('success', 'Vpasajero updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vpasajero = Vpasajero::find($id)->delete();

        return redirect()->route('vpasajeros.index')
            ->with('success', 'Vpasajero deleted successfully');
    }
}
