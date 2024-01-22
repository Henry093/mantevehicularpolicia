<?php

namespace Database\Seeders;

use App\Models\Circuito;
use App\Models\Distrito;
use App\Models\Subcircuito;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DependenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Distritos
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '1', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1', 'nombre' => 'Macará', 'codigo' => '11D03', 'estado_id' => '1']);

        //Circuitos
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Vilcabamba', 'codigo' => '11D01C01', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Yangana', 'codigo' => '11D01C02', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Malacatos', 'codigo' => '11D01C03', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Taquil', 'codigo' => '11D01C04', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Zamora Huayco', 'codigo' => '11D01C05', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Esteban Godoy', 'codigo' => '11D01C06', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'El Paraiso', 'codigo' => '11D01C07', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Celi Roman', 'codigo' => '11D01C08', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'IV Centenario', 'codigo' => '11D01C09', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Tebaida', 'codigo' => '11D01C10', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Los Molinos', 'codigo' => '11D01C11', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Chontac Ruz', 'codigo' => '11D01C12', 'estado_id' => '1']);

        //Subcircuito
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '1', 'nombre' => 'Vilcabamba 1', 'codigo' => '11D01C01S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '2', 'nombre' => 'Yangana 1', 'codigo' => '11D01C02S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '3', 'nombre' => 'Malacatos 1', 'codigo' => '11D01C03S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '4', 'nombre' => 'Taquil 1', 'codigo' => '11D01C04S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '4', 'nombre' => 'Taquil 2', 'codigo' => '11D01C04S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '5', 'nombre' => 'Zanora Huayco 1', 'codigo' => '11D01C05S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '6', 'nombre' => 'Esteban Godoy 1', 'codigo' => '11D01C06S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '6', 'nombre' => 'Esteban Godoy 2', 'codigo' => '11D01C06S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '7', 'nombre' => 'El Paraiso 1', 'codigo' => '11D01C07S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '8', 'nombre' => 'Celi Roman 1', 'codigo' => '11D01C08S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '9', 'nombre' => 'IV Centenario 1', 'codigo' => '11D01C09S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '10', 'nombre' => 'Tebaida 1', 'codigo' => '11D01C10S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '11', 'nombre' => 'Los Molinos 1', 'codigo' => '11D01C11S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '12', 'nombre' => 'Chontac Ruz 1', 'codigo' => '11D01C12S01', 'estado_id' => '1']);
       
    }
}
