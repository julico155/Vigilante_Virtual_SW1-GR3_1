<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipoPregunta;

class TipoPreguntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoPregunta::create([
            'id' => 1,
            'nombre' => 'Verdadero o Falso',
            'descripcion' => 'Para preguntas de verdadero o falso',
        ]);
        TipoPregunta::create([
            'id' => 2,
            'nombre' => 'Seleccion Multiple',
            'descripcion' => 'Para preguntas de seleccion multiple',
        ]);
        TipoPregunta::create([
            'id' => 3,
            'nombre' => 'Libre',
            'descripcion' => 'Para preguntas de respuesta libre',
        ]);
    }
}
