<?php

namespace App\Http\Controllers;

use App\Models\Novedade;
use App\Models\Tnovedade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class NovedadeController
 * @package App\Http\Controllers
 */
class NovedadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:novedades.index')->only('index');
        $this->middleware('can:novedades.create')->only('create', 'store');
        $this->middleware('can:novedades.edit')->only('edit', 'update');
        $this->middleware('can:novedades.show')->only('show');
        $this->middleware('can:novedades.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Novedade::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('mensaje', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('tnovedade', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $novedades = $query->paginate(12);

        return view('novedade.index', compact('novedades'))
            ->with('i', (request()->input('page', 1) - 1) * $novedades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $novedade = new Novedade();
        $d_tnovedad = Tnovedade::all();
        $user = auth()->user();

        $edicion = false;
        return view('novedade.create', compact('novedade', 'edicion', 'd_tnovedad', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Novedade::$rules);

        $estado = $request->input('tnovedad_id');

        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['tnovedad_id' => '1']);
        }

        // Obtener el ID del usuario autenticado
        $user_id = Auth::id();
        $request->merge(['user_id' => $user_id]);
        
        $novedade = Novedade::create($request->all());

        return redirect()->route('mantenimientos.create')
            ->with('success', 'Novedad creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $novedade = Novedade::find($id);

        return view('novedade.show', compact('novedade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $novedade = Novedade::find($id);
        $d_tnovedad = Tnovedade::all();

        $edicion = true;

        return view('novedade.edit', compact('novedade', 'edicion', 'd_tnovedad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Novedade $novedade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Novedade $novedade)
    {
        request()->validate(Novedade::$rules);

        $novedade->update($request->all());

        return redirect()->route('novedades.index')
            ->with('success', 'Novedad actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $novedade = Novedade::find($id)->delete();

        return redirect()->route('novedades.index')
            ->with('success', 'Novedad borrado exitosamente.');
    }
}
