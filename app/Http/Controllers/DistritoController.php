<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Distrito;
use App\Models\Estado;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class DistritoController
 * @package App\Http\Controllers
 */
class DistritoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:distritos.index')->only('index');
        $this->middleware('can:distritos.create')->only('create', 'store');
        $this->middleware('can:distritos.edit')->only('edit', 'update');
        $this->middleware('can:distritos.show')->only('show');
        $this->middleware('can:distritos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Distrito::query();
    
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
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }

        $distritos = $query->paginate(12);

        return view('distrito.index', compact('distritos'))
            ->with('i', (request()->input('page', 1) - 1) * $distritos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $distrito = new Distrito();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();

        $edicion = false;

        return view('distrito.create', compact('distrito', 'd_provincia', 'd_canton', 'd_parroquia', 'edicion'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Distrito::$rules);

        // Verificar si el estado ya está presente en la solicitud
        $estado = $request->input('estado_id');

        if (empty($estado)) {
            // Si no se proporciona una estado, en este caso 1 = Activo
            $request->merge(['estado_id' => '1']);
        }

        $distrito = Distrito::create($request->all());

        return redirect()->route('distritos.index')
            ->with('success', 'Distrito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $distrito = Distrito::find($id);

        return view('distrito.show', compact('distrito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $distrito = Distrito::find($id);
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_estado = Estado::all();

        $edicion = true;

        return view('distrito.edit', compact('distrito', 'd_provincia', 'd_canton', 'd_parroquia', 'd_estado', 'edicion'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Distrito $distrito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Distrito $distrito)
    {
        request()->validate(Distrito::$rules);

        $distrito->update($request->all());

        return redirect()->route('distritos.index')
            ->with('success', 'Distrito actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $distrito = Distrito::find($id)->delete();

        return redirect()->route('distritos.index')
            ->with('success', 'Distrito borrado exitosamente.');
    }



    public function getCantonesd($provinciaId) {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getParroquiasd($cantonId) {
        try {
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    
}
