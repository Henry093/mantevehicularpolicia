<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Distrito;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Http\Request;

/**
 * Class DistritoController
 * @package App\Http\Controllers
 */
class DistritoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $distritos = Distrito::paginate(10);

        return view('distrito.index', compact('distritos'))
            ->with('i', (request()->input('page', 1) - 1) * $distritos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distrito = new Distrito();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        return view('distrito.create', compact('distrito', 'd_provincia', 'd_canton', 'd_parroquia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Distrito::$rules);

        $distrito = Distrito::create($request->all());

        return redirect()->route('distritos.index')
            ->with('success', 'Distrito created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $distrito = Distrito::find($id);

        return view('distrito.show', compact('distrito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $distrito = Distrito::find($id);
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();

        return view('distrito.edit', compact('distrito', 'd_provincia', 'd_canton', 'd_parroquia'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Distrito $distrito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distrito $distrito)
    {
        request()->validate(Distrito::$rules);

        $distrito->update($request->all());

        return redirect()->route('distritos.index')
            ->with('success', 'Distrito updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $distrito = Distrito::find($id)->delete();

        return redirect()->route('distritos.index')
            ->with('success', 'Distrito deleted successfully');
    }
    public function getCantones($provinciaId) {
        $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
        return response()->json($cantones);
    }
}
