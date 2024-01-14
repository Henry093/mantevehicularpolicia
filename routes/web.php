<?php

use App\Http\Controllers\AsignacioneController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\CantonController;
use App\Http\Controllers\CircuitoController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\EmantenimientoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\EvehiculoController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\NmantenimientoController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\RmantenimientoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RvehiculoController;
use App\Http\Controllers\SangreController;
use App\Http\Controllers\SubcircuitoController;
use App\Http\Controllers\TmantenimientoController;
use App\Http\Controllers\TvehiculoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsubcircuitoController;
use App\Http\Controllers\VcargaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VpasajeroController;
use App\Http\Controllers\VsubcircuitoController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function(){
    
    Route::resource('users', UserController::class)->names('users');
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('usuarios', AsignarController::class)->names('asignar');

    Route::resource('estados', EstadoController::class)->names('estados');
    Route::resource('provincias', ProvinciaController::class)->names('provincias');
    Route::resource('cantons', CantonController::class)->names('cantons');
    Route::resource('parroquias', ParroquiaController::class)->names('parroquias');
    Route::resource('sangres', SangreController::class)->names('sangres');
    Route::resource('grados', GradoController::class)->names('grados');
    Route::resource('rangos', RangoController::class)->names('rangos');
    Route::resource('asignaciones', AsignacioneController::class)->names('asignaciones');
    Route::resource('distritos', DistritoController::class)->names('distritos');
    Route::resource('circuitos', CircuitoController::class)->names('circuitos');
    Route::resource('subcircuitos', SubcircuitoController::class)->names('subcircuitos');
    Route::resource('dependencias', DependenciaController::class)->names('dependencias');
    Route::resource('tvehiculos', TvehiculoController::class)->names('tvehiculos');
    Route::resource('marcas', MarcaController::class)->names('marcas');
    Route::resource('modelos', ModeloController::class)->names('modelos');
    Route::resource('vcargas', VcargaController::class)->names('vcargas');
    Route::resource('vpasajeros', VpasajeroController::class)->names('vpasajeros');
    Route::resource('vehiculos', VehiculoController::class)->names('vehiculos');
    Route::resource('usubcircuitos', UsubcircuitoController::class)->names('usubcircuitos');
    Route::resource('vsubcircuitos', VsubcircuitoController::class)->names('vsubcircuitos');
    Route::resource('emantenimientos', EmantenimientoController::class)->names('emantenimientos');
    Route::resource('tmantenimientos', TmantenimientoController::class)->names('tmantenimientos');
    Route::resource('nmantenimientos', NmantenimientoController::class)->names('nmantenimientos');
    Route::resource('rmantenimientos', RmantenimientoController::class)->names('rmantenimientos');
    Route::resource('rvehiculos', RvehiculoController::class)->names('rvehiculos');
    Route::resource('evehiculos', EvehiculoController::class)->names('evehiculos');


    
    Route::get('/obtener-cantones/{provinciaId}', [ParroquiaController::class, 'getCantones']);
    
    Route::get('/obtener-cantones/{provinciaId}', [DependenciaController::class, 'getCantones']);
    Route::get('/obtener-parroquias/{cantonId}', [DependenciaController::class, 'getParroquias']);
    
    Route::get('/obtener-cantones/{provinciaId}', [UserController::class, 'getCantones']);
    Route::get('/obtener-parroquias/{cantonId}', [UserController::class, 'getParroquias']);
    Route::get('/obtener-rangos/{gradoId}', [UserController::class, 'getRangos']);
});


Route::resource('/parroquia', App\Http\Controllers\ParroquiaController::class);
