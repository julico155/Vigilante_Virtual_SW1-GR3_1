<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoAnomalia;

class TipoAnomaliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoAnomalia::create([
            'id' => 1,
            'nombre' => 'Más De Una Persona',
            'gravedad' => 'Alta',
        ]);

        TipoAnomalia::create([
            'id' => 2,
            'nombre' => 'No se encontro al Usuario',
            'gravedad' => 'Alta',
        ]);


        TipoAnomalia::create([
            'id' => 3,
            'nombre' => 'No Tiene Foto De Perfil',
            'gravedad' => 'Media',
        ]);
    }
}
