<?php

namespace App\Http\Controllers;

use App\Models\Vehientrega;
use App\Models\Vehirecepcione;
use Illuminate\Http\Request;

/**
 * Class VehientregaController
 * @package App\Http\Controllers
 */
class VehientregaController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vehientregas.index')->only('index');
        $this->middleware('can:vehientregas.create')->only('create', 'store');
        $this->middleware('can:vehientregas.edit')->only('edit', 'update');
        $this->middleware('can:vehientregas.show')->only('show');
        $this->middleware('can:vehientregas.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehientregas = Vehientrega::paginate(10);

        return view('vehientrega.index', compact('vehientregas'))
            ->with('i', (request()->input('page', 1) - 1) * $vehientregas->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehientrega = new Vehientrega();
        $d_vehirecepciones = Vehirecepcione::all();
    
        // Obtener las órdenes ya seleccionadas
        $ordenesSeleccionadas = Vehientrega::pluck('vehirecepciones_id')->toArray();
    
        return view('vehientrega.create', compact('vehientrega', 'd_vehirecepciones', 'ordenesSeleccionadas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(Vehientrega::$rules);

        // Lógica de cálculo de km_proximo
        $mantetipo = Vehirecepcione::find($validatedData['vehirecepciones_id'])->mantetipo;

        if ($mantetipo->id == 1 || $mantetipo->id == 2 || $mantetipo->id == 4) {
            $validatedData['km_proximo'] = $validatedData['km_actual'] + 5000;
        } elseif ($mantetipo->id == 3) {
            $validatedData['km_proximo'] = $validatedData['km_actual'] + 2000;
        }

        $vehientrega = Vehientrega::create($validatedData);

        
        return redirect()->route('vehientregas.index')
            ->with('success', 'Vehientrega created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehientrega = Vehientrega::find($id);

        return view('vehientrega.show', compact('vehientrega'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehientrega = Vehientrega::find($id);

        return view('vehientrega.edit', compact('vehientrega'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehientrega $vehientrega
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehientrega $vehientrega)
    {
        $validatedData = $request->validate(Vehientrega::$rules);

        // Lógica de cálculo de km_proximo
        $mantetipo = Vehirecepcione::find($validatedData['vehirecepciones_id'])->mantetipo;

        if ($mantetipo->id == 1 || $mantetipo->id == 2 || $mantetipo->id == 4) {
            $validatedData['km_proximo'] = $validatedData['km_actual'] + 5000;
        } elseif ($mantetipo->id == 3) {
            $validatedData['km_proximo'] = $validatedData['km_actual'] + 2000;
        }

        $vehientrega->update($validatedData);

        return redirect()->route('vehientregas.index')
            ->with('success', 'Vehientrega updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehientrega = Vehientrega::find($id)->delete();

        return redirect()->route('vehientregas.index')
            ->with('success', 'Vehientrega deleted successfully');
    }
}
