<?php

namespace App\Http\Controllers;

use App\Models\Treclamo;
use Illuminate\Http\Request;

/**
 * Class TreclamoController
 * @package App\Http\Controllers
 */
class TreclamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $treclamos = Treclamo::paginate(10);

        return view('treclamo.index', compact('treclamos'))
            ->with('i', (request()->input('page', 1) - 1) * $treclamos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $treclamo = new Treclamo();
        return view('treclamo.create', compact('treclamo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Treclamo::$rules);

        $treclamo = Treclamo::create($request->all());

        return redirect()->route('treclamos.index')
            ->with('success', 'Treclamo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $treclamo = Treclamo::find($id);

        return view('treclamo.show', compact('treclamo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $treclamo = Treclamo::find($id);

        return view('treclamo.edit', compact('treclamo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Treclamo $treclamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treclamo $treclamo)
    {
        request()->validate(Treclamo::$rules);

        $treclamo->update($request->all());

        return redirect()->route('treclamos.index')
            ->with('success', 'Treclamo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $treclamo = Treclamo::find($id)->delete();

        return redirect()->route('treclamos.index')
            ->with('success', 'Treclamo deleted successfully');
    }
}
