<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesYPermisosSeeder extends Seeder
{

    public function run(): void
    {
        $master         = Role::create(['name' => 'Master']);
        $administrativo = Role::create(['name' => 'Administrativo']);
        $docente        = Role::create(['name' => 'Docente']);
        $estudiante     = Role::create(['name' => 'Estudiante']);

        // Permission::create(['name' => 'Ver Dashboard'])->syncRoles([$master, $administrativo, $docente]);
        // Permission::create(['name' => 'Ver Usuarios'])->syncRoles([$master, $administrativo]);
        // Permission::create(['name' => 'Ver Roles y Permisos'])->syncRoles([$master, $administrativo]);
        // Permission::create(['name' => 'Ver Examenes'])->syncRoles([$master, $administrativo, $docente]);
        // Permission::create(['name' => 'Ver Inscripciones'])->syncRoles([$master, $administrativo]);
        // Permission::create(['name' => 'Ver Pagos'])->syncRoles([$master, $administrativo]);
        // Permission::create(['name' => 'Ver Servicios'])->syncRoles([$master, $administrativo]);
        // Permission::create(['name' => 'Ver Grupos y Materias'])->syncRoles([$master, $administrativo]);
        // Permission::create(['name' => 'Ver Perfil Estudiante'])->syncRoles([$estudiante]);
        // Permission::create(['name' => 'Ver Perfil Docente'])->syncRoles([$docente]);
    }
}
