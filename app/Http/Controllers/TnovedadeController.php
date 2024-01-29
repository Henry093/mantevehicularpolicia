<?php

namespace App\Http\Controllers;

use App\Models\Tnovedade;
use Illuminate\Http\Request;

/**
 * Class TnovedadeController
 * @package App\Http\Controllers
 */
class TnovedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tnovedades = Tnovedade::paginate(10);

        return view('tnovedade.index', compact('tnovedades'))
            ->with('i', (request()->input('page', 1) - 1) * $tnovedades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tnovedade = new Tnovedade();
        return view('tnovedade.create', compact('tnovedade'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Tnovedade::$rules);

        $tnovedade = Tnovedade::create($request->all());

        return redirect()->route('tnovedades.index')
            ->with('success', 'Tipo de novedad creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tnovedade = Tnovedade::find($id);

        return view('tnovedade.show', compact('tnovedade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tnovedade = Tnovedade::find($id);

        return view('tnovedade.edit', compact('tnovedade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tnovedade $tnovedade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tnovedade $tnovedade)
    {
        request()->validate(Tnovedade::$rules);

        $tnovedade->update($request->all());

        return redirect()->route('tnovedades.index')
            ->with('success', 'Tipo de novedad actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tnovedade = Tnovedade::find($id)->delete();

        return redirect()->route('tnovedades.index')
            ->with('success', 'Tipo de novedad borrado exitosamente.');
    }
}
