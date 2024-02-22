<?php

namespace Database\Seeders;

use App\Models\Mantetipo;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tmantenimiento;
use App\Models\Tvehiculo;
use App\Models\Vcarga;
use App\Models\Vehiculo;
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
        Mantetipo::create(['nombre' => 'Mantenimiento 1', 'valor' => '43.59',
         'descripcion' => 'Cambio de aceite - Revisión y cambio de pastillas - Líquido de frenos - Filtro de combustible.']);
        
        Mantetipo::create(['nombre' => 'Mantenimiento 2 - Vehículo', 'valor' => '60',
         'descripcion' => 'Cambio de aceite - Revisión y cambio de pastillas - Líquido de frenos - Filtro de combustible - Cambio de filtro de aire - Cambio del líquido refrigerante - Cambio de luces delanteras - Cambio de luces posteriores.']);
        
        Mantetipo::create(['nombre' => 'Mantenimiento 2 - Motocicleta', 'valor' => '45',
          'descripcion' => 'Cambio de aceite - Revisión y cambio de pastillas - Líquido de frenos - Filtro de combustible - Cambio del líquido refrigerante - Cambio de luces delanteras - Cambio de luces posteriores.']);
        
        Mantetipo::create(['nombre' => 'Mantenimiento 3', 'valor' => '180',
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
        //Modelo Automovil
        Modelo::create(['marca_id' => '1', 'nombre' => 'Rio 2023']);
        Modelo::create(['marca_id' => '2', 'nombre' => 'Aveo']);
        Modelo::create(['marca_id' => '3', 'nombre' => 'Volkswagen ID.5']);
        //Marca Camioneta
        Marca::create(['tvehiculo_id' => '2', 'nombre' => 'Ford']);
        Marca::create(['tvehiculo_id' => '2', 'nombre' => 'Chevrolet']);
        Marca::create(['tvehiculo_id' => '2', 'nombre' => 'Toyota']);
        //Modelo Camioneta
        Modelo::create(['marca_id' => '4', 'nombre' => 'F-150']);
        Modelo::create(['marca_id' => '5', 'nombre' => 'Chevrolet S10']);
        Modelo::create(['marca_id' => '6', 'nombre' => 'Hilux']);
        //Marca Motocicleta    
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Yamaha']);
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Honda']);
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Suzuki']);
        Marca::create(['tvehiculo_id' => '3', 'nombre' => 'Kawasaki']);
        //Modelo Motocicleta 
        Modelo::create(['marca_id' => '7', 'nombre' => 'R 125']);
        Modelo::create(['marca_id' => '8', 'nombre' => 'Cb 300r']);
        Modelo::create(['marca_id' => '9', 'nombre' => 'GSX-S 125']);
        Modelo::create(['marca_id' => '10', 'nombre' => 'Ninja ZX']);
        
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

        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8525', 'chasis' => '1G1RC6E42BUXXXXXX', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30 C',
        'kilometraje' => '123', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '3', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8515', 'chasis' => '1G1RC6E42BUXXXX55', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30 FD',
        'kilometraje' => '123111', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '3', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8577', 'chasis' => '1G1RC6E42BUXXXX44', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30ASS',
        'kilometraje' => '12', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '3', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8523', 'chasis' => '1G1RC6E42BUXXXX77', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EEA',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '3', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8545', 'chasis' => '1G1RC6E42BUXXXX66', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EEWE',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '3', 'estado_id' => '1']);
        
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8565', 'chasis' => '1G1RC6E42BUXXX548', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EWES',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '3', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-4515', 'chasis' => '1G1RC6E42BUXXX478', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EAWE',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '3', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8535', 'chasis' => '1G1RC6E42BUXXX136', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EEQW',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '4', 'vpasajero_id' => '5', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8487', 'chasis' => '1G1RC6E42BUXXX475', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EEWQ',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '6', 'vpasajero_id' => '4', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8314', 'chasis' => '1G1RC6E42BUXXX145', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EFDS',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '6', 'vpasajero_id' => '3', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8984', 'chasis' => '1G1RC6E42BUXXX875', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EVXC',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '2', 'vpasajero_id' => '2', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8987', 'chasis' => '1G1RC6E42BUXXX987', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EBFD',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '2', 'vpasajero_id' => '6', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8154', 'chasis' => '1G1RC6E42BUXXX784', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EFGS',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '6', 'vpasajero_id' => '5', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8111', 'chasis' => '1G1RC6E42BUXX1478', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EFGH',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '3', 'vpasajero_id' => '4', 'estado_id' => '1']);
        Vehiculo::create(['tvehiculo_id' => '1', 'placa' => 'PAA-8125', 'chasis' => '1G1RC6E42BUXXX111', 'marca_id' => '1', 'modelo_id' => '1', 'motor' => 'N53 B30EGFS',
        'kilometraje' => '1231', 'cilindraje' => '1.5', 'vcarga_id' => '5', 'vpasajero_id' => '2', 'estado_id' => '1']);
        
    }
}
