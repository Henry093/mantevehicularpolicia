<?php

namespace App\Http\Controllers;

use App\Models\Asignarpertrecho;
use App\Models\Pertrecho;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class AsignarpertrechoController
 * @package App\Http\Controllers
 */
class AsignarpertrechoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $asignarpertrechos = Asignarpertrecho::paginate(10);

        return view('asignarpertrecho.index', compact('asignarpertrechos'))
            ->with('i', (request()->input('page', 1) - 1) * $asignarpertrechos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $asignarpertrecho = new Asignarpertrecho();
        $d_pertrecho = Pertrecho::all();
        
        // Obtener todos los usuarios
        $d_user = User::all();
    
        // Filtrar los usuarios disponibles (que no tienen asignaciones)
        $usuarios = [];
        foreach ($d_user as $user) {
            if ($user->asignarpertrechos->isEmpty()) {
                $usuarios[] = $user;
            }
        }
    
        return view('asignarpertrecho.create', compact('asignarpertrecho', 'd_pertrecho', 'usuarios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validar los datos de entrada
        request()->validate(Asignarpertrecho::$rules);
    
        // Obtener el ID del pertrecho y el ID del usuario desde la solicitud
        $pertrecho_id = $request->input('pertrecho_id');
        $user_id = $request->input('user_id');
    
        // Verificar si ya existe una asignación para este pertrecho y este usuario
        $existingAssignment = Asignarpertrecho::where('pertrecho_id', $pertrecho_id)
                                                ->where('user_id', $user_id)
                                                ->first();
    
        // Si ya existe una asignación, redirigir con un mensaje de error
        if ($existingAssignment) {
            return redirect()->route('asignarpertrechos.create')
                ->with('error', 'Este pertrecho ya ha sido asignado a este usuario.');
        }
    
        // Crear la nueva asignación si no existe una asignación previa
        $asignarpertrecho = Asignarpertrecho::create($request->all());
    
        // Redirigir a la vista index con un mensaje de éxito
        return redirect()->route('asignarpertrechos.index')
            ->with('success', 'Asignación de pertrecho creada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asignarpertrecho = Asignarpertrecho::find($id);

        return view('asignarpertrecho.show', compact('asignarpertrecho'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $asignarpertrecho = Asignarpertrecho::find($id);
        $d_pertrecho = Pertrecho::all();
        $d_user = User::all();

        return view('asignarpertrecho.edit', compact('asignarpertrecho', 'd_pertrecho', 'd_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Asignarpertrecho $asignarpertrecho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Asignarpertrecho $asignarpertrecho)
    {
        request()->validate(Asignarpertrecho::$rules);

        $asignarpertrecho->update($request->all());

        return redirect()->route('asignarpertrechos.index')
            ->with('success', 'Asignarpertrecho updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $asignarpertrecho = Asignarpertrecho::find($id)->delete();

        return redirect()->route('asignarpertrechos.index')
            ->with('success', 'Asignarpertrecho deleted successfully');
    }
}
