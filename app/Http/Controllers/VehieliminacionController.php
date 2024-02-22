<?php

namespace App\Http\Controllers;

use App\Models\Vehieliminacion;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Class VehieliminacionController
 * @package App\Http\Controllers
 */
class VehieliminacionController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:vehieliminacions.index')->only('index');
        $this->middleware('can:vehieliminacions.create')->only('create', 'store');
        $this->middleware('can:vehieliminacions.edit')->only('edit', 'update');
        $this->middleware('can:vehieliminacions.show')->only('show');
        $this->middleware('can:vehieliminacions.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Vehieliminacion::query(); // Se crea una consulta para obtener los vehieliminacions
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('placa', 'like', '%' . $search . '%')
                    ->orWhere('chasis', 'like', '%' . $search . '%')
                    ->orWhere('motor', 'like', '%' . $search . '%')
                    ->orWhere('motivo', 'like', '%' . $search . '%');
            });
        }
    
        $vehieliminacions = $query->paginate(10);// Se obtienen los vehieliminacions paginados
    
        // Se devuelve la vista con los vehieliminacions paginados
        return view('vehieliminacion.index', compact('vehieliminacions'))
            ->with('i', (request()->input('page', 1) - 1) * $vehieliminacions->perPage());
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
            $vehieliminacion = Vehieliminacion::find($id); // Intenta encontrar el vehieliminacion por su ID

            return view('vehieliminacion.show', compact('vehieliminacion'));; // Devuelve la vista con los detalles del vehieliminacion
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el vehieliminacion, redirige a la lista de vehieliminacion con un mensaje de error
            return redirect()->route('vehieliminacion.index')->with('error', 'El vehículo no existe.');
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
     * @param  Vehieliminacion $vehieliminacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehieliminacion $vehieliminacion)
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
