<?php

namespace App\Http\Controllers;

use App\Models\Manteregistro;
use Illuminate\Http\Request;

/**
 * Class ManteregistroController
 * @package App\Http\Controllers
 */
class ManteregistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manteregistros = Manteregistro::paginate(10);

        return view('manteregistro.index', compact('manteregistros'))
            ->with('i', (request()->input('page', 1) - 1) * $manteregistros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manteregistro = new Manteregistro();

        $edicion= false;
        return view('manteregistro.create', compact('manteregistro', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Manteregistro::$rules);

        $estado = $request->input('mantestados_id');

        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['mantestados_id' => '1']);
        }

        $manteregistro = Manteregistro::create($request->all());

        return redirect()->route('manteregistros.index')
            ->with('success', 'Manteregistro created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $manteregistro = Manteregistro::find($id);

        return view('manteregistro.show', compact('manteregistro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manteregistro = Manteregistro::find($id);

        return view('manteregistro.edit', compact('manteregistro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Manteregistro $manteregistro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manteregistro $manteregistro)
    {
        request()->validate(Manteregistro::$rules);

        $manteregistro->update($request->all());

        return redirect()->route('manteregistros.index')
            ->with('success', 'Manteregistro updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $manteregistro = Manteregistro::find($id)->delete();

        return redirect()->route('manteregistros.index')
            ->with('success', 'Manteregistro deleted successfully');
    }
}
