<?php

namespace App\Http\Controllers;

use App\Models\Novedade;
use Illuminate\Http\Request;

/**
 * Class NovedadeController
 * @package App\Http\Controllers
 */
class NovedadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $novedades = Novedade::paginate(10);

        return view('novedade.index', compact('novedades'))
            ->with('i', (request()->input('page', 1) - 1) * $novedades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $novedade = new Novedade();
        return view('novedade.create', compact('novedade'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Novedade::$rules);

        $novedade = Novedade::create($request->all());

        return redirect()->route('novedades.index')
            ->with('success', 'Novedade created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $novedade = Novedade::find($id);

        return view('novedade.show', compact('novedade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $novedade = Novedade::find($id);

        return view('novedade.edit', compact('novedade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Novedade $novedade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Novedade $novedade)
    {
        request()->validate(Novedade::$rules);

        $novedade->update($request->all());

        return redirect()->route('novedades.index')
            ->with('success', 'Novedade updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $novedade = Novedade::find($id)->delete();

        return redirect()->route('novedades.index')
            ->with('success', 'Novedade deleted successfully');
    }
}
