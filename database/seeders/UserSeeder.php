<?php

namespace Database\Seeders;

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

		Permission::create(['name' =>'sangres.index', 'description' => 'Lista de tipo sangres'])->syncRoles([$rol1]);
		Permission::create(['name' =>'sangres.create', 'description' => 'Crear tipo sangre'])->syncRoles([$rol1]);
		Permission::create(['name' =>'sangres.edit', 'description' => 'Editar tipo sangre'])->syncRoles([$rol1]);
		Permission::create(['name' =>'sangres.show', 'description' => 'Ver tipo sangre'])->syncRoles([$rol1, $rol2]);
		Permission::create(['name' =>'sangres.destroy', 'description' => 'Eliminar tipo sangre'])->syncRoles([$rol1,$rol2]);

		Permission::create(['name' =>'users.index', 'description' => 'Lista de Usuarios'])->syncRoles([$rol1, $rol2, $rol3]);
		Permission::create(['name' =>'users.create', 'description' => 'Crear Usuario'])->syncRoles([$rol1, $rol2, $rol3]);
		Permission::create(['name' =>'users.edit', 'description' => 'Editar Usuario'])->syncRoles([$rol1, $rol2, $rol3]);
		Permission::create(['name' =>'users.show', 'description' => 'Ver Usuario'])->syncRoles([$rol1, $rol2, $rol3]);
		Permission::create(['name' =>'users.destroy', 'description' => 'Eliminar Usuario'])->syncRoles([$rol1,$rol2]);









        //Usuario 
		User::create([
			'name' => 'Henry A', 'lastname' => 'Ponce A', 'cedula' => '1700000000', 'fecha_nacimiento' => '2000-01-01',
			'sangre_id' => '1', 'provincia_id' => '11', 'canton_id' => '1', 'parroquia_id' => '1',
			'telefono' => '0999999991', 'grado_id' => '1', 'rango_id' => '1','usuario' => 'ecponcehe',
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
