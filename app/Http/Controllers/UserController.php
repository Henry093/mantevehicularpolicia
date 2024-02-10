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

    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.create')->only('create', 'store');
        $this->middleware('can:users.edit')->only('edit', 'update');
        $this->middleware('can:users.show')->only('show');
        $this->middleware('can:users.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = User::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('cedula', 'like', '%' . $search . '%')
                    ->orWhere('telefono', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('sangre', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('parroquia', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('grado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('rango', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $users = $query->paginate(12);

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

        $edicion = false;

        return view('user.create', compact('user', 'd_sangre', 'd_provincia', 'd_canton', 'd_parroquia', 'd_grado', 'd_rango', 'd_estado', 'edicion'));
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

        // Verificar si el estado ya está presente en la solicitud
        $estado = $request->input('estado_id');

        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['estado_id' => '1']);
        }

        // Generar nombre de usuario
        $apellido = strtolower(substr($request->input('lastname'), 0, 5));
        $nombre = strtolower(substr($request->input('name'), 0, 2));
        $base_usuario = 'ec' . $apellido . $nombre;

        // Asegurar que el nombre de usuario sea único
        $usuario = $this->generarUsuarioUnico($base_usuario);

        // Generar correo electrónico
        $correo = $usuario . '@policianacional.gob.ec';

        // Agregar el nombre de usuario y correo electrónico a la solicitud
        $request->merge(['usuario' => $usuario, 'email' => $correo]);

        // Verificar si la contraseña ya está presente en la solicitud
        $password = $request->input('password');

        if (empty($password)) {
            // Si no se proporciona una contraseña, establecer la contraseña predeterminada
            $request->merge(['password' => bcrypt('policia2024')]);
        }


        $user = User::create($request->all());

         // Asignar el rol "Policia" al usuario
        $rolPolicia = Role::where('name', 'Policia')->first();
        
        if ($rolPolicia) {
            $user->assignRole($rolPolicia);
        } else {
            // Manejar el caso donde el rol "Policia" no existe
            return redirect()->route('users.index')
                ->with('error', 'Error: El rol "Policia" no está definido.');
        }


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
        $edicion = true;

        return view('user.edit', compact('user', 'd_sangre', 'd_provincia', 'd_canton', 'd_parroquia', 'd_grado', 'd_rango', 'd_estado', 'edicion'));
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
      

    $userId = $user->id;

    $rules = [
        'name' => 'required|max:50',
        'lastname' => 'required|max:50',
        'cedula' => 'required|numeric|digits:10',
        'fecha_nacimiento' => 'required',
        'sangre_id' => 'required',
        'provincia_id' => 'required',
        'canton_id' => 'required',
        'parroquia_id' => 'required',
        'telefono' => 'required|numeric|digits:10',
        'grado_id' => 'required',
        'rango_id' => 'required',
        'estado_id' => 'required',
    ];

    $validatedData = $request->validate($rules);

    // Generar nombre de usuario
    $apellido = strtolower(substr($validatedData['lastname'], 0, 5));
    $nombre = strtolower(substr($validatedData['name'], 0, 2));
    $base_usuario = 'ec' . $apellido . $nombre;

    // Asegurar que el nombre de usuario sea único
    $usuario = $this->generarUsuarioUnico($base_usuario);

    // Generar correo electrónico
    $correo = $usuario . '@policianacional.gob.ec';
    // Verificar si la contraseña ya está presente en la solicitud
    $password = $request->input('password');

    if (empty($password)) {
        // Si no se proporciona una contraseña, establecer la contraseña predeterminada
        $request->merge(['password' => bcrypt('policia2024')]);
    }

    // Actualizar el usuario con los nuevos datos
    $user->update(array_merge($validatedData, ['usuario' => $usuario, 'email' => $correo]));

    return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
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
            if ($user->usersubcircuitos()->exists()) {
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


    private function generarUsuarioUnico($base_username, $max_length = 10)
    {
        $username = $base_username;
        $counter = 1;

        // Verificar la unicidad del nombre de usuario
        while (User::where('usuario', $username)->exists()) {
            // Agregar un dígito numérico al final
            $username = substr($base_username, 0, $max_length - strlen((string)$counter)) . $counter;
            $counter++;

            // Verificar si excede la longitud máxima permitida
            if (strlen($username) > $max_length) {
                throw new \Exception('No se pudo generar un nombre de usuario único dentro del límite de longitud.');
            }
        }

        return $username;
    }

}
