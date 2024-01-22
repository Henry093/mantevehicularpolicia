<?php

namespace App\Http\Controllers;

use App\Models\Sangre;
use Illuminate\Http\Request;

/**
 * Class SangreController
 * @package App\Http\Controllers
 */
class SangreController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:sangres.index')->only('index');
        $this->middleware('can:sangres.create')->only('create', 'store');
        $this->middleware('can:sangres.edit')->only('edit', 'update');
        $this->middleware('can:sangres.show')->only('show');
        $this->middleware('can:sangres.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sangres = Sangre::paginate(10);

        return view('sangre.index', compact('sangres'))
            ->with('i', (request()->input('page', 1) - 1) * $sangres->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sangre = new Sangre();
        return view('sangre.create', compact('sangre'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Sangre::$rules);

        $sangre = Sangre::create($request->all());

        return redirect()->route('sangres.index')
            ->with('success', 'Sangre creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sangre = Sangre::find($id);

        return view('sangre.show', compact('sangre'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sangre = Sangre::find($id);

        return view('sangre.edit', compact('sangre'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Sangre $sangre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sangre $sangre)
    {
        request()->validate(Sangre::$rules);

        $sangre->update($request->all());

        return redirect()->route('sangres.index')
            ->with('success', 'Sangre actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $sangre = Sangre::find($id)->delete();

        return redirect()->route('sangres.index')
            ->with('success', 'Sangre borrado exitosamente.');
    }
}
