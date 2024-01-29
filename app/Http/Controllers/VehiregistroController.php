<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Mantetipo;
use App\Models\Vehiregistro;
use Illuminate\Http\Request;

/**
 * Class VehiregistroController
 * @package App\Http\Controllers
 */
class VehiregistroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehiregistros = Vehiregistro::paginate(10);
        

        return view('vehiregistro.index', compact('vehiregistros'))
            ->with('i', (request()->input('page', 1) - 1) * $vehiregistros->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $vehiregistro = new Vehiregistro();

        $d_mantenimientos = Mantenimiento::all();
        $d_mantetipos = Mantetipo::all();

        return view('vehiregistro.create', compact('vehiregistro', 'd_mantenimientos', 'd_mantetipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
                $vehiregistro = Vehiregistro::create($input);
    
                // Verificar si la ruta de la imagen se guardó correctamente en la base de datos
                if ($vehiregistro->imagen == 'images/' . $imageName) {
                    return redirect()->route('vehiregistros.index')
                        ->with('success', 'Vehiregistro created successfully.');
                } else {
                    // Si la ruta no se guardó correctamente, eliminar la imagen del servidor
                    unlink($imagePath);
    
                    // Devolver un mensaje de error
                    return redirect()->route('vehiregistros.index')
                        ->with('error', 'Error al guardar la imagen en la base de datos.');
                }
            } else {
                // Si la imagen no se guardó correctamente, devolver un mensaje de error
                return redirect()->route('vehiregistros.index')
                    ->with('error', 'Error al guardar la imagen en el servidor.');
            }
        } else {
            // Crear el nuevo registro de Vehiregistro sin imagen
            $vehiregistro = Vehiregistro::create($request->all());
    
            return redirect()->route('vehiregistros.index')
                ->with('success', 'Vehiregistro created successfully.');
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
        $vehiregistro = Vehiregistro::find($id);

        return view('vehiregistro.show', compact('vehiregistro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehiregistro = Vehiregistro::find($id);

        return view('vehiregistro.edit', compact('vehiregistro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Vehiregistro $vehiregistro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantenimiento $mantenimiento)
    {
        $request->validate([
            'imagen' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // ajusta los formatos y tamaños según necesites
        ]);
    
        $request = $this->getUserAndVehicleInfo($request);
    
        $mantenimiento->update($request->all());
        $this->saveImage($request, $mantenimiento);
    
        return redirect()->route('mantenimientos.index')
            ->with('success', 'Mantenimiento updated successfully');
    }
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $vehiregistro = Vehiregistro::find($id)->delete();

        return redirect()->route('vehiregistros.index')
            ->with('success', 'Vehiregistro deleted successfully');
    }
}
