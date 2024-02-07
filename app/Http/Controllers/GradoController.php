<?php

namespace App\Http\Controllers;

use App\Models\Grado;
use Illuminate\Http\Request;

/**
 * Class GradoController
 * @package App\Http\Controllers
 */
class GradoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:grados.index')->only('index');
        $this->middleware('can:grados.create')->only('create', 'store');
        $this->middleware('can:grados.edit')->only('edit', 'update');
        $this->middleware('can:grados.show')->only('show');
        $this->middleware('can:grados.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Grado::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%');
            });
        }

        $grados = $query->paginate(12);

        return view('grado.index', compact('grados'))
            ->with('i', (request()->input('page', 1) - 1) * $grados->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grado = new Grado();
        return view('grado.create', compact('grado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Grado::$rules);

        $grado = Grado::create($request->all());

        return redirect()->route('grados.index')
            ->with('success', 'Grado creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grado = Grado::find($id);

        return view('grado.show', compact('grado'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $grado = Grado::find($id);

        return view('grado.edit', compact('grado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Grado $grado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Grado $grado)
    {
        request()->validate(Grado::$rules);

        $grado->update($request->all());

        return redirect()->route('grados.index')
            ->with('success', 'Grado actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $grado = Grado::find($id)->delete();

        return redirect()->route('grados.index')
            ->with('success', 'Grado borrado exitosamente.');
    }
}
