<?php

namespace Database\Seeders;

use App\Models\Comprobante;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesYPermisosSeeder::class,
            UserSeeder::class,
            EstadoEjecucionSeeder::class,
            TipoPreguntaSeeder::class,
            TipoAnomaliaSeeder::class,
            GrupoSeeder::class,
            MateriaSeeder::class,
            GestionSeeder::class,
            ServicioSeeder::class,
            GrupoMateriaSeeder::class,
            ComprobanteSeeder::class,
            ServicioComprobanteSeeder::class,
            BoletaInscripcionSeeder::class,
            GrupoMateriaBoletaInscripcionSeeder::class,
        ]);
    }
}
