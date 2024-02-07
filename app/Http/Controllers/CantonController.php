<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Provincia;
use Illuminate\Http\Request;

/**
 * Class CantonController
 * @package App\Http\Controllers
 */
class CantonController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:cantons.index')->only('index');
        $this->middleware('can:cantons.create')->only('create', 'store');
        $this->middleware('can:cantons.edit')->only('edit', 'update');
        $this->middleware('can:cantons.show')->only('show');
        $this->middleware('can:cantons.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');
        $query = Canton::query();
    
        if ($search) {
            $query->where('nombre', 'like', '%' . $search . '%')
                  ->orWhereHas('provincia', function ($q) use ($search) {
                      $q->where('nombre', 'like', '%' . $search . '%');
                  });
        }

        $cantons = $query->paginate(12);

        return view('canton.index', compact('cantons'))
            ->with('i', (request()->input('page', 1) - 1) * $cantons->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $canton = new Canton();
        $d_provincia = Provincia::all();
        return view('canton.create', compact('canton', 'd_provincia'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Canton::$rules);

        $nombre = Canton::where('nombre', $request->input('nombre'))->first();
        if($nombre){
            return redirect()->route('cantons.create')->with('error', 'La cantón ya está registrado.');
        }

        $canton = Canton::create($request->all());

        return redirect()->route('cantons.index')
            ->with('success', 'Cantón creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $canton = Canton::find($id);

        return view('canton.show', compact('canton'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $canton = Canton::find($id);
        $d_provincia = Provincia::all();

        return view('canton.edit', compact('canton', 'd_provincia'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Canton $canton
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Canton $canton)
    {
        request()->validate(Canton::$rules);

        $canton->update($request->all());

        return redirect()->route('cantons.index')
            ->with('success', 'Cantón actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $canton = Canton::find($id)->delete();

        return redirect()->route('cantons.index')
            ->with('success', 'Cantón borrado exitosamente.');
    }

 
}
