<?php

namespace App\Http\Controllers;

use App\Models\Vehientrega;
use Illuminate\Http\Request;

/**
 * Class VehientregaController
 * @package App\Http\Controllers
 */
class VehientregaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehientregas = Vehientrega::paginate(10);

        return view('vehientrega.index', compact('vehientregas'))
            ->with('i', (request()->input('page', 1) - 1) * $vehientregas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehientrega = new Vehientrega();
        return view('vehientrega.create', compact('vehientrega'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Vehientrega::$rules);

        $vehientrega = Vehientrega::create($request->all());

        return redirect()->route('vehientregas.index')
            ->with('success', 'Vehientrega created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehientrega = Vehientrega::find($id);

        return view('vehientrega.show', compact('vehientrega'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehientrega = Vehientrega::find($id);

        return view('vehientrega.edit', compact('vehientrega'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehientrega $vehientrega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehientrega $vehientrega)
    {
        request()->validate(Vehientrega::$rules);

        $vehientrega->update($request->all());

        return redirect()->route('vehientregas.index')
            ->with('success', 'Vehientrega updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehientrega = Vehientrega::find($id)->delete();

        return redirect()->route('vehientregas.index')
            ->with('success', 'Vehientrega deleted successfully');
    }
}
