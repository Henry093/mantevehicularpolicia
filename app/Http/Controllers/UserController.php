<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Estado;
use App\Models\Grado;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Rango;
use App\Models\Sangre;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $d_sangre = Sangre::all();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_grado = Grado::all();
        $d_rango = Rango::all();
        $d_estado = Estado::all();

        return view('user.create', compact('user', 'd_sangre', 'd_provincia', 'd_canton', 'd_parroquia', 'd_grado', 'd_rango', 'd_estado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(User::$rules);

        // Verificar si la contraseña ya está presente en la solicitud
        $password = $request->input('password');

        if (empty($password)) {
            // Si no se proporciona una contraseña, establecer la contraseña predeterminada
            $request->merge(['password' => bcrypt('policia12345')]);
        }

        $user = User::create($request->all());

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $d_rol = Role::all();


        return view('user.show', compact('user', 'd_rol'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $d_sangre = Sangre::all();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_grado = Grado::all();
        $d_rango = Rango::all();
        $d_estado = Estado::all();

        return view('user.edit', compact('user', 'd_sangre', 'd_provincia', 'd_canton', 'd_parroquia', 'd_grado', 'd_rango', 'd_estado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        request()->validate(User::$rules);

        $user->update($request->all());
        $dsangre = Sangre::all();

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('users.index')
                ->with('error', 'El usuario no existe.');
        }

        try {
            // Verificar si la persona está asignada a algún subcircuito
            if ($user->usubcircuitos()->exists()) {
                return redirect()->route('users.index')
                    ->with('error', 'No se puede eliminar. El usuario está asignado a un subcircuito.');
            }

            $user->delete();

            return redirect()->route('users.index')
                ->with('success', 'Usuario borrado exitosamente.');
        } catch (QueryException $e) {
            // Captura cualquier otro error de la base de datos que pueda ocurrir durante la eliminación
            return redirect()->route('users.index')
                ->with('error', 'Hubo un problema al intentar eliminar al usuario.');
        }
    }
    
    public function getCantones($provinciaId) {
        $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
        return response()->json($cantones);
    }

    public function getParroquias($cantonId) {
        $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
        return response()->json($parroquias);
    }

    public function getRangos($gradoId) {
        $rangos = Rango::where('grado_id', $gradoId)->pluck('nombre', 'id')->toArray();
        return response()->json($rangos);
    }
}
