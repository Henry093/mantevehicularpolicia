<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Estado;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class CircuitoController
 * @package App\Http\Controllers
 */
class CircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $circuitos = Circuito::paginate(10);

        return view('circuito.index', compact('circuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $circuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $circuito = new Circuito();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $edicion = false;


        return view('circuito.create', compact('circuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Circuito::$rules);

        // Verificar si el estado ya está presente en la solicitud
        $estado = $request->input('estado_id');

        if (empty($estado)) {
            // Si no se proporciona una estado, en este caso 1 = Activo
            $request->merge(['estado_id' => '1']);
        }
        
        $circuito = Circuito::create($request->all());

        return redirect()->route('circuitos.index')
            ->with('success', 'Circuito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $circuito = Circuito::find($id);

        return view('circuito.show', compact('circuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $circuito = Circuito::find($id);
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_estado = Estado::all();
        $edicion = true;

        return view('circuito.edit', compact('circuito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_distrito', 'edicion', 'd_estado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Circuito $circuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Circuito $circuito)
    {
        request()->validate(Circuito::$rules);

        $circuito->update($request->all());

        return redirect()->route('circuitos.index')
            ->with('success', 'Circuito actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $circuito = Circuito::find($id)->delete();

        return redirect()->route('circuitos.index')
            ->with('success', 'Circuito borrado exitosamente.');
    }

    public function getCantonesc($provinciaId) {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getParroquiasc($cantonId) {
        try {
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getDistritosc($parroquiaId) {
        try {
            $distritos = Distrito::where('parroquia_id', $parroquiaId)->pluck('nombre', 'id')->toArray();
            return response()->json($distritos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Distritos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
}
