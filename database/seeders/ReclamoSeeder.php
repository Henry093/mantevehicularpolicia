<?php

namespace Database\Seeders;

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
    }
}
