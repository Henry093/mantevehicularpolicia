<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Cantone;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Http\Request;

/**
 * Class ParroquiaController
 * @package App\Http\Controllers
 */
class ParroquiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parroquias = Parroquia::paginate(10);

        return view('parroquia.index', compact('parroquias'))
            ->with('i', (request()->input('page', 1) - 1) * $parroquias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parroquia = new Parroquia();

        $dprovincias = Provincia::all();
        $dcantons = Canton::all();
        return view('parroquia.create', compact('parroquia', 'dprovincias', 'dcantons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Parroquia::$rules);

        $parroquia = Parroquia::create($request->all());

        return redirect()->route('parroquias.index')
            ->with('success', 'Parroquia created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parroquia = Parroquia::find($id);

        return view('parroquia.show', compact('parroquia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parroquia = Parroquia::find($id);
        $dprovincias = Provincia::all();
        $dcantons = Canton::all();

        return view('parroquia.edit', compact('parroquia', 'dprovincias', 'dcantons'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Parroquia $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parroquia $parroquia)
    {
        request()->validate(Parroquia::$rules);

        $parroquia->update($request->all());

        return redirect()->route('parroquias.index')
            ->with('success', 'Parroquia updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $parroquia = Parroquia::find($id)->delete();

        return redirect()->route('parroquias.index')
            ->with('success', 'Parroquia deleted successfully');
    }

    public function getCantones($provinciaId) {
        $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
        return response()->json($cantones);
    }
}
