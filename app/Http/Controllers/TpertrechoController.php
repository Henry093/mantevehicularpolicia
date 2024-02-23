<?php

namespace App\Http\Controllers;

use App\Models\Tpertrecho;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class TpertrechoController
 * @package App\Http\Controllers
 */
class TpertrechoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tpertrechos = Tpertrecho::paginate(10);

        return view('tpertrecho.index', compact('tpertrechos'))
            ->with('i', (request()->input('page', 1) - 1) * $tpertrechos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tpertrecho = new Tpertrecho();
        return view('tpertrecho.create', compact('tpertrecho'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), Tpertrecho::$rules);// Validar los datos del formulario
    
        // Si la validación falla, redirigir de nuevo al formulario con los errores
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        try {

            DB::beginTransaction();// Iniciar una transacción de base de datos


            Tpertrecho::create($request->all());

            DB::commit();// Confirmar la transacción

        return redirect()->route('tpertrechos.index')
            ->with('success', 'Tpertrecho created successfully.');

        } catch (\Exception $e) {
            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tpertrechos.index')->with('error', 'Error al crear el tpertrecho: ' . $e->getMessage());
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
            $tpertrecho = Tpertrecho::findOrFail($id);;

            return view('tpertrecho.show', compact('tpertrecho'));
        } catch (ModelNotFoundException $e) {
            // En caso de que el distrito no exista, redirigir a la lista de distritos con un mensaje de error
            return redirect()->route('tpertrecho.index')->with('error', 'El tipo pertrecho no existe.');
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

            $tpertrecho = Tpertrecho::find($id);

            return view('tpertrecho.edit', compact('tpertrecho'));
        } catch (ModelNotFoundException $e) {
            // En caso de que el distrito no exista, redirigir a la lista de distritos con un mensaje de error
           return redirect()->route('tpertrecho.index')->with('error', 'El tpertrecho no existe.');
       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Tpertrecho $tpertrecho
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tpertrecho $tpertrecho)
    {
        $validator = Validator::make($request->all(), Tpertrecho::$rules);// Validar los datos del formulario

        // Si la validación falla, redirigir de nuevo al formulario con los errores
       if ($validator->fails()) {
           return back()->withErrors($validator)->withInput();
       }
       

        try {
            DB::beginTransaction();
            $tpertrecho->update($request->all());

            return redirect()->route('tpertrechos.index')
                ->with('success', 'Tpertrecho updated successfully');
        } catch (\Exception $e) {

            // En caso de error, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tpertrechos.index')->with('error', 'Error al actualizar el tpertrecho: ' . $e->getMessage());
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

            $tpertrecho = Tpertrecho::findOrFail($id);// Buscar el cantón por su ID
            $tpertrecho->delete();// Eliminar el Distrito

            DB::commit();// Confirmar la transacción

            // Redirigir a la lista de Distritos con un mensaje de éxito
            return redirect()->route('distritos.index')->with('success', 'Distrito borrado exitosamente.');

        } catch (ModelNotFoundException $e) {
            // En caso de que el Distrito no exista, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tpertrechos.index')->with('error', 'El tipo pertrecho no existe.');

        } catch (QueryException $e) {
            // En caso de que no se pueda eliminar debido a datos asociados, deshacer la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tpertrechos.index')->with('error', 'El tipo pertrecho no puede eliminarse, tiene datos asociados.');
            
        } catch (\Exception $e) {
            // En caso de error, deshace la transacción y redirigir con un mensaje de error
            DB::rollBack();
            return redirect()->route('tpertrechos.index')->with('error', 'Error al eliminar el tipo pertrecho: ' . $e->getMessage());
        }
    }
}
