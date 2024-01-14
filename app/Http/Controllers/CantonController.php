<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Http\Request;

/**
 * Class CantonController
 * @package App\Http\Controllers
 */
class CantonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cantons = Canton::paginate(10);

        return view('canton.index', compact('cantons'))
            ->with('i', (request()->input('page', 1) - 1) * $cantons->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $canton = new Canton();
        $provincias = Provincia::all();
        return view('canton.create', compact('canton', 'provincias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Canton::$rules);

        $canton = Canton::create($request->all());

        return redirect()->route('cantons.index')
            ->with('success', 'Canton created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $canton = Canton::find($id);

        return view('canton.show', compact('canton'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $canton = Canton::find($id);
        $provincias = Provincia::all();

        return view('canton.edit', compact('canton', 'provincias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Canton $canton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Canton $canton)
    {
        request()->validate(Canton::$rules);

        $canton->update($request->all());

        return redirect()->route('cantons.index')
            ->with('success', 'Canton updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $canton = Canton::find($id)->delete();

        return redirect()->route('cantons.index')
            ->with('success', 'Canton deleted successfully');
    }
}
