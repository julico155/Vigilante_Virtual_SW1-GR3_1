<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EstadoEjecucion;

class EstadoEjecucionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EstadoEjecucion::create([
            'id' => 1,
            'nombre' => 'En Proceso',
            'descripcion' => 'Cuando se sigue trabajando en el examen.',
        ]);
        EstadoEjecucion::create([
            'id' => 2,
            'nombre' => 'Terminado',
            'descripcion' => 'Cuando se ha terminado el examen.',
        ]);
        EstadoEjecucion::create([
            'id' => 3,
            'nombre' => 'Pendiente',
            'descripcion' => 'Cuando se ha creado el examen, pero no se esta trabajando en el.',
        ]);
    }
}
