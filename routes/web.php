<?php

use App\Http\Controllers\AsignacionController;
use App\Http\Controllers\AsignarController;
use App\Http\Controllers\AsignarVehiculoController;
use App\Http\Controllers\CantonController;
use App\Http\Controllers\CircuitoController;
use App\Http\Controllers\DependenciaController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MantenimientoController;
use App\Http\Controllers\MantestadoController;
use App\Http\Controllers\MantetipoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\NovedadeController;
use App\Http\Controllers\ParroquiaController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProvinciaController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\ReclamoController;
use App\Http\Controllers\ReclamosrController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SangreController;
use App\Http\Controllers\SubcircuitoController;
use App\Http\Controllers\TnovedadeController;
use App\Http\Controllers\TreclamoController;
use App\Http\Controllers\TvehiculoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubcircuitoController;
use App\Http\Controllers\VcargaController;
use App\Http\Controllers\VehiculoController;
use App\Http\Controllers\VehientregaController;
use App\Http\Controllers\VehirecepcioneController;
use App\Http\Controllers\VehisubcircuitoController;
use App\Http\Controllers\VpasajeroController;
use App\Models\Circuito;
use App\Models\Dependencia;
use App\Models\Mantestado;
use App\Models\Parroquia;
use App\Models\Reclamo;
use App\Models\Tnovedade;
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

    //Reportes
    
    Route::get('/general', [GeneralController::class, 'index'])->name('general');

    //Estados
    Route::resource('estados', EstadoController::class)->names('estados');
    Route::resource('asignacions', AsignacionController::class)->names('asignacions');

    //Datos Geograficos
    Route::resource('provincias', ProvinciaController::class)->names('provincias');
    Route::resource('cantons', CantonController::class)->names('cantons');
    Route::resource('parroquias', ParroquiaController::class)->names('parroquias');
    Route::get('/obtener-cantones/{provinciaId}', [ParroquiaController::class, 'getCantones']);
    
    //Roles y permisos
    Route::resource('roles', RoleController::class)->names('roles');
    Route::resource('permissions', PermissionController::class)->names('permissions');
    Route::resource('usuarios', AsignarController::class)->names('asignar');

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

    //Registro de Usuarios
    Route::resource('sangres', SangreController::class)->names('sangres');
    Route::resource('grados', GradoController::class)->names('grados');
    Route::resource('rangos', RangoController::class)->names('rangos');
    Route::resource('users', UserController::class)->names('users');
    Route::get('/obtener-rangos/{gradoId}', [UserController::class, 'getRangos']);
    Route::get('/obtener-cantones/{provinciaId}', [UserController::class, 'getCantones']);
    Route::get('/obtener-parroquias/{cantonId}', [UserController::class, 'getParroquias']);

    //Registro de vehículos
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

    //Vehículo Usuarios
    Route::resource('asignarvehiculos', AsignarVehiculoController::class)->names('asignarvehiculos');

    //Mantenimientos
    Route::resource('mantestados', MantestadoController::class)->names('mantestados');
    Route::resource('mantetipos', MantetipoController::class)->names('mantetipos');
    Route::resource('mantenimientos', MantenimientoController::class)->names('mantenimientos');
    Route::resource('tnovedades', TnovedadeController::class)->names('tnovedades');
    Route::resource('novedades', NovedadeController::class)->names('novedades');
    Route::resource('vehirecepciones', VehirecepcioneController::class)->names('vehirecepciones');
    Route::resource('vehientregas', VehientregaController::class)->names('vehientregas');
    // Nuevas rutas para aceptar y reasignar mantenimientos
    Route::get('/mantenimientos/{id}/aceptar', [MantenimientoController::class, 'aceptar'])->name('mantenimientos.aceptar');
    Route::post('/mantenimientos/{id}/reasignar', [MantenimientoController::class, 'reasignar'])->name('mantenimientos.reasignar');


    //Examen
    Route::resource('reclamos', ReclamoController::class)->names('reclamos');
    Route::resource('treclamos', TreclamoController::class)->names('treclamos');

    //Obtener Circuitos y subcircuito para reclamos
    Route::get('/obtener-subcircuitos/{circuitoId}', [ReclamoController::class, 'getSubcircuitos']);
    Route::get('/obtener-subcircuitos/{circuitoId}', [FormularioController::class, 'getSubcircuitos']);
    Route::get('reclamosr',[ReclamosrController::class, 'index'])->name('reclamo.reporteReclamo');
    Route::get('/filtro', [ReclamosrController::class, 'filtro']);
    
});
