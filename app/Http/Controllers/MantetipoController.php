<?php

namespace App\Http\Controllers;

use App\Models\Mantetipo;
use Illuminate\Http\Request;

/**
 * Class MantetipoController
 * @package App\Http\Controllers
 */
class MantetipoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:mantetipos.index')->only('index');
        $this->middleware('can:mantetipos.create')->only('create', 'store');
        $this->middleware('can:mantetipos.edit')->only('edit', 'update');
        $this->middleware('can:mantetipos.show')->only('show');
        $this->middleware('can:mantetipos.destroy')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $search = request('search');
        $query = Mantetipo::query();
    
        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('valor', 'like', '%' . $search . '%')
                    ->orWhere('descripcion', 'like', '%' . $search . '%');
            });
        }
        $mantetipos = $query->paginate(12);

        return view('mantetipo.index', compact('mantetipos'))
            ->with('i', (request()->input('page', 1) - 1) * $mantetipos->perPage());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mantetipo = new Mantetipo();
        return view('mantetipo.create', compact('mantetipo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Mantetipo::$rules);

        $mantetipo = Mantetipo::create($request->all());

        return redirect()->route('mantetipos.index')
            ->with('success', 'Mantetipo created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mantetipo = Mantetipo::find($id);

        return view('mantetipo.show', compact('mantetipo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mantetipo = Mantetipo::find($id);

        return view('mantetipo.edit', compact('mantetipo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Mantetipo $mantetipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mantetipo $mantetipo)
    {
        request()->validate(Mantetipo::$rules);

        $mantetipo->update($request->all());

        return redirect()->route('mantetipos.index')
            ->with('success', 'Mantetipo updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $mantetipo = Mantetipo::find($id)->delete();

        return redirect()->route('mantetipos.index')
            ->with('success', 'Mantetipo deleted successfully');
    }
}
