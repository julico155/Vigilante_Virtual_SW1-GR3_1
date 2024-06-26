<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grupo;


class GrupoSeeder extends Seeder
{

    public function run(): void
    {
        Grupo::create([
            'id' => 1,
            'nombre' => 'SX',
        ]);
        Grupo::create([
            'id' => 2,
            'nombre' => 'SB',
        ]);
        Grupo::create([
            'id' => 3,
            'nombre' => 'SC',
        ]);
        Grupo::create([
            'id' => 4,
            'nombre' => 'Z1',
        ]);
        Grupo::create([
            'id' => 5,
            'nombre' => 'SM',
        ]);
    }
}
