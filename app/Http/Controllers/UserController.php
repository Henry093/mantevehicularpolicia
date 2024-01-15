<?php

namespace App\Http\Controllers;

use App\Models\Canton;
use App\Models\Estado;
use App\Models\Grado;
use App\Models\Parroquia;
use App\Models\Provincia;
use App\Models\Rango;
use App\Models\Sangre;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);

        return view('user.index', compact('users'))
            ->with('i', (request()->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = new User();
        $dsangre = Sangre::all();
        $dprovincia = Provincia::all();
        $dcanton = Canton::all();
        $dparroquia = Parroquia::all();
        $dgrado = Grado::all();
        $drango = Rango::all();
        $destado = Estado::all();

        return view('user.create', compact('user', 'dsangre', 'dprovincia', 'dcanton', 'dparroquia', 'dgrado', 'drango', 'destado'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(User::$rules);

        $user = User::create($request->all());

        return redirect()->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $dsangre = Sangre::all();

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $dsangre = Sangre::all();
        $dprovincia = Provincia::all();
        $dcanton = Canton::all();
        $dparroquia = Parroquia::all();
        $dgrado = Grado::all();
        $drango = Rango::all();
        $destado = Estado::all();

        return view('user.edit', compact('user', 'dsangre', 'dprovincia', 'dcanton', 'dparroquia', 'dgrado', 'drango', 'destado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        request()->validate(User::$rules);

        $user->update($request->all());
        $dsangre = Sangre::all();

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
