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
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '2', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '3', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '4', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '5', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '6', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '7', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '8', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '9', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11', 'canton_id' => '1','parroquia_id' => '10', 'nombre' => 'Loja', 'codigo' => '11D01', 'estado_id' => '1']);

        Distrito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '11', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '12', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '13', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '14', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '3','parroquia_id' => '15', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '3','parroquia_id' => '16', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '4','parroquia_id' => '17', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '4','parroquia_id' => '18', 'nombre' => 'Catamayo', 'codigo' => '11D02', 'estado_id' => '1']);

        Distrito::create(['provincia_id' => '11','canton_id' => '5','parroquia_id' => '19', 'nombre' => 'Catacocha', 'codigo' => '11D03', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '5','parroquia_id' => '20', 'nombre' => 'Catacocha', 'codigo' => '11D03', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '5','parroquia_id' => '21', 'nombre' => 'Catacocha', 'codigo' => '11D03', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '5','parroquia_id' => '22', 'nombre' => 'Catacocha', 'codigo' => '11D03', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '5','parroquia_id' => '23', 'nombre' => 'Catacocha', 'codigo' => '11D03', 'estado_id' => '1']);

        Distrito::create(['provincia_id' => '11','canton_id' => '6','parroquia_id' => '24', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '6','parroquia_id' => '25', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '6','parroquia_id' => '26', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '7','parroquia_id' => '27', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '7','parroquia_id' => '28', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '7','parroquia_id' => '29', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '7','parroquia_id' => '30', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '8','parroquia_id' => '31', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '8','parroquia_id' => '32', 'nombre' => 'Sabanilla', 'codigo' => '11D04', 'estado_id' => '1']);
        
        Distrito::create(['provincia_id' => '11','canton_id' => '9','parroquia_id' => '33', 'nombre' => 'Espindola', 'codigo' => '11D05', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '9','parroquia_id' => '34', 'nombre' => 'Espindola', 'codigo' => '11D05', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '9','parroquia_id' => '35', 'nombre' => 'Espindola', 'codigo' => '11D05', 'estado_id' => '1']);

        Distrito::create(['provincia_id' => '11','canton_id' => '10','parroquia_id' => '36', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '10','parroquia_id' => '37', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '10','parroquia_id' => '38', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '10','parroquia_id' => '39', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '11','parroquia_id' => '40', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '11','parroquia_id' => '41', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '11','parroquia_id' => '42', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '11','parroquia_id' => '43', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '12','parroquia_id' => '44', 'nombre' => 'Calvas', 'codigo' => '11D06', 'estado_id' => '1']);
        
        Distrito::create(['provincia_id' => '11','canton_id' => '13','parroquia_id' => '45', 'nombre' => 'Macara', 'codigo' => '11D07', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '13','parroquia_id' => '46', 'nombre' => 'Macara', 'codigo' => '11D07', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '13','parroquia_id' => '47', 'nombre' => 'Macara', 'codigo' => '11D07', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '13','parroquia_id' => '48', 'nombre' => 'Macara', 'codigo' => '11D07', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '13','parroquia_id' => '49', 'nombre' => 'Macara', 'codigo' => '11D07', 'estado_id' => '1']);
        
        Distrito::create(['provincia_id' => '11','canton_id' => '14','parroquia_id' => '50', 'nombre' => 'Saraguro', 'codigo' => '11D08', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '14','parroquia_id' => '51', 'nombre' => 'Saraguro', 'codigo' => '11D08', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '14','parroquia_id' => '52', 'nombre' => 'Saraguro', 'codigo' => '11D08', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '14','parroquia_id' => '53', 'nombre' => 'Saraguro', 'codigo' => '11D08', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '14','parroquia_id' => '54', 'nombre' => 'Saraguro', 'codigo' => '11D08', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '14','parroquia_id' => '55', 'nombre' => 'Saraguro', 'codigo' => '11D08', 'estado_id' => '1']);

        Distrito::create(['provincia_id' => '11','canton_id' => '15','parroquia_id' => '56', 'nombre' => 'Zapotillo', 'codigo' => '11D09', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '15','parroquia_id' => '57', 'nombre' => 'Zapotillo', 'codigo' => '11D09', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '15','parroquia_id' => '58', 'nombre' => 'Zapotillo', 'codigo' => '11D09', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '15','parroquia_id' => '59', 'nombre' => 'Zapotillo', 'codigo' => '11D09', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '15','parroquia_id' => '60', 'nombre' => 'Zapotillo', 'codigo' => '11D09', 'estado_id' => '1']);
        Distrito::create(['provincia_id' => '11','canton_id' => '15','parroquia_id' => '61', 'nombre' => 'Zapotillo', 'codigo' => '11D09', 'estado_id' => '1']);


        //Circuitos
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1', 'nombre' => 'Vilcabamba', 'codigo' => '11D01C01', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '2','distrito_id' => '1', 'nombre' => 'Yangana', 'codigo' => '11D01C02', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '3','distrito_id' => '1', 'nombre' => 'Malacatos', 'codigo' => '11D01C03', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '4','distrito_id' => '1', 'nombre' => 'Taquil', 'codigo' => '11D01C04', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '5','distrito_id' => '1', 'nombre' => 'Taquil', 'codigo' => '11D01C04', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Zamora Huayco', 'codigo' => '11D01C05', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Esteban Godoy', 'codigo' => '11D01C06', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'El Paraiso', 'codigo' => '11D01C07', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Celi Roman', 'codigo' => '11D01C08', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'IV Centenario', 'codigo' => '11D01C09', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Tebaida', 'codigo' => '11D01C10', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Los Molinos', 'codigo' => '11D01C11', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Chontacruz', 'codigo' => '11D01C12', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Sagrario', 'codigo' => '11D01C13', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'El Valle', 'codigo' => '11D01C14', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Clodoveo Jaramillo', 'codigo' => '11D01C15', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'La Banda', 'codigo' => '11D01C16', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Sauces Norte', 'codigo' => '11D01C17', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'La Argelia', 'codigo' => '11D01C18', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1', 'nombre' => 'Consacola', 'codigo' => '11D01C19', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '7','distrito_id' => '1', 'nombre' => 'San Lucas', 'codigo' => '11D01C20', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '8','distrito_id' => '1', 'nombre' => 'El Cisne', 'codigo' => '11D01C21', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '9','distrito_id' => '1', 'nombre' => 'Jimbilla', 'codigo' => '11D01C22', 'estado_id' => '1']);

        
        Circuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '10','distrito_id' => '2', 'nombre' => 'El Tambo', 'codigo' => '11D02C01', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '11','distrito_id' => '2', 'nombre' => 'Catamayo Norte', 'codigo' => '11D02C02', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '12','distrito_id' => '2', 'nombre' => 'Catamayo San Jose', 'codigo' => '11D02C03', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '13','distrito_id' => '2', 'nombre' => 'Guayquichuma', 'codigo' => '11D02C04', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '14','distrito_id' => '2', 'nombre' => 'San Pedro de la Bendita', 'codigo' => '11D02C05', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '3','parroquia_id' => '15','distrito_id' => '2', 'nombre' => 'Chaguarpamba', 'codigo' => '11D02C06', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '3','parroquia_id' => '16','distrito_id' => '2', 'nombre' => 'Buenavista', 'codigo' => '11D02C07', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '4','parroquia_id' => '17','distrito_id' => '2', 'nombre' => 'Olmedo', 'codigo' => '11D02C08', 'estado_id' => '1']);
        Circuito::create(['provincia_id' => '11','canton_id' => '4','parroquia_id' => '18','distrito_id' => '2', 'nombre' => 'La Tingue', 'codigo' => '11D02C09', 'estado_id' => '1']);

        //Subcircuito
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '1','distrito_id' => '1','circuito_id' => '1', 'nombre' => 'Vilcabamba 1', 'codigo' => '11D01C01S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '2','distrito_id' => '1','circuito_id' => '2', 'nombre' => 'Yangana 1', 'codigo' => '11D01C02S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '3','distrito_id' => '1','circuito_id' => '3', 'nombre' => 'Malacatos 1', 'codigo' => '11D01C03S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '4','distrito_id' => '1','circuito_id' => '4', 'nombre' => 'Taquil 1', 'codigo' => '11D01C04S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '5','distrito_id' => '1','circuito_id' => '5', 'nombre' => 'Taquil 2', 'codigo' => '11D01C04S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '6', 'nombre' => 'Zanora Huayco 1', 'codigo' => '11D01C05S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '7', 'nombre' => 'Esteban Godoy 1', 'codigo' => '11D01C06S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '7', 'nombre' => 'Esteban Godoy 2', 'codigo' => '11D01C06S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '8', 'nombre' => 'El Paraiso 1', 'codigo' => '11D01C07S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '9', 'nombre' => 'Celi Roman 1', 'codigo' => '11D01C08S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '10', 'nombre' => 'IV Centenario 1', 'codigo' => '11D01C09S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '11', 'nombre' => 'Tebaida 1', 'codigo' => '11D01C10S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '12', 'nombre' => 'Los Molinos 1', 'codigo' => '11D01C11S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '13', 'nombre' => 'Chonta Cruz 1', 'codigo' => '11D01C12S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '13', 'nombre' => 'Chonta Cruz 2', 'codigo' => '11D01C12S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '14', 'nombre' => 'Sagrario 1', 'codigo' => '11D01C13S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '15', 'nombre' => 'El Valle 1', 'codigo' => '11D01C14S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '16', 'nombre' => 'Clodoveo Jaramillo 1', 'codigo' => '11D01C15S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '17', 'nombre' => 'La Banda 1', 'codigo' => '11D01C16S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '17', 'nombre' => 'La Banda 2', 'codigo' => '11D01C16S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '18', 'nombre' => 'Sauces Norte 1', 'codigo' => '11D01C17S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '18', 'nombre' => 'Sauces Norte 2', 'codigo' => '11D01C17S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '19', 'nombre' => 'La Argelia 1', 'codigo' => '11D01C18S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '6','distrito_id' => '1','circuito_id' => '20', 'nombre' => 'Consacola 1', 'codigo' => '11D01C19S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '7','distrito_id' => '1','circuito_id' => '21', 'nombre' => 'San Lucas 1', 'codigo' => '11D01C20S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '8','distrito_id' => '1','circuito_id' => '22', 'nombre' => 'El Cisne 1', 'codigo' => '11D01C21S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '9','distrito_id' => '1','circuito_id' => '22', 'nombre' => 'El Cisne 2', 'codigo' => '11D01C22S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '1','parroquia_id' => '10','distrito_id' => '1','circuito_id' => '23', 'nombre' => 'Jimbilla 1', 'codigo' => '11D01C23S01', 'estado_id' => '1']);

        Subcircuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '11','distrito_id' => '2','circuito_id' => '24', 'nombre' => 'El Tambo 1', 'codigo' => '11D02C01S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '12','distrito_id' => '2','circuito_id' => '25', 'nombre' => 'Catamayo Norte 1', 'codigo' => '11D02C02S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '12','distrito_id' => '2','circuito_id' => '25', 'nombre' => 'Catamayo Norte 2', 'codigo' => '11D02C02S02', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '13','distrito_id' => '2','circuito_id' => '26', 'nombre' => 'Catamayo San Jose 1', 'codigo' => '11D02C03S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '14','distrito_id' => '2','circuito_id' => '27', 'nombre' => 'Guayquichuma 1', 'codigo' => '11D02C04S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '2','parroquia_id' => '15','distrito_id' => '2','circuito_id' => '28', 'nombre' => 'San Pedro de la Bendita 1', 'codigo' => '11D02C05S01', 'estado_id' => '1']);

        Subcircuito::create(['provincia_id' => '11','canton_id' => '3','parroquia_id' => '16','distrito_id' => '3','circuito_id' => '29', 'nombre' => 'Chaguarpamba 1', 'codigo' => '11D02C06S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '3','parroquia_id' => '17','distrito_id' => '3','circuito_id' => '30', 'nombre' => 'Buena Vista 1', 'codigo' => '11D02C07S01', 'estado_id' => '1']);
        
        Subcircuito::create(['provincia_id' => '11','canton_id' => '4','parroquia_id' => '18','distrito_id' => '4','circuito_id' => '31', 'nombre' => 'Olmedo 1', 'codigo' => '11D02C08S01', 'estado_id' => '1']);
        Subcircuito::create(['provincia_id' => '11','canton_id' => '4','parroquia_id' => '19','distrito_id' => '4','circuito_id' => '32', 'nombre' => 'La Tingue 1', 'codigo' => '11D02C09S01', 'estado_id' => '1']);
       
    }
}
