<?php

namespace Database\Seeders;

use App\Models\Dependencia;
use App\Models\Grado;
use App\Models\Rango;
use App\Models\Sangre;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //sangre
		Sangre::create(['nombre' => 'A+']);
		Sangre::create(['nombre' => 'A-']);
		Sangre::create(['nombre' => 'B+']);
		Sangre::create(['nombre' => 'B-']);
		Sangre::create(['nombre' => 'AB+']);
		Sangre::create(['nombre' => 'AB-']);
		Sangre::create(['nombre' => 'O+']);
		Sangre::create(['nombre' => 'O-']);

        //Grado
		Grado::create(['nombre' => 'Oficial']);
        Grado::create(['nombre' => 'Tropa']);

        //Rango
		Rango::create(['grado_id' => '1', 'nombre' => 'Teniente Coronel']);
		Rango::create(['grado_id' => '1', 'nombre' => 'Mayor']);
		Rango::create(['grado_id' => '1', 'nombre' => 'Capitán']);
		Rango::create(['grado_id' => '1', 'nombre' => 'Subteniente']);
		Rango::create(['grado_id' => '2', 'nombre' => 'Suboficial Segundo']);
		Rango::create(['grado_id' => '2', 'nombre' => 'Sargento Primero']);
		Rango::create(['grado_id' => '2', 'nombre' => 'Sargento Segundo']);
		Rango::create(['grado_id' => '2', 'nombre' => 'Cabo Primero']);
		Rango::create(['grado_id' => '2', 'nombre' => 'Cabo Segundo']);
		Rango::create(['grado_id' => '2', 'nombre' => 'Policía']);

		//Roles
		$rol1 = Role::create(['name' => 'Administrador']);
		$rol2 =Role::create(['name' => 'Alta Gerencia']);
		$rol3 =Role::create(['name' => 'Técnico 1']);
		$rol4 =Role::create(['name' => 'Técnico 2']);
		$rol5 =Role::create(['name' => 'Policía']);

		//Permisos
		Permission::create(['name' =>'home', 'description' => 'Ver Dashboard'])->syncRoles([$rol1, $rol2, $rol3, $rol4, $rol5]);
		//Roles y permisos
		Permission::create(['name' =>'roles.index', 'description' => 'Lista de Roles'])->syncRoles([$rol1]);
		Permission::create(['name' =>'roles.create', 'description' => 'Crear Rol'])->syncRoles([$rol1]);
		Permission::create(['name' =>'roles.edit', 'description' => 'Editar Rol'])->syncRoles([$rol1]);
		Permission::create(['name' =>'roles.show', 'description' => 'Ver Rol'])->syncRoles([$rol1]);
		Permission::create(['name' =>'roles.destroy', 'description' => 'Eliminar Rol'])->syncRoles([$rol1]);

		Permission::create(['name' =>'permissions.index', 'description' => 'Lista de Permisos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'permissions.create', 'description' => 'Crear Permisos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'permissions.edit', 'description' => 'Editar Permisos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'permissions.show', 'description' => 'Ver Permisos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'permissions.destroy', 'description' => 'Eliminar Permisos'])->syncRoles([$rol1]);
		//User Roles
		Permission::create(['name' =>'asignar.index', 'description' => 'Lista de Usuarios'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignar.create', 'description' => 'Crear asignar rol'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignar.edit', 'description' => 'Editar asignar rol'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignar.show', 'description' => 'Ver asignar rol'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignar.destroy', 'description' => 'Eliminar asignar rol'])->syncRoles([$rol1]);
		//Datos Geograficos
		//Provincias
		Permission::create(['name' =>'provincias.index', 'description' => 'Lista de provincias'])->syncRoles([$rol1]);
		Permission::create(['name' =>'provincias.create', 'description' => 'Crear provincia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'provincias.edit', 'description' => 'Editar provincia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'provincias.show', 'description' => 'Ver provincia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'provincias.destroy', 'description' => 'Eliminar provincia'])->syncRoles([$rol1]);
		//Cantones
		Permission::create(['name' =>'cantons.index', 'description' => 'Lista de cantones'])->syncRoles([$rol1]);
		Permission::create(['name' =>'cantons.create', 'description' => 'Crear cantón'])->syncRoles([$rol1]);
		Permission::create(['name' =>'cantons.edit', 'description' => 'Editar cantón'])->syncRoles([$rol1]);
		Permission::create(['name' =>'cantons.show', 'description' => 'Ver cantón'])->syncRoles([$rol1]);
		Permission::create(['name' =>'cantons.destroy', 'description' => 'Eliminar cantón'])->syncRoles([$rol1]);
		//Parroquias
		Permission::create(['name' =>'parroquias.index', 'description' => 'Lista de parroquias'])->syncRoles([$rol1]);
		Permission::create(['name' =>'parroquias.create', 'description' => 'Crear parroquia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'parroquias.edit', 'description' => 'Editar parroquia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'parroquias.show', 'description' => 'Ver parroquia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'parroquias.destroy', 'description' => 'Eliminar parroquia'])->syncRoles([$rol1]);
		//Personal
		//Tipo Sangre
		Permission::create(['name' =>'sangres.index', 'description' => 'Lista de tipo sangres'])->syncRoles([$rol1]);
		Permission::create(['name' =>'sangres.create', 'description' => 'Crear tipo sangre'])->syncRoles([$rol1]);
		Permission::create(['name' =>'sangres.edit', 'description' => 'Editar tipo sangre'])->syncRoles([$rol1]);
		Permission::create(['name' =>'sangres.show', 'description' => 'Ver tipo sangre'])->syncRoles([$rol1]);
		Permission::create(['name' =>'sangres.destroy', 'description' => 'Eliminar tipo sangre'])->syncRoles([$rol1]);
		//Grado
		Permission::create(['name' =>'grados.index', 'description' => 'Lista de grados'])->syncRoles([$rol1]);
		Permission::create(['name' =>'grados.create', 'description' => 'Crear grado'])->syncRoles([$rol1]);
		Permission::create(['name' =>'grados.edit', 'description' => 'Editar grado'])->syncRoles([$rol1]);
		Permission::create(['name' =>'grados.show', 'description' => 'Ver grado'])->syncRoles([$rol1]);
		Permission::create(['name' =>'grados.destroy', 'description' => 'Eliminar grado'])->syncRoles([$rol1]);
		//Rango
		Permission::create(['name' =>'rangos.index', 'description' => 'Lista de rangos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'rangos.create', 'description' => 'Crear rango'])->syncRoles([$rol1]);
		Permission::create(['name' =>'rangos.edit', 'description' => 'Editar rango'])->syncRoles([$rol1]);
		Permission::create(['name' =>'rangos.show', 'description' => 'Ver rango'])->syncRoles([$rol1]);
		Permission::create(['name' =>'rangos.destroy', 'description' => 'Eliminar rango'])->syncRoles([$rol1]);
		//Vehículo
		//Tipo Vehículo
		Permission::create(['name' =>'tvehiculos.index', 'description' => 'Lista de tipo vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tvehiculos.create', 'description' => 'Crear tipo vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tvehiculos.edit', 'description' => 'Editar tipo vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tvehiculos.show', 'description' => 'Ver tipo vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tvehiculos.destroy', 'description' => 'Eliminar tipo vehículo'])->syncRoles([$rol1]);
		//Marca Vehículo
		Permission::create(['name' =>'marcas.index', 'description' => 'Lista de marcas'])->syncRoles([$rol1]);
		Permission::create(['name' =>'marcas.create', 'description' => 'Crear marca'])->syncRoles([$rol1]);
		Permission::create(['name' =>'marcas.edit', 'description' => 'Editar marca'])->syncRoles([$rol1]);
		Permission::create(['name' =>'marcas.show', 'description' => 'Ver marca'])->syncRoles([$rol1]);
		Permission::create(['name' =>'marcas.destroy', 'description' => 'Eliminar marca'])->syncRoles([$rol1]);
		//Modelo Vehículo
		Permission::create(['name' =>'modelos.index', 'description' => 'Lista de modelos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'modelos.create', 'description' => 'Crear modelo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'modelos.edit', 'description' => 'Editar modelo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'modelos.show', 'description' => 'Ver modelo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'modelos.destroy', 'description' => 'Eliminar modelo'])->syncRoles([$rol1]);
		//Capacidad carga Vehículo
		Permission::create(['name' =>'vcargas.index', 'description' => 'Lista de capacidad carga de vehículos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vcargas.create', 'description' => 'Crear capacidad carga de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vcargas.edit', 'description' => 'Editar capacidad carga de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vcargas.show', 'description' => 'Ver capacidad carga de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vcargas.destroy', 'description' => 'Eliminar capacidad carga de vehículo'])->syncRoles([$rol1]);
		//Capacidad pasajero Vehículo
		Permission::create(['name' =>'vpasajeros.index', 'description' => 'Lista de capacidad pasajeros'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vpasajeros.create', 'description' => 'Crear capacidad pasajero'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vpasajeros.edit', 'description' => 'Editar capacidad pasajero'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vpasajeros.show', 'description' => 'Ver capacidad pasajero'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vpasajeros.destroy', 'description' => 'Eliminar capacidad pasajero'])->syncRoles([$rol1]);
		//Vehículos eliminados
		Permission::create(['name' =>'vehieliminacions.index', 'description' => 'Lista de vehículos eliminados'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehieliminacions.show', 'description' => 'Ver vehículos eliminados'])->syncRoles([$rol1]);
		//Reportes
		Permission::create(['name' =>'reportes.index', 'description' => 'Lista de Reportes'])->syncRoles([$rol1]);
		Permission::create(['name' =>'general.index', 'description' => 'Lista de Reportes General'])->syncRoles([$rol1]);
		//Mantenimiento
		//Tipo mantenimiento
		Permission::create(['name' =>'mantetipos.index', 'description' => 'Lista de tipo mantenimientos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantetipos.create', 'description' => 'Crear tipo mantenimiento'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantetipos.edit', 'description' => 'Editar tipo mantenimiento'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantetipos.show', 'description' => 'Ver tipo mantenimiento'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantetipos.destroy', 'description' => 'Eliminar tipo mantenimiento'])->syncRoles([$rol1]);
		//Tipo novedad
		Permission::create(['name' =>'tnovedades.index', 'description' => 'Lista de tipo novedades'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tnovedades.create', 'description' => 'Crear tipo novedad'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tnovedades.edit', 'description' => 'Editar tipo novedad'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tnovedades.show', 'description' => 'Ver tipo novedad'])->syncRoles([$rol1]);
		Permission::create(['name' =>'tnovedades.destroy', 'description' => 'Eliminar tipo novedad'])->syncRoles([$rol1]);
		//Estados
		//General
		Permission::create(['name' =>'estados.index', 'description' => 'Lista de estados'])->syncRoles([$rol1]);
		Permission::create(['name' =>'estados.create', 'description' => 'Crear estado'])->syncRoles([$rol1]);
		Permission::create(['name' =>'estados.edit', 'description' => 'Editar estado'])->syncRoles([$rol1]);
		Permission::create(['name' =>'estados.show', 'description' => 'Ver estado'])->syncRoles([$rol1]);
		Permission::create(['name' =>'estados.destroy', 'description' => 'Eliminar estado'])->syncRoles([$rol1]);
		//Asignación
		Permission::create(['name' =>'asignacions.index', 'description' => 'Lista de asignaciones'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignacions.create', 'description' => 'Crear asignacion'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignacions.edit', 'description' => 'Editar asignacion'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignacions.show', 'description' => 'Ver asignacion'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignacions.destroy', 'description' => 'Eliminar asignacion'])->syncRoles([$rol1]);
		//Mantenimiento
		Permission::create(['name' =>'mantestados.index', 'description' => 'Lista de estados mantenimiento'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantestados.create', 'description' => 'Crear estado mantenimiento'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantestados.edit', 'description' => 'Editar estado mantenimiento'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantestados.show', 'description' => 'Ver estado mantenimiento'])->syncRoles([$rol1]);
		Permission::create(['name' =>'mantestados.destroy', 'description' => 'Eliminar estado mantenimiento'])->syncRoles([$rol1]);
		//Dependencia
		//Distrito
		Permission::create(['name' =>'distritos.index', 'description' => 'Lista de distritos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'distritos.create', 'description' => 'Crear distrito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'distritos.edit', 'description' => 'Editar distrito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'distritos.show', 'description' => 'Ver distrito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'distritos.destroy', 'description' => 'Eliminar distrito'])->syncRoles([$rol1]);
		//Circuito
		Permission::create(['name' =>'circuitos.index', 'description' => 'Lista de circuitos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'circuitos.create', 'description' => 'Crear circuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'circuitos.edit', 'description' => 'Editar circuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'circuitos.show', 'description' => 'Ver circuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'circuitos.destroy', 'description' => 'Eliminar circuito'])->syncRoles([$rol1]);
		//Subcircuito
		Permission::create(['name' =>'subcircuitos.index', 'description' => 'Lista de subcircuitos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'subcircuitos.create', 'description' => 'Crear subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'subcircuitos.edit', 'description' => 'Editar subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'subcircuitos.show', 'description' => 'Ver subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'subcircuitos.destroy', 'description' => 'Eliminar subcircuito'])->syncRoles([$rol1]);
		//Dependencia
		Permission::create(['name' =>'dependencias.index', 'description' => 'Lista de dependencias'])->syncRoles([$rol1]);
		Permission::create(['name' =>'dependencias.create', 'description' => 'Crear dependencia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'dependencias.edit', 'description' => 'Editar dependencia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'dependencias.show', 'description' => 'Ver dependencia'])->syncRoles([$rol1]);
		Permission::create(['name' =>'dependencias.destroy', 'description' => 'Eliminar dependencia'])->syncRoles([$rol1]);
		//Personal
		//Usuario
		Permission::create(['name' =>'users.index', 'description' => 'Lista de Usuarios'])->syncRoles([$rol1]);
		Permission::create(['name' =>'users.create', 'description' => 'Crear Usuario'])->syncRoles([$rol1]);
		Permission::create(['name' =>'users.edit', 'description' => 'Editar Usuario'])->syncRoles([$rol1]);
		Permission::create(['name' =>'users.show', 'description' => 'Ver Usuario'])->syncRoles([$rol1]);
		Permission::create(['name' =>'users.destroy', 'description' => 'Eliminar Usuario'])->syncRoles([$rol1]);
		//Vehículo
		Permission::create(['name' =>'vehiculos.index', 'description' => 'Lista de vehículos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehiculos.create', 'description' => 'Crear vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehiculos.edit', 'description' => 'Editar vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehiculos.show', 'description' => 'Ver vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehiculos.destroy', 'description' => 'Eliminar vehículo'])->syncRoles([$rol1]);
		//User Subcircuito
		Permission::create(['name' =>'usersubcircuitos.index', 'description' => 'Lista de usuarios vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'usersubcircuitos.create', 'description' => 'Crear usuarios vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'usersubcircuitos.edit', 'description' => 'Editar usuarios vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'usersubcircuitos.show', 'description' => 'Ver usuarios vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'usersubcircuitos.destroy', 'description' => 'Eliminar usuarios vinculados al subcircuito'])->syncRoles([$rol1]);
		//Vehículo Subcircuito
		Permission::create(['name' =>'vehisubcircuitos.index', 'description' => 'Lista de vehículos vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehisubcircuitos.create', 'description' => 'Crear vehículos vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehisubcircuitos.edit', 'description' => 'Editar vehículos vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehisubcircuitos.show', 'description' => 'Ver vehículos vinculados al subcircuito'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehisubcircuitos.destroy', 'description' => 'Eliminar vehículos vinculados al subcircuito'])->syncRoles([$rol1]);
		//User Vehículo
		Permission::create(['name' =>'asignarvehiculos.index', 'description' => 'Lista de vehículos asignados a usuarios'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignarvehiculos.create', 'description' => 'Crear vehículos asignados a usuarios'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignarvehiculos.edit', 'description' => 'Editar vehículos asignados a usuarios'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignarvehiculos.show', 'description' => 'Ver vehículos asignados a usuarios'])->syncRoles([$rol1]);
		Permission::create(['name' =>'asignarvehiculos.destroy', 'description' => 'Eliminar vehículos asignados a usuarios'])->syncRoles([$rol1]);
		//Mantenimiento
		//Registrar
		Permission::create(['name' =>'mantenimientos.index', 'description' => 'Lista de mantenimientos'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'mantenimientos.create', 'description' => 'Crear mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'mantenimientos.edit', 'description' => 'Editar mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'mantenimientos.show', 'description' => 'Ver mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'mantenimientos.destroy', 'description' => 'Eliminar mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		//Novedades
		Permission::create(['name' =>'novedades.index', 'description' => 'Lista de novedades mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'novedades.create', 'description' => 'Crear novedad mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'novedades.edit', 'description' => 'Editar novedad mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'novedades.show', 'description' => 'Ver novedad mantenimiento'])->syncRoles([$rol1,$rol2,$rol3,$rol4,$rol5]);
		Permission::create(['name' =>'novedades.destroy', 'description' => 'Eliminar novedad mantenimiento'])->syncRoles([$rol1]);
		//Recepcion vehiculo
		Permission::create(['name' =>'vehirecepciones.index', 'description' => 'Lista de recepción de vehículos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehirecepciones.create', 'description' => 'Crear recepción de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehirecepciones.edit', 'description' => 'Editar recepción de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehirecepciones.show', 'description' => 'Ver recepción de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehirecepciones.destroy', 'description' => 'Eliminar recepción de vehículo'])->syncRoles([$rol1]);
		//Entrega vehiculo
		Permission::create(['name' =>'vehientregas.index', 'description' => 'Lista de entrega de vehículos'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehientregas.create', 'description' => 'Crear entrega de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehientregas.edit', 'description' => 'Editar entrega de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehientregas.show', 'description' => 'Ver entrega de vehículo'])->syncRoles([$rol1]);
		Permission::create(['name' =>'vehientregas.destroy', 'description' => 'Eliminar entrega de vehículo'])->syncRoles([$rol1]);
		







        //Usuario 
		User::create([
			'name' => 'Henry A', 'lastname' => 'Ponce A', 'cedula' => '1700000000', 'fecha_nacimiento' => '2000-01-01',
			'sangre_id' => '1', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '1',
			'telefono' => '0999999990', 'grado_id' => '1', 'rango_id' => '1','usuario' => 'ecponcehe',
			'email' => 'hbponce@policianacional.gob.ec',  'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'),
			 'estado_id' => '1'])->assignRole ('Administrador');

		User::create([
			'name' => 'Henry B', 'lastname' => 'Ponce B', 'cedula' => '1700000002', 'fecha_nacimiento' => '1999-01-01',
			'sangre_id' => '2', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '2',
			'telefono' => '0999999991', 'grado_id' => '1', 'rango_id' => '2','usuario' => 'ecponcehe2',
			'email' => 'hbponce2@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Alta Gerencia');
       
		User::create([
			'name' => 'Henry C', 'lastname' => 'Ponce C', 'cedula' => '1700000003', 'fecha_nacimiento' => '1999-01-02',
			'sangre_id' => '3', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '3',
			'telefono' => '0999999993', 'grado_id' => '1', 'rango_id' => '3', 'usuario' => 'ecponcehe3',
			'email' => 'hbponce3@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Técnico 1');

		User::create([
			'name' => 'Henry D', 'lastname' => 'Ponce D', 'cedula' => '1700000004', 'fecha_nacimiento' => '1999-01-04',
			'sangre_id' => '4', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '4',
			'telefono' => '0999999994', 'grado_id' => '1', 'rango_id' => '4', 'usuario' => 'ecponcehe4',
			'email' => 'hbponce4@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Técnico 2');

		//Usuario Tropa
		User::create([
			'name' => 'Henry E', 'lastname' => 'Ponce E', 'cedula' => '1700000005', 'fecha_nacimiento' => '1999-01-05',
			'sangre_id' => '5', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '5',
			'telefono' => '0999999995', 'grado_id' => '2', 'rango_id' => '5', 'usuario' => 'ecponcehe5',
			'email' => 'hbponce5@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Policia');

		User::create([
			'name' => 'Henry F', 'lastname' => 'Ponce F', 'cedula' => '1700000006', 'fecha_nacimiento' => '1999-01-06',
			'sangre_id' => '6', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '6',
			'telefono' => '0999999996', 'grado_id' => '2', 'rango_id' => '6','usuario' => 'ecponcehe6',
			'email' => 'hbponce6@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Policia');

		User::create([
			'name' => 'Henry G', 'lastname' => 'Ponce G', 'cedula' => '1700000007', 'fecha_nacimiento' => '1999-01-07',
			'sangre_id' => '7', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '7',
			'telefono' => '0999999997', 'grado_id' => '2', 'rango_id' => '7', 'usuario' => 'ecponcehe7',
			'email' => 'hbponce7@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Policia');

		User::create([
			'name' => 'Henry H', 'lastname' => 'Ponce H', 'cedula' => '1700000008', 'fecha_nacimiento' => '1999-01-08',
			'sangre_id' => '1', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '8',
			'telefono' => '0999999998', 'grado_id' => '2', 'rango_id' => '8','usuario' => 'ecponcehe8',
			'email' => 'hbponce8@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Policia');

		User::create([
			'name' => 'Henry I', 'lastname' => 'Ponce I', 'cedula' => '1700000009', 'fecha_nacimiento' => '1999-01-09',
			'sangre_id' => '2', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '9',
			'telefono' => '0999999999', 'grado_id' => '2', 'rango_id' => '9', 'usuario' => 'ecponcehe9',
			'email' => 'hbponce9@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
		])->assignRole ('Policia');

		User::create([
			'name' => 'Henry J', 'lastname' => 'Ponce J', 'cedula' => '1700000010', 'fecha_nacimiento' => '1999-01-10',
			'sangre_id' => '1', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '10',
			'telefono' => '0999999910', 'grado_id' => '2', 'rango_id' => '10', 'usuario' => 'ecponcehe10',
			'email' => 'hbponce10@policianacional.gob.ec', 'email_verified_at' => '2023-01-01', 'password' => Hash::make('Policia2024'), 'estado_id' => '1'
        ])->assignRole ('Policia'); 
    }
}
