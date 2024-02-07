<?php

namespace App\Http\Controllers;

use App\Models\Tvehiculo;
use Illuminate\Http\Request;

/**
 * Class TvehiculoController
 * @package App\Http\Controllers
 */
class TvehiculoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:tvehiculos.index')->only('index');
        $this->middleware('can:tvehiculos.create')->only('create', 'store');
        $this->middleware('can:tvehiculos.edit')->only('edit', 'update');
        $this->middleware('can:tvehiculos.show')->only('show');
        $this->middleware('can:tvehiculos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Tvehiculo::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }
        $tvehiculos = $query->paginate(12);

        return view('tvehiculo.index', compact('tvehiculos'))
            ->with('i', (request()->input('page', 1) - 1) * $tvehiculos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tvehiculo = new Tvehiculo();
        return view('tvehiculo.create', compact('tvehiculo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Tvehiculo::$rules);

        $tvehiculo = Tvehiculo::create($request->all());

        return redirect()->route('tvehiculos.index')
            ->with('success', 'Tipo de vehículo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tvehiculo = Tvehiculo::find($id);

        return view('tvehiculo.show', compact('tvehiculo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tvehiculo = Tvehiculo::find($id);

        return view('tvehiculo.edit', compact('tvehiculo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tvehiculo $tvehiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tvehiculo $tvehiculo)
    {
        request()->validate(Tvehiculo::$rules);

        $tvehiculo->update($request->all());

        return redirect()->route('tvehiculos.index')
            ->with('success', 'Tipo de vehículo actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $tvehiculo = Tvehiculo::find($id)->delete();

        return redirect()->route('tvehiculos.index')
            ->with('success', 'Tipo de vehículo borrado exitosamente.');
    }
}
