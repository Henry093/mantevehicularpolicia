<?php

namespace Database\Seeders;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tmantenimiento;
use App\Models\Tvehiculo;
use App\Models\Vcarga;
use App\Models\Vpasajero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehiculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Tipo Mantenimiento
        Tmantenimiento::create(['nombre' => 'Mantenimiento 1', 'valor' => '43.59',
         'descripcion' => 'Cambio de aceite - Revisión y cambio de pastillas - Líquido de frenos - Filtro de combustible.']);
        
        Tmantenimiento::create(['nombre' => 'Mantenimiento 2 - Vehículo', 'valor' => '60',
         'descripcion' => 'Cambio de aceite - Revisión y cambio de pastillas - Líquido de frenos - Filtro de combustible - Cambio de filtro de aire - Cambio del líquido refrigerante - Cambio de luces delanteras - Cambio de luces posteriores.']);
        
        Tmantenimiento::create(['nombre' => 'Mantenimiento 2 - Motocicleta', 'valor' => '45',
          'descripcion' => 'Cambio de aceite - Revisión y cambio de pastillas - Líquido de frenos - Filtro de combustible - Cambio del líquido refrigerante - Cambio de luces delanteras - Cambio de luces posteriores.']);
        
        Tmantenimiento::create(['nombre' => 'Mantenimiento 3', 'valor' => '180',
           'descripcion' => 'Cambio de aceite - Revisión y cambio de pastillas - Líquido de frenos - Filtro de combustible - Cambio del líquido refrigerante - Cambio de luces delanteras - Cambio de luces posteriores - Cambio de batería - Ajustes en el sistema eléctrico.']);

        //Tipo de Vehículos
        Tvehiculo::create(['nombre' => 'Automovil']);
        Tvehiculo::create(['nombre' => 'Camioneta']);
        Tvehiculo::create(['nombre' => 'Motocicleta']);

        //Marca de Vehículos
        //Marca Automovil
        Marca::create(['tvehiculo_id' => '1', 'nombre' => 'KIA']);
        Marca::create(['tvehiculo_id' => '1', 'nombre' => 'Chevrolet']);
        Marca::create(['tvehiculo_id' => '1', 'nombre' => 'Volkswagen']);
        //Marca Camioneta
        Marca::create(['tvehiculo_id' => '2', 'nombre' => 'Ford']);
        Marca::create(['tvehiculo_id' => '2', 'nombre' => 'Chevrolet']);
        Marca::create(['tvehiculo_id' => '2', 'nombre' => 'Toyota']);
        //Marca Motocicleta    
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Yamaha']);
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Honda']);
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Suzuki']);
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Kawasaki']);
        //Modelo Automovil
        Modelo::create(['marca_id' => '1', 'nombre' => 'Rio 2023']);
        Modelo::create(['marca_id' => '2', 'nombre' => 'Aveo']);
        Modelo::create(['marca_id' => '3', 'nombre' => 'Volkswagen ID.5']);
        //Modelo Camioneta
        Modelo::create(['marca_id' => '1', 'nombre' => 'F-150']);
        Modelo::create(['marca_id' => '2', 'nombre' => 'Chevrolet S10']);
        Modelo::create(['marca_id' => '3', 'nombre' => 'Hilux']);
        //Modelo Motocicleta 
        Modelo::create(['marca_id' => '1', 'nombre' => 'R 125']);
        Modelo::create(['marca_id' => '2', 'nombre' => 'Cb 300r']);
        Modelo::create(['marca_id' => '3', 'nombre' => 'GSX-S 125']);
        Modelo::create(['marca_id' => '4', 'nombre' => 'Ninja ZX']);

        //Capacidad Carga
        Vcarga::create(['nombre' => '100 KG']);
        Vcarga::create(['nombre' => '200 KG']);
        Vcarga::create(['nombre' => '300 KG']);
        Vcarga::create(['nombre' => '400 KG']);
        Vcarga::create(['nombre' => '500 KG']);
        Vcarga::create(['nombre' => '600 KG']);
        Vcarga::create(['nombre' => '700 KG']);
        Vcarga::create(['nombre' => '800 KG']);
        Vcarga::create(['nombre' => '900 KG']);
        Vcarga::create(['nombre' => '1000 KG']);
        Vcarga::create(['nombre' => '1500 KG']);
        Vcarga::create(['nombre' => '2000 KG']);
        //Capacidad Pasajeros
        Vpasajero::create(['nombre' => '1 Persona']);
        Vpasajero::create(['nombre' => '2 Personas']);
        Vpasajero::create(['nombre' => '3 Personas']);
        Vpasajero::create(['nombre' => '4 Personas']);
        Vpasajero::create(['nombre' => '5 Personas']);
        Vpasajero::create(['nombre' => '6 Personas']);
        
    }
}
