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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
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
        // Validar los datos de entrada según las reglas definidas en la clase User
        $validator = Validator::make($request->all(), User::$rules);
    
        // Si la validación falla, redireccionar de vuelta al formulario con los errores de validación
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Verificar si el estado ya está presente en la solicitud
        $estado = $request->input('estado_id');
    
        if (empty($estado)) {
            // Si no se proporciona un estado, establecer el estado predeterminado (en este caso, 1 = Activo)
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
            $request->merge(['password' => bcrypt('Policia2024.')]);
        }
    
        try {
            DB::beginTransaction();
    
            // Crear el usuario en la base de datos con los datos proporcionados en la solicitud
            $user = User::create($request->all());
    
            // Asignar el rol "Policia" al usuario
            $rolPolicia = Role::where('name', 'Policia')->first();
    
            if ($rolPolicia) {
                $user->assignRole($rolPolicia);
            } else {
                // Manejar el caso donde el rol "Policia" no existe
                DB::rollBack();
                return redirect()->route('users.index')->with('error', 'Error: El rol "Policia" no está definido.');
            }
    
            DB::commit();
    
            return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
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
            $user = User::findOrFail($id);
            $d_rol = Role::all();
    
            return view('user.show', compact('user', 'd_rol'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('error', 'El usuario no existe.');
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
        try {
            $user = User::findOrFail($id);
            $d_sangre = Sangre::all();
            $d_provincia = Provincia::all();
            $d_canton = Canton::all();
            $d_parroquia = Parroquia::all();
            $d_grado = Grado::all();
            $d_rango = Rango::all();
            $d_estado = Estado::all();
            $edicion = true;
    
            return view('user.edit', compact('user', 'd_sangre', 'd_provincia', 'd_canton', 'd_parroquia', 'd_grado', 'd_rango', 'd_estado', 'edicion'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')->with('error', 'El usuario no existe.');
        }
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
        $validator = Validator::make($request->all(), [
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
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();
    
            $validatedData = $validator->validated();
    
            // Generar nombre de usuario
            $apellido = strtolower(substr($validatedData['lastname'], 0, 5));
            $nombre = strtolower(substr($validatedData['name'], 0, 2));
            $base_usuario = 'ec' . $apellido . $nombre;
    
            // Asegurar que el nombre de usuario sea único
            $usuario = $this->generarUsuarioUnico($base_usuario, true);
    
            // Generar correo electrónico
            $correo = $usuario . '@policianacional.gob.ec';
    
            // Verificar si la contraseña ya está presente en la solicitud
            $password = $request->input('password');
    
            if (empty($password)) {
                // Si no se proporciona una contraseña, establecer la contraseña predeterminada
                $request->merge(['password' => bcrypt('Policia2024.')]);
            }
    
            // Actualizar el usuario con los nuevos datos
            $user->update(array_merge($validatedData, ['usuario' => $usuario, 'email' => $correo]));
    
            DB::commit();
    
            return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
    
            $user = User::findOrFail($id);
            $user->delete();
    
            DB::commit();
    
            return redirect()->route('users.index')->with('success', 'Usuario borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'El usuario no existe.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'El usuario no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
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


    private function generarUsuarioUnico($base_username, $is_update = false, $max_length = 10)
    {
        $username = $base_username;
        $counter = 1;
    
        if ($is_update) {
            // Se está realizando una actualización, reiniciar el contador a 1
            $counter = 1;
        }
    
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
