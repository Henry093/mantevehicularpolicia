<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use TakiElias\Tablar\Http\Controllers\Controller;

class PersonaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');
        $query = User::query();
    
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
        $personas = $query->paginate(12);

        return view('persona.index', compact('personas'))
            ->with('i', (request()->input('page', 1) - 1) * $personas->perPage());
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
    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            $d_rol = Role::all();
    
            return view('user.show', compact('user', 'd_rol'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('persona.index')->with('error', 'El usuario no existe.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
