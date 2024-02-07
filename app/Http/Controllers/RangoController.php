<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use App\Models\Rango;
use Illuminate\Http\Request;

/**
 * Class RangoController
 * @package App\Http\Controllers
 */
class RangoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:rangos.index')->only('index');
        $this->middleware('can:rangos.create')->only('create', 'store');
        $this->middleware('can:rangos.edit')->only('edit', 'update');
        $this->middleware('can:rangos.show')->only('show');
        $this->middleware('can:rangos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Rango::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('grado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $rangos = $query->paginate(12);

        return view('rango.index', compact('rangos'))
            ->with('i', (request()->input('page', 1) - 1) * $rangos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rango = new Rango();

        $d_grado = Grado::all();
        return view('rango.create', compact('rango', 'd_grado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Rango::$rules);

        $rango = Rango::create($request->all());

        return redirect()->route('rangos.index')
            ->with('success', 'Rango creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rango = Rango::find($id);

        return view('rango.show', compact('rango'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $rango = Rango::find($id);

        $d_grado = Grado::all();

        return view('rango.edit', compact('rango', 'd_grado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Rango $rango
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rango $rango)
    {
        request()->validate(Rango::$rules);

        $rango->update($request->all());

        return redirect()->route('rangos.index')
            ->with('success', 'Rango actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $rango = Rango::find($id)->delete();

        return redirect()->route('rangos.index')
            ->with('success', 'Rango borrado exitosamente.');
    }
}
