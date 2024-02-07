<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\Canton;
use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Subcircuito;
use App\Models\User;
use App\Models\Usersubcircuito;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $usersubcircuitos = Usersubcircuito::paginate(10);

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
        //request()->validate(Usersubcircuito::$rules);
        // Validación personalizada para verificar si ya existe un registro para el usuario
        $userId = $request->input('user_id');
        $userEx = Usersubcircuito::where('user_id', $userId)->first();

        if ($userEx) {
            return redirect()->route('usersubcircuitos.create')
                ->with('error', 'Ya existe un registro para este usuario.');
        }

        // Si no hay un registro existente, procede con la creación del nuevo registro
        request()->validate(Usersubcircuito::$rules);


        $estado = $request->input('asignacion_id');

        if (empty($estado)) {
            // Si no se proporciona un estado, en este caso 1 = Activo
            $request->merge(['asignacion_id' => '1']);
        }

        $usersubcircuito = Usersubcircuito::create($request->all());

        return redirect()->route('usersubcircuitos.create')
            ->with('success', 'Usuario Subcircuito creado exitosamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usersubcircuito = Usersubcircuito::find($id);

        return view('usersubcircuito.show', compact('usersubcircuito'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usersubcircuito = Usersubcircuito::find($id);
        $d_user = User::all();
        $d_provincia = Provincia::all();
        $d_canton = Canton::all();
        $d_parroquia = Parroquia::all();
        $d_distrito = Distrito::all();
        $d_circuito = Circuito::all();
        $d_subcircuito = Subcircuito::all();
        $d_asignacion = Asignacion::all();

        $edicion = true;
        $edicion2 = false;
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
        /* request()->validate(Usersubcircuito::$rules);

        $usersubcircuito->update($request->all()); */

        // Reglas de validación
        $rules = [
            'user_id' => 'required',
            'provincia_id' => 'required',
            'canton_id' => 'required',
            'parroquia_id' => 'required',
            'distrito_id' => 'required',
            'circuito_id' => 'required',
            'subcircuito_id' => 'required',
            'asignacion_id' => 'required',
        ];

        // Validar los datos de la solicitud
        $validatedData = $request->validate($rules);

        // Verificar si la asignación es igual a 2 (No Asignado)
        if ($request->input('asignacion_id') == 2) {
            // Actualizar los campos a "No Asignado" sin borrar el registro
            $usersubcircuito->update([
                'provincia_id' => null,
                'canton_id' => null,
                'parroquia_id' => null,
                'distrito_id' => null,
                'circuito_id' => null,
                'subcircuito_id' => null,
                'asignacion_id' => 2,

            ]);

            return redirect()->route('usersubcircuitos.index')->with('success', 'Registro actualizado a "No Asignado".');
        }

        // Actualizar el Usersubcircuito con los nuevos datos
        $usersubcircuito->update($validatedData);
        return redirect()->route('usersubcircuitos.index')
            ->with('success', 'Usuario Subcircuito actualizado exitosamente.');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $usersubcircuito = Usersubcircuito::find($id)->delete();

        return redirect()->route('usersubcircuitos.index')
            ->with('success', 'Usuario Subcircuito borrado exitosamente.');
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
