<?php

namespace App\Http\Controllers;

use App\Models\Asignacion;
use App\Models\User;
use Illuminate\Http\Request;

class UserSubcircuitoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        $asignacion = Asignacion::all();


        return view('user.subcircuito.assign', compact('users', 'asignacion'))
        ->with('i', (request()->input('page', 1) - 1) * $users->perPage());;
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
