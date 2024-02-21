<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 */
class PermissionController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:permissions.index')->only('index');
        $this->middleware('can:permissions.create')->only('create', 'store');
        $this->middleware('can:permissions.edit')->only('edit', 'update');
        $this->middleware('can:permissions.show')->only('show');
        $this->middleware('can:permissions.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search'); // Se obtiene el término de búsqueda
        
        $query = Permission::query(); // Se crea una consulta para obtener los permissions
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
        }

        $permissions = $query->paginate(12);// Se obtienen los cantones paginados

        // Se devuelve la vista con los cantones paginados
        return view('permission.index', compact('permissions'))
            ->with('i', (request()->input('page', 1) - 1) * $permissions->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = new Permission(); // Se crea una nueva instancia de permission

        $edicion = false;// Validar Edicion

        return view('permission.create', compact('permission', 'edicion'));// Se devuelve la vista con el formulario de creación
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Permission::$rules); // Se validan los datos del formulario

        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Verificar si el guard ya está presente en la solicitud
        $guard = $request->input('guard_name');
    
        if (empty($guard)) {
            // Si no se proporciona un guard, establecer el guard predeterminado (en este caso es web)
            $request->merge(['guard_name' => 'web']);
        }

        try {
            
            DB::beginTransaction();// Inicio de la transacción

            $nombre = Permission::where('name', $request->input('name'))->first(); // Se busca si ya existe un cantón con el mismo nombre
            if ($nombre) {
                return redirect()->route('permissions.create')->with('error', 'El permissions ya está registrado.');
            }

            Permission::create($request->all());// Creación del permiso

            DB::commit(); // Se confirma la transacción

            // Se redirige a la lista de permissions con un mensaje de éxito
            return redirect()->route('permissions.index')->with('success', 'Permiso creado exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('permissions.index')->with('error', 'Error al crear el permiso: ' . $e->getMessage());
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
            $permission = Permission::findOrFail($id); // Intenta encontrar el cantón por su ID

            return view('permission.show', compact('permission')); // Devuelve la vista con los detalles del permiso

        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el permiso, redirige a la lista de permisos con un mensaje de error
            return redirect()->route('permissions.index')->with('error', 'El permiso no existe.');
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
            $permission = Permission::findOrFail($id); // Intenta encontrar el cantón por su ID
            $edicion = true; // validacion de edicion

            return view('permission.edit', compact('permission', 'edicion')); // Devuelve la vista con el permiso a editar
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el cantón, redirige a la lista de cantones con un mensaje de error
            return redirect()->route('permissions.index')->with('error', 'El permiso no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $validator = Validator::make($request->all(), Permission::$rules); // Validar los datos del formulario
        
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {

            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $nombre = $request->input('name');// Obtener el nuevo nombre del permiso

            // Verificar si ya existe un permiso con el mismo nombre pero distinto ID
            $existingPermission = Permission::where('name', $nombre)->where('id', '!=', $permission->id)->first();
            if ($existingPermission) {
                return redirect()->route('permissions.index')->with('error', 'Ya existe un permiso con ese nombre.');
            }
    
            $permission->update($request->all());// Actualizar los datos del cantón con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('permissions.index')->with('success', 'Permiso actualizada exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('permissions.index')->with('error', 'Error al actualizar el permiso: ' . $e->getMessage());
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
    
            $permission = Permission::findOrFail($id);// Buscar el permisos por su ID
            $permission->delete();// Eliminar el permisos
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de permisos con un mensaje de éxito
            return redirect()->route('permissions.index')->with('success', 'Permiso borrado exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el permiso no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('permissions.index')->with('error', 'El permiso no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('permissions.index')->with('error', 'El permiso no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('permissions.index')->with('error', 'Error al eliminar el permiso: ' . $e->getMessage());
        }
    }
}
