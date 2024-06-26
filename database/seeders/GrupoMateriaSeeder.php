<?php

namespace Database\Seeders;

use App\Models\GrupoMateria;
use Illuminate\Database\Seeder;

class GrupoMateriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupoMaterias = [
            ['grupo_id' => 1, 'materia_id' => 1, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 15, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 2, 'materia_id' => 1, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 10, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 1, 'materia_id' => 2, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 30, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 3, 'materia_id' => 2, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 25, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 4, 'materia_id' => 3, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 20, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 5, 'materia_id' => 3, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 18, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 1, 'materia_id' => 4, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 15, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 2, 'materia_id' => 4, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 10, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 3, 'materia_id' => 5, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 30, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 4, 'materia_id' => 5, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 25, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 5, 'materia_id' => 6, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 20, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 1, 'materia_id' => 6, 'user_docente_id' => rand(7, 22), 'contraseña' => '123456789', 'cantidad_estudiantes' => 18, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 1, 'materia_id' => 1, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 15, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 2, 'materia_id' => 1, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 10, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 1, 'materia_id' => 2, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 30, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 3, 'materia_id' => 2, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 25, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 4, 'materia_id' => 3, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 20, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 5, 'materia_id' => 3, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 18, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 1, 'materia_id' => 4, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 15, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 2, 'materia_id' => 4, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 10, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 3, 'materia_id' => 5, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 30, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 4, 'materia_id' => 5, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 25, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 5, 'materia_id' => 6, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 20, 'cantidad_estudiantes_inscritos' => 0],
            ['grupo_id' => 1, 'materia_id' => 6, 'user_docente_id' => rand(7, 22), 'contraseña' => '987654321', 'cantidad_estudiantes' => 18, 'cantidad_estudiantes_inscritos' => 0],
        ];

        foreach ($grupoMaterias as $index => $data) {
            GrupoMateria::create(array_merge(['id' => $index + 1], $data));
        }
    }
}
