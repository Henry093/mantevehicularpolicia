<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Asignarvehiculo;
use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use App\Models\User;
use App\Models\Usersubcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

/**
 * Class UsersubcircuitoController
 * @package App\Http\Controllers
 */
class UsersubcircuitoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:usersubcircuitos.index')->only('index');
        $this->middleware('can:usersubcircuitos.create')->only('create', 'store');
        $this->middleware('can:usersubcircuitos.edit')->only('edit', 'update');
        $this->middleware('can:usersubcircuitos.show')->only('show');
        $this->middleware('can:usersubcircuitos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersubcircuitos = Usersubcircuito::paginate(12);
    
        return view('usersubcircuito.index', compact('usersubcircuitos'))
            ->with('i', (request()->input('page', 1) - 1) * $usersubcircuitos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Obtener todos los usuarios
        $d_user = User::whereNotIn('id', Usersubcircuito::where('asignacion_id', 1)->pluck('user_id')->toArray())
        ->whereNotIn('id', Usersubcircuito::where('asignacion_id', 2)->pluck('user_id')->toArray())
        ->whereNotIn('estado_id', [2, 3])
        ->get();

        $usersubcircuito = new Usersubcircuito();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $d_subcircuito = Subcircuito::all();

        $edicion = false;
        $edicion2 = true;

        return view('usersubcircuito.create', compact(
            'usersubcircuito',
            'd_user',
            'd_provincia',
            'd_canton',
            'd_parroquia',
            'd_distrito',
            'd_circuito',
            'd_subcircuito',
            'edicion',
            'edicion2'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validación de los datos de entrada según las reglas definidas en el modelo
        $validator = Validator::make($request->all(), Usersubcircuito::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
    
            DB::beginTransaction();
    
            $userId = $request->input('user_id');
            $userExistente = Usersubcircuito::where('user_id', $userId)->first();
            if ($userExistente) {
                return redirect()->route('usersubcircuitos.create')->with('error', 'Ya existe un registro para este usuario.');
            }
    
            $estado = $request->input('asignacion_id');
            if (empty($estado)) {
                $request->merge(['asignacion_id' => '1']);
            }
    
            Usersubcircuito::create($request->all());
    
            DB::commit();
    
            return redirect()->route('usersubcircuitos.index')
            ->with('success', 'Usuario asignado al Subcircuito creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('usersubcircuitos.index')
            ->with('error', 'Error al crear el usuario asignado al subcircuito: ' . $e->getMessage());
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
            // Intenta encontrar el Usersubcircuito con el ID proporcionado
            $usersubcircuito = Usersubcircuito::findOrFail($id);
    
            // Si se encuentra, mostrar la vista de detalle del Usersubcircuito
            return view('usersubcircuito.show', compact('usersubcircuito'));
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra, redirigir al usuario a alguna parte a la lista de Usersubcircuitos
            return redirect()->route('usersubcircuitos.index')->with('error', 'El usuario asignado al subcircuito no existe.');
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
            // Intenta encontrar el Usersubcircuito con el ID proporcionado
            $usersubcircuito = Usersubcircuito::findOrFail($id);
    
            // Obtener datos relacionados
            $d_user = User::all();
            $d_provincia = Provincia::all();
            $d_canton = Canton::all();
            $d_parroquia = Parroquia::all();
            $d_distrito = Distrito::all();
            $d_circuito = Circuito::all();
            $d_subcircuito = Subcircuito::all();
            $d_asignacion = Asignacion::all();
    
            // Establecer variables de edición
            $edicion = true;
            $edicion2 = false;
    
            // Pasar los datos a la vista de edición
            return view('usersubcircuito.edit', compact(
                'usersubcircuito',
                'd_user',
                'd_provincia',
                'd_canton',
                'd_parroquia',
                'd_distrito',
                'd_circuito',
                'd_subcircuito',
                'd_asignacion',
                'edicion',
                'edicion2'
            ));
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el Usersubcircuito, redirigir al usuario a la lista de Usersubcircuitos
            return redirect()->route('usersubcircuitos.index')->with('error', 'El usuario asignado al subcircuito no existe.');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Usersubcircuito $usersubcircuito
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usersubcircuito $usersubcircuito)
    {
        // Validación de los datos de entrada según las reglas definidas en el modelo
        $validator = Validator::make($request->all(), Usersubcircuito::$rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            // Reglas de validación
            $rules = [
                'user_id' => 'required',
                'asignacion_id' => ['required', Rule::in([1, 2])],
            ];
    
            // Validar los datos de la solicitud
            $validatedData = $request->validate($rules);
    
            DB::beginTransaction();
    
            // Verificar si la asignación es igual a 2 (No Asignado)
            if ($validatedData['asignacion_id'] == 2) {
                // Actualizar los campos a "No Asignado" sin borrar el registro
                $noAsignadoData = [
                    'provincia_id' => null,
                    'canton_id' => null,
                    'parroquia_id' => null,
                    'distrito_id' => null,
                    'circuito_id' => null,
                    'subcircuito_id' => null,
                    'asignacion_id' => 2,
                ];
    
                $usersubcircuito->update($noAsignadoData);
    
                DB::commit();
    
                return redirect()->route('usersubcircuitos.index')->with('success', 'Registro actualizado a "No Asignado".');
            }elseif($validatedData['asignacion_id'] == 1){
                // Actualizar los campos a "No Asignado" sin borrar el registro
                $AsignadoData = [
                    'provincia_id' => $request->input('provincia_id'),
                    'canton_id' => $request->input('canton_id'),
                    'parroquia_id' => $request->input('parroquia_id'),
                    'distrito_id' => $request->input('distrito_id'),
                    'circuito_id' => $request->input('circuito_id'),
                    'subcircuito_id' => $request->input('subcircuito_id'),
                    'asignacion_id' => 1,
                ];
    
                $usersubcircuito->update($AsignadoData);
    
                DB::commit();
    
                return redirect()->route('usersubcircuitos.index')->with('success', 'Registro actualizado a "Asignado".');
            }
    
            // Asegurarse de que se proporcionen valores válidos para los campos de ubicación
            $request->validate([
                'provincia_id' => 'required',
                'canton_id' => 'required',
                'parroquia_id' => 'required',
                'distrito_id' => 'required',
                'circuito_id' => 'required',
                'subcircuito_id' => 'required',
            ]);
    
            // Actualizar el Usersubcircuito con los nuevos datos
            $usersubcircuito->update($validatedData);
    
            DB::commit();
    
            return redirect()->route('usersubcircuitos.index')
                ->with('success', 'Usuario asignado al Subcircuito actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('usersubcircuitos.index')->with('error', 'Error al actualizar el usuario asignado al subcircuito: ' . $e->getMessage());
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
            // Verificar si el usuario está asignado a algún vehículo
            $user = Usersubcircuito::findOrFail($id);
            if ($user->vehiAsignado()) {
                return redirect()->route('usersubcircuitos.index')
                    ->with('error', 'No se puede eliminar el usuario porque está asignado a un vehículo.');
            }

            // Eliminar el usuario asignado al subcircuito
            $user->delete();

            // Redirigir al usuario a la lista de Usersubcircuitos con un mensaje de éxito
            return redirect()->route('usersubcircuitos.index')
                ->with('success', 'Usuario asignado al subcircuito borrado exitosamente.');
        } catch (ModelNotFoundException $e) {
            // Capturar si el Usersubcircuito no existe y redirigir al usuario con un mensaje de error
            return redirect()->route('usersubcircuitos.index')
                ->with('error', 'El Usuario asignado al subcircuito no existe.');
        } catch (QueryException $e) {
            // Capturar si hay un error de consulta (por ejemplo, restricciones de clave externa) y redirigir al usuario con un mensaje de error
            return redirect()->route('usersubcircuitos.index')
                ->with('error', 'Error al eliminar el usuario asignado al subcircuito: Hay datos asociados.');
        } catch (\Exception $e) {
            // Capturar cualquier otra excepción no esperada y redirigir al usuario con un mensaje de error
            return redirect()->route('usersubcircuitos.index')
                ->with('error', 'Error al eliminar el usuario asignado al subcircuito: ' . $e->getMessage());
        }
    }

    public function getCantonesus($provinciaId)
    {
        try {
            $cantones = Canton::where('provincia_id', $provinciaId)->pluck('nombre', 'id')->toArray();
            return response()->json($cantones);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Cantones no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getParroquiasus($cantonId)
    {
        try {
            $parroquias = Parroquia::where('canton_id', $cantonId)->pluck('nombre', 'id')->toArray();
            return response()->json($parroquias);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Parroquias no encontradas'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getDistritosus($parroquiaId)
    {
        try {
            $distritos = Distrito::where('parroquia_id', $parroquiaId)->pluck('nombre', 'id')->toArray();
            return response()->json($distritos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Distritos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getCircuitosus($distritoId)
    {
        try {
            $circuitos = Circuito::where('distrito_id', $distritoId)->pluck('nombre', 'id')->toArray();
            return response()->json($circuitos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'Circuitos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }
    public function getSubcircuitosus($circuitoId)
    {
        try {
            $subcircuitos = Subcircuito::where('circuito_id', $circuitoId)->pluck('nombre', 'id')->toArray();
            return response()->json($subcircuitos);
        } catch (ModelNotFoundException $e) {
            return new JsonResponse(['error' => 'SubCircuitos no encontrados'], 404);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Error interno del servidor'], 500);
        }
    }

    public function getInformacionUsuario($id)
    {
        try {
            $user = User::with('grado', 'rango')->findOrFail($id);
            return response()->json([
                'name' => $user->name,
                'lastname' => $user->lastname,
                'email' => $user->email,
                'grado' => $user->grado->nombre, // Accede al nombre del grado
                'rango' => $user->rango->nombre, // Accede al nombre del rango
                'cedula' => $user->cedula,
                'telefono' => $user->telefono,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error interno del servidor'], 500);
        }
    }
}
