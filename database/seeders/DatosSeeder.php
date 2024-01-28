<?php

namespace Database\Seeders;

use App\Models\Asignacion;
use App\Models\Estado;
use App\Models\Mantestado;
use App\Models\Mantestatu;
use App\Models\Mantestatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Estado
        Estado::create(['nombre' => 'Activo']);
        Estado::create(['nombre' => 'Inactivo']);
        Estado::create(['nombre' => 'Eliminado']);

        //Asignaciones
        Asignacion::create(['nombre' => 'Asignado']);
        Asignacion::create(['nombre' => 'No Asignado']);
        
        //Estatus mantenimeinto
        Mantestado::create(['nombre' => 'Enviado']);
        Mantestado::create(['nombre' => 'Aceptado']);
        Mantestado::create(['nombre' => 'Re-Asignado']);
        Mantestado::create(['nombre' => 'En Poceso']);
        Mantestado::create(['nombre' => 'Finalizado']);  
        
 
    }
}
