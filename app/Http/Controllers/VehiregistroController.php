<?php

namespace App\Http\Controllers;

use App\Models\Vehiregistro;
use Illuminate\Http\Request;

/**
 * Class VehiregistroController
 * @package App\Http\Controllers
 */
class VehiregistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiregistros = Vehiregistro::paginate(10);

        return view('vehiregistro.index', compact('vehiregistros'))
            ->with('i', (request()->input('page', 1) - 1) * $vehiregistros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehiregistro = new Vehiregistro();
        return view('vehiregistro.create', compact('vehiregistro'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Vehiregistro::$rules);

        $vehiregistro = Vehiregistro::create($request->all());

        return redirect()->route('vehiregistros.index')
            ->with('success', 'Vehiregistro created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehiregistro = Vehiregistro::find($id);

        return view('vehiregistro.show', compact('vehiregistro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehiregistro = Vehiregistro::find($id);

        return view('vehiregistro.edit', compact('vehiregistro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehiregistro $vehiregistro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehiregistro $vehiregistro)
    {
        request()->validate(Vehiregistro::$rules);

        $vehiregistro->update($request->all());

        return redirect()->route('vehiregistros.index')
            ->with('success', 'Vehiregistro updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehiregistro = Vehiregistro::find($id)->delete();

        return redirect()->route('vehiregistros.index')
            ->with('success', 'Vehiregistro deleted successfully');
    }
}
