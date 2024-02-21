<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Asignacione;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AsignarController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:asignar.index')->only('index');
        $this->middleware('can:asignar.create')->only('create', 'store');
        $this->middleware('can:asignar.edit')->only('edit', 'update');
        $this->middleware('can:asignar.show')->only('show');
        $this->middleware('can:asignar.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $search = request('search');// Se obtiene el término de búsqueda
        
        $query = User::with('roles');// Se crea la consulta para usuarios con sus roles relacionados

        // Si hay un término de búsqueda, se aplican filtros
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('usuario', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('roles', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })->orWhereHas('grado', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    })->orWhereHas('rango', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }

        
        $users = $query->paginate(10);// Se obtienen los usuarios paginados según la consulta

        // Se devuelve la vista con los usuarios y la paginación    
        return view('user.sistem.assign', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            
            $user = User::find($id);// Se intenta encontrar el usuario con el ID proporcionado
    
            // Si el usuario no se encuentra, se lanza una excepción
            if (!$user) {
                throw new \Exception("Usuario no encontrado.");
            }
    
            $roles = Role::all();// Se obtienen todos los roles
    
            // Se devuelve la vista de edición de roles con el usuario y los roles encontrados
            return view('user.sistem.rol_user', compact('user', 'roles'));

        } catch (\Exception $e) {
            // Si ocurre un error, se redirecciona de vuelta con un mensaje de error
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            
            $user = User::find($id);// Se intenta encontrar el usuario con el ID proporcionado
    
            // Si el usuario no se encuentra, se lanza una excepción
            if (!$user) {
                throw new \Exception("Usuario no encontrado.");
            }
    
            // Se sincronizan los roles del usuario con los proporcionados en la solicitud
            $user->roles()->sync($request->roles);
    
            // Se redirecciona a la lista de usuarios con un mensaje de éxito
            return redirect()->route('asignar.index', $user)->with('success', 'Rol asignado correctamente.');
            
        } catch (\Exception $e) {
            // Si ocurre un error, se redirecciona de vuelta con un mensaje de error
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

