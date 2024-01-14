<?php

namespace Database\Seeders;

use App\Models\Canton;
use App\Models\Parroquia;
use App\Models\Provincia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeograficoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Provincias
        Provincia::create(['nombre' => 'Azuay']);
        Provincia::create(['nombre' => 'Bolívar']);
        Provincia::create(['nombre' => 'Cañar']);
        Provincia::create(['nombre' => 'Carchi']);
        Provincia::create(['nombre' => 'Cotopaxi']);
        Provincia::create(['nombre' => 'Chimborazo']);
        Provincia::create(['nombre' => 'El Oro']);
        Provincia::create(['nombre' => 'Esmeraldas']);
        Provincia::create(['nombre' => 'Guayas']);
        Provincia::create(['nombre' => 'Imbabura']);
        Provincia::create(['nombre' => 'Loja']);
        Provincia::create(['nombre' => 'Los Rios']);
        Provincia::create(['nombre' => 'Manabi']);
        Provincia::create(['nombre' => 'Morona Santiago']);
        Provincia::create(['nombre' => 'Napo']);
        Provincia::create(['nombre' => 'Pastaza']);
        Provincia::create(['nombre' => 'Pichincha']);
        Provincia::create(['nombre' => 'Tungurahua']);
        Provincia::create(['nombre' => 'Zamora Chinchipe']);
        Provincia::create(['nombre' => 'Galápagos']);
        Provincia::create(['nombre' => 'Sucumbíos']);
        Provincia::create(['nombre' => 'Orellana']);
        Provincia::create(['nombre' => 'Santo Domingo de Los Tsáchilas']);
        Provincia::create(['nombre' => 'Santa Elena']);
        Provincia::create(['nombre' => 'Zonas No Delimitadas']);

        //Cantones
        Canton::create(['provincia_id' => '11', 'nombre' => 'Loja']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Calvas']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Catamayo']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Celica']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Chaguarpamba']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Espíndola']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Gonzanamá']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Macará']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Paltas']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Puyango']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Saraguro']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Sozoranga']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Zapotillo']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Pindal']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Quilanga']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Olmedo']);

        //Parroquias
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'El Sagrario']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'San Sebastián']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Sucre']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Valle']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Loja']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Chantaco']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Chuquiribamba']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'El Cisne']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Gualel']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Jimbilla']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Malacatos (Valladolid)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'San Lucas']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'San Pedro de Vilcabamba']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Santiago']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Taquil (Miguel Riofrío)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Vilcabamba (Victoria)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Yangana (Arsenio Castillo)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Quinara']);
    }
}
