<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Servicio;


class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Servicio::create([
            'id' => 1,
            'nombre' => 'Matricula',
            'descripcion' => 'Costo de incripcion por matricula',
            'fecha' => '2024-01-01',
            'precio' => 45.00,
        ]);

        Servicio::create([
            'id' => 2,
            'nombre' => 'Certificado',
            'descripcion' => 'Costo de certificado de notas',
            'fecha' => '2024-01-01',
            'precio' => 45.00,
        ]);

        Servicio::create([
            'id' => 3,
            'nombre' => 'Foto Estudiante',
            'descripcion' => 'Costo de foto de estudiante',
            'fecha' => '2024-01-01',
            'precio' => 15.00,
        ]);

        Servicio::create([
            'id' => 4,
            'nombre' => 'Carnet Estudiante',
            'descripcion' => 'Costo de carnet de estudiante',
            'fecha' => '2024-01-01',
            'precio' => 30.00,
        ]);

        Servicio::create([
            'id' => 5,
            'nombre' => 'Carnet Docente',
            'descripcion' => 'Costo de carnet de docente',
            'fecha' => '2024-01-01',
            'precio' => 100.00,
        ]);
    }
}
