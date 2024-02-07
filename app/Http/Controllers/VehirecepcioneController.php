<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Mantetipo;
use App\Models\Vehirecepcione;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

/**
 * Class VehirecepcioneController
 * @package App\Http\Controllers
 */
class VehirecepcioneController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:vehirecepciones.index')->only('index');
        $this->middleware('can:vehirecepciones.create')->only('create', 'store');
        $this->middleware('can:vehirecepciones.edit')->only('edit', 'update');
        $this->middleware('can:vehirecepciones.show')->only('show');
        $this->middleware('can:vehirecepciones.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request('search');
        $query = Vehirecepcione::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('fecha_ingreso', 'like', '%' . $search . '%')
                    ->orWhere('hora_ingreso', 'like', '%' . $search . '%')
                    ->orWhere('kilometraje', 'like', '%' . $search . '%')
                    ->orWhere('asunto', 'like', '%' . $search . '%')
                    ->orWhere('detalle', 'like', '%' . $search . '%')
                    ->orWhereHas('mantenimiento', function ($q) use ($search) {
                        $q->where('orden', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('mantetipo', function ($q) use ($search) {
                        $q->where('nombre', 'like', '%' . $search . '%');
                    });
            });
        }
        $vehirecepciones = $query->paginate(12);

        return view('vehirecepcione.index', compact('vehirecepciones'))
            ->with('i', (request()->input('page', 1) - 1) * $vehirecepciones->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $d_mantetipos = Mantetipo::all();
        $d_mantenimientos = Mantenimiento::whereNotIn('id', Vehirecepcione::pluck('mantenimientos_id'))->get();
        $vehirecepcione = new Vehirecepcione();
    
        return view('vehirecepcione.create', compact('vehirecepcione', 'd_mantetipos', 'd_mantenimientos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // ajusta los formatos y tamaños según necesites
        ]);
    
        $input = $request->all();
    
        if ($request->hasFile('imagen')) {
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images') . '/' . $imageName;
    
            if ($image->move(public_path('images'), $imageName)) {
                // Guardar la ruta de la imagen en el array de entrada
                $input['imagen'] = 'images/' . $imageName;
    
                // Crear el nuevo registro de Vehiregistro
                $vehiregistro = Vehirecepcione::create($input);
    
                // Verificar si la ruta de la imagen se guardó correctamente en la base de datos
                if ($vehiregistro->imagen == 'images/' . $imageName) {
                    return redirect()->route('vehirecepciones.index')
                        ->with('success', 'Vehiregistro created successfully.');
                } else {
                    // Si la ruta no se guardó correctamente, eliminar la imagen del servidor
                    unlink($imagePath);
    
                    // Devolver un mensaje de error
                    return redirect()->route('vehirecepciones.index')
                        ->with('error', 'Error al guardar la imagen en la base de datos.');
                }
            } else {
                // Si la imagen no se guardó correctamente, devolver un mensaje de error
                return redirect()->route('vehirecepciones.index')
                    ->with('error', 'Error al guardar la imagen en el servidor.');
            }
        } else {
            // Crear el nuevo registro de Vehiregistro sin imagen
            $vehiregistro = Vehirecepcione::create($request->all());
    
                
        return redirect()->route('vehirecepciones.index')
        ->with('success', 'Vehirecepcione created successfully.');
        }
    } catch (QueryException $e) {
            // Capturar la excepción y manejar el error de la base de datos
            return redirect()->route('vehirecepciones.create')
                ->with('error', 'Error no existe la orden de mantenimiento');
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
        $vehirecepcione = Vehirecepcione::find($id);

        return view('vehirecepcione.show', compact('vehirecepcione'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehirecepcione = Vehirecepcione::find($id);
        $d_mantetipos = Mantetipo::all();

        return view('vehirecepcione.edit', compact('vehirecepcione', 'd_mantetipos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehirecepcione $vehirecepcione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehirecepcione $vehirecepcione)
    {
        request()->validate(Vehirecepcione::$rules);
    
        // Verificar si se ha seleccionado una nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior del servidor
            if ($vehirecepcione->imagen) {
                unlink(public_path($vehirecepcione->imagen));
            }
    
            // Guardar la nueva imagen en el servidor y en la base de datos
            $image = $request->file('imagen');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = public_path('images') . '/' . $imageName;
    
            if ($image->move(public_path('images'), $imageName)) {
                // Actualizar el campo 'imagen' con la nueva ruta de la imagen
                $input['imagen'] = 'images/' . $imageName;
            } else {
                // Si la imagen no se guardó correctamente, devolver un mensaje de error
                return redirect()->route('vehirecepciones.edit', $vehirecepcione->id)
                    ->with('error', 'Error al guardar la imagen en el servidor.');
            }
        } else {
            // Si no se ha seleccionado una nueva imagen, mantener la imagen actual
            $input['imagen'] = $vehirecepcione->imagen;
        }
    
        // Actualizar los demás campos del registro
        $vehirecepcione->update($input);
    
        return redirect()->route('vehirecepciones.index')
            ->with('success', 'Vehirecepcione updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehirecepcione = Vehirecepcione::find($id)->delete();

        return redirect()->route('vehirecepciones.index')
            ->with('success', 'Vehirecepcione deleted successfully');
    }


}
