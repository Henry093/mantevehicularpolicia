<?php

namespace App\Http\Controllers;

use App\Models\Pertrecho;
use App\Models\Tpertrecho;
use Illuminate\Http\Request;

/**
 * Class PertrechoController
 * @package App\Http\Controllers
 */
class PertrechoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pertrechos = Pertrecho::paginate(10);

        return view('pertrecho.index', compact('pertrechos'))
            ->with('i', (request()->input('page', 1) - 1) * $pertrechos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pertrecho = new Pertrecho();
        $d_tpertrecho = Tpertrecho::all();
        return view('pertrecho.create', compact('pertrecho', 'd_tpertrecho'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Pertrecho::$rules);

        $pertrecho = Pertrecho::create($request->all());

        return redirect()->route('pertrechos.index')
            ->with('success', 'Pertrecho created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pertrecho = Pertrecho::find($id);

        return view('pertrecho.show', compact('pertrecho'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $pertrecho = Pertrecho::find($id);
        $d_tpertrecho = Tpertrecho::all();

        return view('pertrecho.edit', compact('pertrecho', 'd_tpertrecho'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Pertrecho $pertrecho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pertrecho $pertrecho)
    {
        request()->validate(Pertrecho::$rules);

        $pertrecho->update($request->all());

        return redirect()->route('pertrechos.index')
            ->with('success', 'Pertrecho updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $pertrecho = Pertrecho::find($id)->delete();

        return redirect()->route('pertrechos.index')
            ->with('success', 'Pertrecho deleted successfully');
    }
}
