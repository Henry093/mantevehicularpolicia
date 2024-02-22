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
        Canton::create(['provincia_id' => '11', 'nombre' => 'Catamayo']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Chaguarpamba']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Olmedo']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Paltas']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Celica']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Puyango']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Pindal']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Espíndola']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Calvas']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Gonzanamá']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Quilanga']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Macará']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Sozoranga']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Saraguro']);
        Canton::create(['provincia_id' => '11', 'nombre' => 'Zapotillo']);


        //Parroquias
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Vilcabamba (Victoria)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Quinara']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Malacatos (Valladolid)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Chuquiribamba']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Taquil (Miguel Riofrío)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Loja']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'San Lucas']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'El Cisne']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Gualel']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '1', 'nombre' => 'Jimbilla']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '2', 'nombre' => 'El Tambo']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '2', 'nombre' => 'Catamayo (La Toma)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '2', 'nombre' => 'Zambi']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '2', 'nombre' => 'San Pedro de la Bendita']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '3', 'nombre' => 'Chaguarpamba']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '3', 'nombre' => 'Amarillos']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '4', 'nombre' => 'Olmedo']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '4', 'nombre' => 'La Tingue']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '5', 'nombre' => 'Catacocha']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '5', 'nombre' => 'Cangonama']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '5', 'nombre' => 'Lauro Guerrero']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '5', 'nombre' => 'Guachanama']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '5', 'nombre' => 'Orianga']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '6', 'nombre' => 'Pozul (San Juan de Pozul']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '6', 'nombre' => 'Sabanilla']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '6', 'nombre' => 'Celica']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '7', 'nombre' => 'Ciano']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '7', 'nombre' => 'Vicentino']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '7', 'nombre' => 'Alamor']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '7', 'nombre' => 'El Limo (Mariana de Jesus)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '8', 'nombre' => 'Chaquinal']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '8', 'nombre' => 'Pindal']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '9', 'nombre' => 'Jimbura']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '9', 'nombre' => 'El Airo']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '9', 'nombre' => 'Santa Teresita']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '10', 'nombre' => 'Utuana']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '10', 'nombre' => 'Cariamanga']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '10', 'nombre' => 'Sanguillin']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '10', 'nombre' => 'El Lucero']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '11', 'nombre' => 'Sacapalca']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '11', 'nombre' => 'Gonzanama']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '11', 'nombre' => 'Nambacola']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '11', 'nombre' => 'Purunuma (Eguiguren)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '12', 'nombre' => 'Quiranga']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '13', 'nombre' => 'Macara']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '13', 'nombre' => 'La Victoria']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '13', 'nombre' => 'La Rama']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '14', 'nombre' => 'Zozoranga']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '14', 'nombre' => 'Tacamoros']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '15', 'nombre' => 'Urdaneta (Paquishapa)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '15', 'nombre' => 'Saraguro']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '15', 'nombre' => 'San Pablo de Tenta']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '15', 'nombre' => 'Selva Alegre']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '15', 'nombre' => 'Sumaypamba']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '15', 'nombre' => 'San Sebastian de Yuluc']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '16', 'nombre' => 'Zapotillo']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '16', 'nombre' => 'Paletillas']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '16', 'nombre' => 'Cazaderos (Cab en Manguarco)']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '16', 'nombre' => 'Garzareal']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '16', 'nombre' => 'Limones']);
        Parroquia::create(['provincia_id' => '11','canton_id' => '16', 'nombre' => 'Bolaspamba']);

        
    }
}
