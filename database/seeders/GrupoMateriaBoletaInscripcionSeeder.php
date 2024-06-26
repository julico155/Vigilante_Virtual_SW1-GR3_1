<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GrupoMateriaBoletaInscripcionSeeder extends Seeder
{

    public function run(): void
    {
        $faker = Faker::create();

        $boletaIds = range(1, 83);
        $grupoMateriaIds = range(1, 24);

        foreach ($boletaIds as $boletaId) {
            $usedGrupoMateriaIds = [];

            for ($i = 0; $i < 3; $i++) {
                do {
                    $grupoMateriaId = $faker->randomElement($grupoMateriaIds);
                } while (in_array($grupoMateriaId, $usedGrupoMateriaIds));

                $usedGrupoMateriaIds[] = $grupoMateriaId;

                DB::table('grupo_materia_boleta_inscripcions')->insert([
                    'boleta_inscripcion_id' => $boletaId,
                    'grupo_materia_id' => $grupoMateriaId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
