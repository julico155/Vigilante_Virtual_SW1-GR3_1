<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class BoletaInscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $adminIds = range(7, 11);
        $studentIds = range(42, 125);
        shuffle($studentIds);

        foreach ($studentIds as $studentId) {
            $adminId = $faker->randomElement($adminIds);
            DB::table('boleta_inscripcions')->insert([
                'user_estudiante_id' => $studentId,
                'user_administrativo_id' => $adminId,
                'hora' => $faker->time(),
                'fecha' => $faker->date(),
                'cantidad_materias_inscritas' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
