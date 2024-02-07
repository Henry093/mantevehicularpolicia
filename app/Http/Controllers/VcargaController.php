<?php

namespace App\Http\Controllers;

use App\Models\Vcarga;
use Illuminate\Http\Request;

/**
 * Class VcargaController
 * @package App\Http\Controllers
 */
class VcargaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vcargas.index')->only('index');
        $this->middleware('can:vcargas.create')->only('create', 'store');
        $this->middleware('can:vcargas.edit')->only('edit', 'update');
        $this->middleware('can:vcargas.show')->only('show');
        $this->middleware('can:vcargas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Vcarga::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $vcargas = $query->paginate(12);

        return view('vcarga.index', compact('vcargas'))
            ->with('i', (request()->input('page', 1) - 1) * $vcargas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vcarga = new Vcarga();
        return view('vcarga.create', compact('vcarga'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Vcarga::$rules);

        $vcarga = Vcarga::create($request->all());

        return redirect()->route('vcargas.index')
            ->with('success', 'Capacidad de carga creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vcarga = Vcarga::find($id);

        return view('vcarga.show', compact('vcarga'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vcarga = Vcarga::find($id);

        return view('vcarga.edit', compact('vcarga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vcarga $vcarga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vcarga $vcarga)
    {
        request()->validate(Vcarga::$rules);

        $vcarga->update($request->all());

        return redirect()->route('vcargas.index')
            ->with('success', 'Capacidad de carga actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vcarga = Vcarga::find($id)->delete();

        return redirect()->route('vcargas.index')
            ->with('success', 'Capacidad de carga borrado exitosamente.');
    }
}
