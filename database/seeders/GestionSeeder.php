<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gestion;


class GestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gestion::create([
            'id' => 1,
            'nombre' => '1/2024',
            'fecha_inicio' => '2024-01-01',
            'fecha_final' => '2024-06-30',
        ]);
        Gestion::create([
            'id' => 2,
            'nombre' => '2/2024',
            'fecha_inicio' => '2024-07-01',
            'fecha_final' => '2024-12-01',
        ]);
        Gestion::create([
            'id' => 3,
            'nombre' => '3/2024',
            'fecha_inicio' => '2024-12-02',
            'fecha_final' => '2024-12-31',
        ]);
        Gestion::create([
            'id' => 4,
            'nombre' => '1/2025',
            'fecha_inicio' => '2025-01-01',
            'fecha_final' => '2025-06-30',
        ]);
        Gestion::create([
            'id' => 5,
            'nombre' => '2/2025',
            'fecha_inicio' => '2025-07-01',
            'fecha_final' => '2025-12-01',
        ]);
    }
}
