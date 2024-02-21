<?php

namespace App\Http\Controllers;

use App\Models\Novedade;
use App\Models\Tnovedade;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class NovedadeController
 * @package App\Http\Controllers
 */
class NovedadeController extends Controller
{
    // Constructor que establece los middleware para restringir el acceso a las acciones del controlador
    public function __construct()
    {
        $this->middleware('can:novedades.index')->only('index');
        $this->middleware('can:novedades.create')->only('create', 'store');
        $this->middleware('can:novedades.edit')->only('edit', 'update');
        $this->middleware('can:novedades.show')->only('show');
        $this->middleware('can:novedades.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');// Se obtiene el término de búsqueda
    
        $user_id = Auth::id();// Obtener el ID del usuario autenticado
    
        $user_roles = User::find($user_id)->roles->pluck('id')->toArray();// Obtener los roles del usuario autenticado
    
        $query = Novedade::query();// Iniciar la consulta para el modelo Novedade
    
        // Si el usuario tiene roles del 1 al 4, mostrar todos los registros
        if (in_array($user_roles, [1, 2, 3, 4])) {

            // No se hace ninguna restricción adicional, se muestran todos los registros

        } elseif (in_array(5, $user_roles)) { // Si el usuario tiene el rol 5

            // Mostrar solo los registros del usuario actual
            $query->whereHas('user', function ($q) use ($user_id) {
                $q->where('id', $user_id);
            });
        }
    
        // Si hay un término de búsqueda, se aplica el filtro  de búsqueda en la consulta
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('mensaje', 'like', '%' . $search . '%')
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('tnovedade', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
    
        $novedades = $query->paginate(12);// Se obtienen los novedades paginados
    
        // Se devuelve la vista con los novedades paginados
        return view('novedade.index', compact('novedades'))
            ->with('i', (request()->input('page', 1) - 1) * $novedades->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $novedade = new Novedade();// Se crea una nueva instancia de novedad
        $d_tnovedad = Tnovedade::all();// Se obtienen todas las tnovedad disponibles
        $user = auth()->user();// Se obtiene el usuario autenticado
        $edicion = false;//se valida si es edicion

        // Se devuelve la vista con el formulario de creación
        return view('novedade.create', compact('novedade', 'edicion', 'd_tnovedad', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), Novedade::$rules);// Se validan los datos del formulario
        // Si la validación falla, se redirige de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {

            DB::beginTransaction(); // Se inicia una transacción de base de datos

            $estado = $request->input('tnovedad_id');// Se obtiene el valor del parámetro 'tnovedad_id' 

            if (empty($estado)) {
                // Si no se proporciona un estado, en este caso 1 = Activo
                $request->merge(['tnovedad_id' => '1']);
            }

            $user_id = Auth::id();// Obtener el ID del usuario autenticado
            $request->merge(['user_id' => $user_id]);//se agrega a la solicitud
            
            Novedade::create($request->all());// Se crea un nuevo novedad con los datos proporcionados

            DB::commit();// Se confirma la transacción

            // Se redirige a la lista de novedades con un mensaje de éxito
            return redirect()->route('novedades.index')->with('success', 'Novedad creado exitosamente.');
        } catch (\Exception $e) {
            // En caso de error, se deshace la transacción y se redirige con un mensaje de error
            DB::rollBack();
            return redirect()->route('novedades.index')->with('error', 'Error al crear la novedad: ' . $e->getMessage());
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
            $novedade = Novedade::findOrFail($id);// Intenta encontrar el novedade por su ID

            return view('novedade.show', compact('novedade'));// Devuelve la vista con los detalles del novedad

        } catch (\Exception $e) {
            // Si no se encuentra el novedad, redirige a la lista de novedades con un mensaje de error
            return redirect()->route('novedades.index')->with('error', 'Error al mostrar la novedad: ' . $e->getMessage());
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
            $novedade = Novedade::findOrFail($id);// Intenta encontrar el novedad por su ID

            $d_tnovedad = Tnovedade::all();// Obtiene todas las tnovedades disponibles para mostrarlas en el formulario de edición

            $user = auth()->user(); // Aquí obtienes el usuario autenticado
    
            $edicion = true;//validacion de edicion
    
            return view('novedade.edit', compact('novedade', 'edicion', 'd_tnovedad', 'user'));// Devuelve la vista con el novedade a editar.
        } catch (\Exception $e) {
            // Si no se encuentra el novedade, redirige a la lista de novedades con un mensaje de error
            return redirect()->route('novedades.index')->with('error', 'Error al mostrar el formulario de edición: ' . $e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Novedade $novedade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Novedade $novedade)
    {
        $validator = Validator::make($request->all(), Novedade::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {

            $user_id = Auth::id();// Obtener el ID del usuario autenticado
            $user_roles = User::find($user_id)->roles->pluck('id')->toArray();// Obtener los roles del usuario autenticado
    
            // Validar si el estado de tnovedad es igual a 1 (Nuevo) para permitir la edición
            if ($novedade->tnovedad_id !== 1) {
                return redirect()->route('novedades.index')->with('error', 'No se puede editar esta novedad porque su estado es "' . $novedade->tnovedade->nombre. '".');
            }
    
            // Si el usuario tiene el rol 5, no permitir cambiar tnovedad_id a 2 (Atendido)
            if (in_array(5, $user_roles) && $request->input('tnovedad_id') == 2) {
                return redirect()->route('novedades.index')->with('error', 'No puedes cambiar el estado de esta novedad porque no estas autorizado.');
            }
            
            DB::beginTransaction();// Iniciar una transacción de base de datos
            
            $novedade->update($request->all());// Actualizar los datos del Novedad con los proporcionados en el formulario
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect()->route('novedades.index')->with('success', 'Novedad actualizada exitosamente.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('novedades.index')->with('error', 'Error al actualizar la novedad: ' . $e->getMessage());
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

            $novedade = Novedade::findOrFail($id);// Buscar el novedad por su ID
    
            // Validar si tnovedad_id es igual a '2'
            if ($novedade->tnovedad_id === 2) {
                return redirect()->route('novedades.index')->with('error', 'No se puede eliminar esta novedad porque su estado es "' . $novedade->tnovedade->nombre. '".');
            }
    
            $novedade->delete();// Eliminar el novedad
    
            DB::commit();// Confirmar la transacción
            
            // Redirigir a la lista de novedades con un mensaje de éxito
            return redirect()->route('novedades.index')->with('success', 'Novedad eliminada exitosamente.');
        } catch (ModelNotFoundException $e) {
            // En caso de que el novedad no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('novedades.index')->with('error', 'La novedad no existe.');
        
        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('novedades.index')->with('error', 'La novedad no puede eliminarse, tiene datos asociados.');
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('novedades.index')->with('error', 'Error al eliminar la novedad: ' . $e->getMessage());
        }
    }


    public function cambiarEstado($id)
    {
        try {
            DB::beginTransaction();// Iniciar una transacción de base de datos
    
            $novedade = Novedade::findOrFail($id);// Buscar el cantón por su ID
            $novedade->update(['tnovedad_id' => 2]);// Actualiza el estado de la novedad a 2 (Atendido)
    
            DB::commit();// Confirmar la transacción
    
            // Redirigir a la lista de cantones con un mensaje de éxito
            return redirect('/asignarvehiculos')->with('success', 'Asignar vehículo a: ' . $novedade->user->name . ' ' . $novedade->user->lastname );
        
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->back()->with('error', 'Error al cambiar el estado de la novedad: ' . $e->getMessage());
        }
    }
}