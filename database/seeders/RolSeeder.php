<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
        Permission::create(['name' =>'sangres.show', 'description' => 'Ver tipo sangre'])->syncRoles([$rol1, $rol2, $rol3, $rol4, $rol5]);
        Permission::create(['name' =>'sangres.destroy', 'description' => 'Eliminar tipo sangre'])->syncRoles([$rol1,$rol2,]);
    }
}
