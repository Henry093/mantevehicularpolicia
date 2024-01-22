<?php

use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\CantonController;
use App\Http\Controllers\CircuitoController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\EmantenimientoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\EvehiculoController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\NmantenimientoController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\ReclamoController;
use App\Http\Controllers\ReclamosrController;
use App\Http\Controllers\RmantenimientoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RvehiculoController;
use App\Http\Controllers\SangreController;
use App\Http\Controllers\SubcircuitoController;
use App\Http\Controllers\TmantenimientoController;
use App\Http\Controllers\TreclamoController;
use App\Http\Controllers\TvehiculoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubcircuitoController;
use App\Http\Controllers\UsubcircuitoController;
use App\Http\Controllers\VcargaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VehisubcircuitoController;
use App\Http\Controllers\VpasajeroController;
use App\Http\Controllers\VsubcircuitoController;
use App\Models\Circuito;
use App\Models\Dependencia;
use App\Models\Parroquia;
use App\Models\Reclamo;
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

Route::get('formulario',[FormularioController::class, 'index'])->name('reclamo.indexPublic');
Route::post('formulario',[FormularioController::class, 'store'])->name('reclamo.store');


Route::group(['middleware' => ['auth']], function(){
    
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    //Estados
    Route::resource('estados', EstadoController::class)->names('estados');
    Route::resource('asignacions', AsignacionController::class)->names('asignacions');
    Route::resource('emantenimientos', EmantenimientoController::class)->names('emantenimientos');

    //Datos Geograficos
    Route::resource('provincias', ProvinciaController::class)->names('provincias');
    Route::resource('cantons', CantonController::class)->names('cantons');
    Route::resource('parroquias', ParroquiaController::class)->names('parroquias');
    Route::get('/obtener-cantones/{provinciaId}', [ParroquiaController::class, 'getCantones']);

    //Roles y permisos
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('usuarios', AsignarController::class)->names('asignar');

    //Usuarios
    Route::resource('sangres', SangreController::class)->names('sangres');
    Route::resource('grados', GradoController::class)->names('grados');
    Route::resource('rangos', RangoController::class)->names('rangos');
    Route::resource('users', UserController::class)->names('users');
    Route::get('/obtener-rangos/{gradoId}', [UserController::class, 'getRangos']);
    Route::get('/obtener-cantones/{provinciaId}', [UserController::class, 'getCantones']);
    Route::get('/obtener-parroquias/{cantonId}', [UserController::class, 'getParroquias']);

    //Distrito
    Route::resource('distritos', DistritoController::class)->names('distritos');
    Route::get('/obtener-cantones-d/{provinciaId}', [DistritoController::class, 'getCantonesd']);
    Route::get('/obtener-parroquias-d/{cantonId}', [DistritoController::class, 'getParroquiasd']);
    //Circuito
    Route::resource('circuitos', CircuitoController::class)->names('circuitos');
    Route::get('/obtener-cantones-c/{provinciaId}', [CircuitoController::class, 'getCantonesc']);
    Route::get('/obtener-parroquias-c/{cantonId}', [CircuitoController::class, 'getParroquiasc']);
    Route::get('/obtener-distritos-c/{parroquiaId}', [CircuitoController::class, 'getDistritosc']);
    //Subcircuito
    Route::resource('subcircuitos', SubcircuitoController::class)->names('subcircuitos');
    Route::get('/obtener-cantones-s/{provinciaId}', [SubcircuitoController::class, 'getCantoness']);
    Route::get('/obtener-parroquias-s/{cantonId}', [SubcircuitoController::class, 'getParroquiass']);
    Route::get('/obtener-distritos-s/{parroquiaId}', [SubcircuitoController::class, 'getDistritoss']);
    Route::get('/obtener-circuitos-s/{distritoId}', [SubcircuitoController::class, 'getCircuitoss']);

    //Dependencia
    Route::resource('dependencias', DependenciaController::class)->names('dependencias');
    Route::get('/obtener-cantones/{provinciaId}', [DependenciaController::class, 'getCantones']);
    Route::get('/obtener-parroquias/{cantonId}', [DependenciaController::class, 'getParroquias']);
    Route::get('/obtener-distritos/{cantonId}', [DependenciaController::class, 'getDistritos']);
    Route::get('/obtener-circuitos/{distritoId}', [DependenciaController::class, 'getCircuitos']);
    Route::get('/obtener-subcircuitos/{circuitoId}', [DependenciaController::class, 'getSubcircuitos']);    

    //Registro de veículo
    Route::resource('tvehiculos', TvehiculoController::class)->names('tvehiculos');//tipo de vehiculos
    Route::resource('marcas', MarcaController::class)->names('marcas');
    Route::resource('modelos', ModeloController::class)->names('modelos');
    Route::resource('vcargas', VcargaController::class)->names('vcargas');//capacidad carga
    Route::resource('vpasajeros', VpasajeroController::class)->names('vpasajeros');//capacidad pasajeros
    Route::resource('vehiculos', VehiculoController::class)->names('vehiculos');
    Route::get('/obtener-marcas/{tvehiculoId}', [VehiculoController::class, 'getMarcas']);
    Route::get('/obtener-modelos/{marcaId}', [VehiculoController::class, 'getModelos']);

    //Usuario Subcircuito
    Route::resource('usersubcircuitos', UserSubcircuitoController::class)->names('usersubcircuitos');
    Route::get('/obtener-cantones-us/{provinciaId}', [UsersubcircuitoController::class, 'getCantonesus']);
    Route::get('/obtener-parroquias-us/{cantonId}', [UsersubcircuitoController::class, 'getParroquiasus']);
    Route::get('/obtener-distritos-us/{parroquiaId}', [UsersubcircuitoController::class, 'getDistritosus']);
    Route::get('/obtener-circuitos-us/{distritoId}', [UsersubcircuitoController::class, 'getCircuitosus']);
    Route::get('/obtener-subcircuitos-us/{circuitoId}', [UsersubcircuitoController::class, 'getSubcircuitosus']);
    Route::get('/obtener-informacion-usuario/{id}', [UsersubcircuitoController::class, 'getInformacionUsuario']);

    //Vehículo Subcircuito
    Route::resource('vehisubcircuitos', VehisubcircuitoController::class)->names('vehisubcircuitos');
    Route::get('/obtener-cantones-vs/{provinciaId}', [VehisubcircuitoController::class, 'getCantonesvs']);
    Route::get('/obtener-parroquias-vs/{cantonId}', [VehisubcircuitoController::class, 'getParroquiasvs']);
    Route::get('/obtener-distritos-vs/{parroquiaId}', [VehisubcircuitoController::class, 'getDistritosvs']);
    Route::get('/obtener-circuitos-vs/{distritoId}', [VehisubcircuitoController::class, 'getCircuitosvs']);
    Route::get('/obtener-subcircuitos-vs/{circuitoId}', [VehisubcircuitoController::class, 'getSubcircuitosvs']);
    Route::get('/obtener-informacion-vehiculo/{id}', [VehisubcircuitoController::class, 'getInformacionVehiculo']);

    //Mantenimientos
    Route::resource('tmantenimientos', TmantenimientoController::class)->names('tmantenimientos'); //tipo mantenimiento
    Route::resource('nmantenimientos', NmantenimientoController::class)->names('nmantenimientos');//reporte novedad
    Route::resource('rmantenimientos', RmantenimientoController::class)->names('rmantenimientos');//registro mantenimiento
    Route::resource('rvehiculos', RvehiculoController::class)->names('rvehiculos');//recepcion vehiculos
    Route::resource('evehiculos', EvehiculoController::class)->names('evehiculos');//entrega vehiculos
    
    //Examen
    Route::resource('reclamos', ReclamoController::class)->names('reclamos');
    Route::resource('treclamos', TreclamoController::class)->names('treclamos');
    


    Route::get('/obtener-cantones/{provinciaId}', [ParroquiaController::class, 'getCantones']);

    Route::get('/obtener-cantones/{provinciaId}', [DependenciaController::class, 'getCantones']);
    Route::get('/obtener-parroquias/{cantonId}', [DependenciaController::class, 'getParroquias']);

    


    //Obtener Circuitos y subcircuito para reclamos
    Route::get('/obtener-subcircuitos/{circuitoId}', [ReclamoController::class, 'getSubcircuitos']);
    Route::get('/obtener-subcircuitos/{circuitoId}', [FormularioController::class, 'getSubcircuitos']);

    Route::get('/rmantenimientos/{id}', [RmantenimientoController::class, 'show'])->name('rmantenimientos.show');

    Route::get('reclamosr',[ReclamosrController::class, 'index'])->name('reclamo.reporteReclamo');
    Route::get('/filtro', [ReclamosrController::class, 'filtro']);
    

});


Route::resource('/vehisubcircuito', App\Http\Controllers\VehisubcircuitoController::class);
