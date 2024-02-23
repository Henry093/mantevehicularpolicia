<?php

namespace Database\Seeders;

use App\Models\Pertrecho;
use App\Models\Tpertrecho;
use App\Models\Treclamo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReclamoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Tipo Reclamo
        Treclamo::create(['nombre' => 'Reclamo']);
        Treclamo::create(['nombre' => 'Sugerencia']);

        Tpertrecho::create(['nombre' => 'Corta']);
        Tpertrecho::create(['nombre' => 'Larga']);

        Pertrecho::create(['tpertrecho_id' => '1', 'nombre' => 'Pistola', 'descripcion' => 'Glock 19', 'codigo' => 'PG_001']);
        Pertrecho::create(['tpertrecho_id' => '2', 'nombre' => 'Pistola', 'descripcion' => 'Taser', 'codigo' => 'PT_001']);
        Pertrecho::create(['tpertrecho_id' => '2', 'nombre' => 'Escopeta', 'descripcion' => 'Mosberg calibre 12 letal', 'codigo' => 'EM_001']);
        Pertrecho::create(['tpertrecho_id' => '2', 'nombre' => 'Escopeta', 'descripcion' => 'Mosberg calibre 12 no letal', 'codigo' => 'EM_002']);

        Pertrecho::create(['tpertrecho_id' => '2', 'nombre' => 'Fusil', 'descripcion' => 'M16', 'codigo' => 'FM_016']);
        Pertrecho::create(['tpertrecho_id' => '2', 'nombre' => 'Fusil', 'descripcion' => 'M4', 'codigo' => 'FM_004']);

        
        Pertrecho::create(['tpertrecho_id' => '2', 'nombre' => 'Carabina', 'descripcion' => 'Ruger', 'codigo' => 'CR_001']);
        
        Pertrecho::create(['tpertrecho_id' => '2', 'nombre' => 'Escopeta', 'descripcion' => 'Lanza gas truflite', 'codigo' => 'ELG_001']);
    }
}
