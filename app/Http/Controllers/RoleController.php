<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
/**
 * Class RoleController
 * @package App\Http\Controllers
 */
class RoleController extends Controller
{

    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:roles.index')->only('index');
        $this->middleware('can:roles.create')->only('create', 'store');
        $this->middleware('can:roles.edit')->only('edit', 'update');
        $this->middleware('can:roles.show')->only('show');
        $this->middleware('can:roles.destroy')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        $query = Role::query(); // Se crea una consulta para obtener los roles
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });
        }
        $roles = $query->paginate(12);// Se obtienen los roles paginados

        // Se devuelve la vista con los roles paginados
        return view('role.index', compact('roles'))
            ->with('i', (request()->input('page', 1) - 1) * $roles->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $role = new Role();// Se crea una nueva instancia de provincia
        $permissions = Permission::all();

        return view('role.create', compact('role', 'permissions'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
    
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return redirect()->route('roles.create')->withErrors($validator)->withInput();
        }
    
        try {
            DB::beginTransaction(); // Se inicia una transacción de base de datos
        
            // Buscamos si ya existe un rol con el nombre proporcionado
            $rol = Role::where('name', $request->input('name'))->first();

            // Si el rol ya existe, redirigimos de nuevo al formulario de creación con un mensaje de error
            if($rol){
                return redirect()->route('roles.create')->with('error', 'El Rol ya está registrado.');//validamos si el rol esta registrado
            }

            $role = Role::create($request->all()); //creamos el rol

            $role->permissions()->sync($request->permissions); //asignamos los permisos seleccionados al nuevo rol
            
            DB::commit(); // Confirmamos la transacción

            // Redirigimos a la página de índice de roles con un mensaje de éxito
            return redirect()->route('roles.index', $role)->with('success', 'Rol creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, deshacemos la transacción y redirigimos con un mensaje de error
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'Error al crear el rol: ' . $e->getMessage());
        
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
            $role = Role::findOrFail($id); // Intenta encontrar el rol por su ID
    
            return view('role.show', compact('role')); // Devuelve la vista con los detalles del rol
    
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el rol, redirige a la lista de roles con un mensaje de error
            return redirect()->route('roles.index')->with('error', 'El Rol no existe.');
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
            $role = Role::findOrFail($id); // Intenta encontrar el rol por su ID
            $permissions = Permission::all();
    
            return view('role.edit', compact('role', 'permissions')); // Devuelve la vista con el rol a editar
    
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el rol, redirige a la lista de roles con un mensaje de error
            return redirect()->route('roles.index')->with('error', 'El Rol no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        // Validar los datos del formulario
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction(); // Iniciar una transacción de base de datos

            // Actualizar el rol con los datos proporcionados en el formulario
            $role->update($request->all());

            // Sincronizar los permisos seleccionados al rol
            $role->permissions()->sync($request->permissions);

            DB::commit(); // Confirmar la transacción

            // Redirigir a la lista de roles con un mensaje de éxito
            return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
        } catch (QueryException $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'Error al actualizar el rol: ' . $e->getMessage());
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
            DB::beginTransaction(); // Iniciar una transacción de base de datos

            $role = Role::findOrFail($id); // Buscar el rol por su ID
            $role->delete(); // Eliminar el rol

            DB::commit(); // Confirmar la transacción

            // Redirigir a la lista de roles con un mensaje de éxito
            return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el rol no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'El Rol no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'El Rol no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('roles.index')->with('error', 'Error al eliminar el rol: ' . $e->getMessage());
        }
    }
}
