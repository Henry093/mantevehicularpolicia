<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Http\Request;

/**
 * Class ParroquiaController
 * @package App\Http\Controllers
 */
class ParroquiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:parroquias.index')->only('index');
        $this->middleware('can:parroquias.create')->only('create', 'store');
        $this->middleware('can:parroquias.edit')->only('edit', 'update');
        $this->middleware('can:parroquias.show')->only('show');
        $this->middleware('can:parroquias.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Parroquia::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhereHas('provincia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('canton', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $parroquias = $query->paginate(12);

        return view('parroquia.index', compact('parroquias'))
            ->with('i', (request()->input('page', 1) - 1) * $parroquias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parroquia = new Parroquia();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        return view('parroquia.create', compact('parroquia', 'd_provincia', 'd_canton'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Parroquia::$rules);

        $parroquia = Parroquia::create($request->all());

        $nombre = Parroquia::where('nombre', $request->input('nombre'))->first();

        if($nombre){
            return redirect()->route('parroquias.create')->with('error', 'La parroquia ya está registrada.');
        }

        return redirect()->route('parroquias.index')
            ->with('success', 'Parroquia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $parroquia = Parroquia::find($id);

        return view('parroquia.show', compact('parroquia'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parroquia = Parroquia::find($id);
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();

        return view('parroquia.edit', compact('parroquia', 'd_provincia', 'd_canton'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Parroquia $parroquia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parroquia $parroquia)
    {
        request()->validate(Parroquia::$rules);
        

        $parroquia->update($request->all());

        return redirect()->route('parroquias.index')
            ->with('success', 'Parroquia actualizada exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $parroquia = Parroquia::find($id)->delete();

        return redirect()->route('parroquias.index')
            ->with('success', 'Parroquia borrada exitosamente.');
    }
}
