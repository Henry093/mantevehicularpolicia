<?php

namespace App\Http\Controllers;

use App\Models\Mantestado;
use Illuminate\Http\Request;

/**
 * Class MantestadoController
 * @package App\Http\Controllers
 */
class MantestadoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantestados.index')->only('index');
        $this->middleware('can:mantestados.create')->only('create', 'store');
        $this->middleware('can:mantestados.edit')->only('edit', 'update');
        $this->middleware('can:mantestados.show')->only('show');
        $this->middleware('can:mantestados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Mantestado::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $mantestados = $query->paginate(12);

        return view('mantestado.index', compact('mantestados'))
            ->with('i', (request()->input('page', 1) - 1) * $mantestados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mantestado = new Mantestado();
        return view('mantestado.create', compact('mantestado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Mantestado::$rules);

        $mantestado = Mantestado::create($request->all());

        return redirect()->route('mantestados.index')
            ->with('success', 'Estado mantenimiento creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mantestado = Mantestado::find($id);

        return view('mantestado.show', compact('mantestado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mantestado = Mantestado::find($id);

        return view('mantestado.edit', compact('mantestado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantestado $mantestado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantestado $mantestado)
    {
        request()->validate(Mantestado::$rules);

        $mantestado->update($request->all());

        return redirect()->route('mantestados.index')
            ->with('success', 'Estado mantenimiento actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mantestado = Mantestado::find($id)->delete();

        return redirect()->route('mantestados.index')
            ->with('success', 'Estado mantenimiento borrado exitosamente.');
    }
}
