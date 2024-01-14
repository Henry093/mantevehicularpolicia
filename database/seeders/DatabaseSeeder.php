<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Dependencia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(DatosSeeder::class);
        $this->call(GeograficoSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RolSeeder::class);
        $this->call(VehiculoSeeder::class);
        $this->call(DependenciaSeeder::class);
    }
}
