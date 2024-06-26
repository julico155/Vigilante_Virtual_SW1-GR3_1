<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ServicioComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $servicioId = 1;

        for ($comprobanteId = 1; $comprobanteId <= 72; $comprobanteId++) {
            DB::table('servicio_comprobantes')->insert([
                'comprobante_id' => $comprobanteId,
                'servicio_id' => $servicioId,
                'usado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
