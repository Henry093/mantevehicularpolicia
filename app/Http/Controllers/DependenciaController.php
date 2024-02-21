<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Dependencia;
use App\Models\Distrito;
use App\Models\Estado;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * Class DependenciaController
 * @package App\Http\Controllers
 */
class DependenciaController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:dependencias.index')->only('index');
        $this->middleware('can:dependencias.create')->only('create', 'store');
        $this->middleware('can:dependencias.edit')->only('edit', 'update');
        $this->middleware('can:dependencias.show')->only('show');
        $this->middleware('can:dependencias.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda

        $query = Subcircuito::query();// Se crea una consulta para obtener los cantones
    
        // Si hay un término de búsqueda, se aplica el filtro
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
                    ->orWhereHas('distrito', function ($q) use ($search) {
                        $q->where('codigo', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('circuito', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('circuito', function ($q) use ($search) {

                        $q->where('codigo', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('estado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $dependencias = $query->paginate(12);// Se obtienen las dependencias paginados

        // Se devuelve la vista con los cantones paginados
        return view('dependencia.index', compact('dependencias'))
            ->with('i', (request()->input('page', 1) - 1) * $dependencias->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $dependencia = Subcircuito::find($id);// Intenta encontrar la dependencia por su ID

            return view('dependencia.show', compact('dependencia'));// Devuelve la vista 'canton.show' con los detalles de la dependencia

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra la dependencia, redirige a la lista de dependencias con un mensaje de error
            return redirect()->route('dependencia.index')->with('error', 'La dependencia no existe.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Dependencia $dependencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dependencia $dependencia)
    {
        //        
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        //
    }

}
