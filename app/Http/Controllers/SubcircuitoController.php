<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class SubcircuitoController
 * @package App\Http\Controllers
 */
class SubcircuitoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:subcircuitos.index')->only('index');
        $this->middleware('can:subcircuitos.create')->only('create', 'store');
        $this->middleware('can:subcircuitos.edit')->only('edit', 'update');
        $this->middleware('can:subcircuitos.show')->only('show');
        $this->middleware('can:subcircuitos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Subcircuito::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('codigo', 'like', '%' . $search . '%')
                    ->orWhereHas('provincia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('canton', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('parroquia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('distrito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('circuito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $subcircuitos = $query->paginate(12);

        return view('subcircuito.index', compact('subcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $subcircuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subcircuito = new Subcircuito();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $edicion = false;
        return view('subcircuito.create', compact('subcircuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'd_circuito', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Subcircuito::$rules);

        // Verificar si el estado ya está presente en la solicitud
        $estado = $request->input('estado_id');

        if (empty($estado)) {
            // Si no se proporciona una estado, en este caso 1 = Activo
            $request->merge(['estado_id' => '1']);
        }

        $subcircuito = Subcircuito::create($request->all());

        return redirect()->route('subcircuitos.index')
            ->with('success', 'Subcircuito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subcircuito = Subcircuito::find($id);

        return view('subcircuito.show', compact('subcircuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subcircuito = Subcircuito::find($id);
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $edicion = false;

        return view('subcircuito.edit', compact('subcircuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'd_circuito', 'edicion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Subcircuito $subcircuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcircuito $subcircuito)
    {
        request()->validate(Subcircuito::$rules);

        $subcircuito->update($request->all());

        return redirect()->route('subcircuitos.index')
            ->with('success', 'Subcircuito actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $subcircuito = Subcircuito::find($id)->delete();

        return redirect()->route('subcircuitos.index')
            ->with('success', 'Subcircuito borrado exitosamente.');
    }

    public function getCantoness($provinciaId) {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getParroquiass($cantonId) {
        try {
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getDistritoss($parroquiaId) {
        try {
            $distritos = Distrito::where('parroquia_id', $parroquiaId)->pluck('nombre', 'id')->toArray();
            return response()->json($distritos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Distritos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getCircuitoss($distritoId) {
        try {
            $circuitos = Circuito::where('distrito_id', $distritoId)->pluck('nombre', 'id')->toArray();
            return response()->json($circuitos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Circuitos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
}
