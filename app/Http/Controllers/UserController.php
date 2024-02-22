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
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{

    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
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
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = User::query(); // Se crea una consulta para obtener los provincias
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
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
        $users = $query->paginate(12);// Se obtienen los provincias paginados

        // Se devuelve la vista con los provincias paginados
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
        $user = new User();; // Se crea una nueva instancia de provincia
        $d_sangre = Sangre::all();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_grado = Grado::all();
        $d_rango = Rango::all();
        $d_estado = Estado::all();

        $edicion = false;
        // Se devuelve la vista con el formulario de creación
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
    
        
        $estado = $request->input('estado_id');// Verificar si el estado ya está presente en la solicitud
    
        if (empty($estado)) {
            // Si no se proporciona un estado, establecer el estado predeterminado (en este caso, 1 = Activo)
            $request->merge(['estado_id' => '1']);
        }
    
        // Generar nombre de usuario
        $apellido = strtolower(substr($request->input('lastname'), 0, 5));
        $nombre = strtolower(substr($request->input('name'), 0, 2));
        $base_usuario = 'ec' . $apellido . $nombre;
    
        
        $usuario = $this->generarUsuarioUnico($base_usuario);// Asegura que el nombre de usuario sea único
    
        $correo = $usuario . '@policianacional.gob.ec';// Genera correo electrónico
    
        $request->merge(['usuario' => $usuario, 'email' => $correo]);// Agregar el nombre de usuario y correo electrónico a la solicitud
    
        $password = $request->input('password');// Verificar si la contraseña ya está presente en la solicitud
    
        if (empty($password)) {
            // Si no se proporciona una contraseña, establecer la contraseña predeterminada
            $request->merge(['password' => bcrypt('Policia2024#')]);
        }
    
        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos
    
            $user = User::create($request->all());// Crear el usuario en la base de datos con los datos proporcionados en la solicitud
    
            $rolPolicia = Role::where('name', 'Policia')->first();// Asignar el rol "Policia" al usuario
    
            if ($rolPolicia) {
                $user->assignRole($rolPolicia);
            } else {
                // Manejar el caso donde el rol "Policia" no existe
                DB::rollBack();
                return redirect()->route('users.index')->with('error', 'Error: El rol "Policia" no está definido.');
            }
    
            DB::commit(); // Se confirma la transacción
    
            // Se redirige a la lista de users con un mensaje de éxito
            return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
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
            $user = User::findOrFail($id); // Intenta encontrar el User por su ID
            $d_rol = Role::all();
    
            return view('user.show', compact('user', 'd_rol')); // Devuelve la vista con los detalles del provincia
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el User, redirige a la lista de User con un mensaje de error
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
            $user = User::findOrFail($id); // Intenta encontrar el User por su ID
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
        // Validar los datos del formulario
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
            // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $validatedData = $validator->validated();
    
            // Generar nombre de usuario
            $apellido = strtolower(substr($validatedData['lastname'], 0, 5));
            $nombre = strtolower(substr($validatedData['name'], 0, 2));
            $base_usuario = 'ec' . $apellido . $nombre;
    
            $usuario = $this->generarUsuarioUnico($base_usuario, true); // Asegurar que el nombre de usuario sea único
    
            $correo = $usuario . '@policianacional.gob.ec';// Generar correo electrónico
    
            $password = $request->input('password');// Verificar si la contraseña ya está presente en la solicitud
    
            if (empty($password)) {
                // Si no se proporciona una contraseña, establecer la contraseña predeterminada
                $request->merge(['password' => bcrypt('Policia2024#')]);
            }
    
            // Actualizar el usuario con los nuevos datos
            $user->update(array_merge($validatedData, ['usuario' => $usuario, 'email' => $correo]));
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de users con un mensaje de éxito
            return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
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
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $user = User::findOrFail($id);// Buscar el User por su ID
            $user->delete();// Eliminar el User
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('users.index')->with('success', 'Usuario borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el User no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'El usuario no existe.');
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'El usuario no puede eliminarse, tiene datos asociados.');
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('users.index')->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
    


    public function getCantones($provinciaId)
    {
        try {
            // Intenta encontrar los cantones correspondientes a la provincia proporcionada
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            
            // Devuelve una respuesta JSON con los cantones encontrados
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentran cantones, devuelve un error 404
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            // Si ocurre otro tipo de error, devuelve un error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    
    public function getParroquias($cantonId)
    {
        try {
            // Intenta encontrar las parroquias correspondientes al cantón proporcionado
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            
            // Devuelve una respuesta JSON con las parroquias encontradas
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentran parroquias, devuelve un error 404
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            // Si ocurre otro tipo de error, devuelve un error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getRangos($gradoId)
    {
        try {
            // Intenta encontrar las rangos correspondientes al cantón proporcionado
            $rangos = Rango::where('grado_id', $gradoId)->pluck('nombre', 'id')->toArray();
            
            // Devuelve una respuesta JSON con las parroquias encontradas
            return response()->json($rangos);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentran rangos, devuelve un error 404
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            // Si ocurre otro tipo de error, devuelve un error 500
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
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
    // Agrega este método al final del controlador
    public function showProfile()
    {
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Verificar si el usuario está autenticado
        if ($user) {
            // Renderizar la vista del perfil y pasar el usuario
            return view('user.config.perfil', compact('user'));
        } else {
            // Redireccionar al usuario a la página de inicio de sesión si no está autenticado
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para ver tu perfil.');
        }
    }

    //Cambiar Password
    public function changePassword(Request $request)
    {
        try {
            // Obtener el usuario autenticado desde el guardia 'web'
            $user = Auth::guard('web')->user();
    
            if (!$user) {
                return redirect()->route('login')->with('error', 'Debes iniciar sesión para cambiar tu contraseña.');
            }
    
            // Validar los datos de entrada
            $validator = Validator::make($request->all(), [
                'current_password' => 'required',
                'new_password' => 'required|min:8', // Validar que la contraseña tenga al menos 8 caracteres
                'new_confirm_password' => 'required|same:new_password',
            ], [
                'new_password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'new_confirm_password.same' => 'Las contraseñas no coinciden.',
            ]);
    
            // Si la validación falla, redireccionar de vuelta al formulario con los errores de validación
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
    
            // Verificar si la contraseña actual proporcionada coincide con la contraseña del usuario
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'La contraseña actual es incorrecta.');
            }
    
            // Actualizar la contraseña del usuario
            $user->password = Hash::make($request->new_password);
    
            // Verificar si $user es una instancia de User antes de intentar guardar
            if ($user instanceof User) {
                $user->save(); // Guardar los cambios en la base de datos
            }
            // Redirigir al usuario a la vista del perfil
            return redirect()->route('perfil')->with('success', 'Contraseña cambiada exitosamente.');
        } catch (\Exception $e) {
            // Manejar cualquier excepción
            return back()->with('error', 'Ha ocurrido un error al cambiar la contraseña: ' . $e->getMessage());
        }
    }
}
