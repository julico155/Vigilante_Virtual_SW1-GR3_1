<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $masters = [
            ['name' => 'MABO', 'email' => 'ballivian02@gmail.com', 'password' => '123456789', 'nombre' => 'Miguel Angel', 'apellido_paterno' => 'Ballivian', 'apellido_materno' => 'Ocampo', 'carnet_identidad' => '6312127', 'profile_photo_path' => 'images/user/MABINHO.jpg'],
            ['name' => 'Ing. Papitas', 'email' => 'papitas@gmail.com', 'password' => '1234', 'carnet_identidad' => '12345', 'nombre' => 'Elio Andres', 'apellido_paterno' => 'Osinaga', 'apellido_materno' => 'Vargas', 'profile_photo_path' => 'images/user/papita.jpeg'],
            ['name' => 'David', 'email' => 'davidchalarq@gmail.com', 'password' => '123456789', 'carnet_identidad' => '67890', 'nombre' => 'David Arturo', 'apellido_paterno' => 'Chalar', 'apellido_materno' => 'Quiroz', 'profile_photo_path' => 'images/user/david.jpg'],
            ['name' => 'Rene Eduardo', 'email' => 'renechungara03@gmail.com', 'password' => '123456789', 'nombre' => 'Rene Eduardo', 'apellido_paterno' => 'Chungara', 'apellido_materno' => 'Martinez', 'profile_photo_path' => 'images/user/rene.jpeg'],
            ['name' => 'Julius', 'email' => 'juliogutierrezv15@gmail.com', 'password' => '123456789', 'nombre' => 'Julio Alejandro', 'apellido_paterno' => 'Gutierrez', 'apellido_materno' => 'Velasco', 'profile_photo_path' => 'images/user/juli.png'],
            ['name' => 'Micakes', 'email' => 'micaelaorocag@gmail.com', 'password' => '123456789', 'carnet_identidad' => '123456', 'nombre' => 'Micaela Olga', 'apellido_paterno' => 'Roca', 'apellido_materno' => 'Garnica', 'profile_photo_path' => 'images/user/Micakes.jpg']
        ];

        foreach ($masters as $master) {
            $user = User::create([
                'name' => $master['name'],
                'email' => $master['email'],
                'password' => Hash::make($master['password']),
                'nombre' => $master['nombre'],
                'apellido_paterno' => $master['apellido_paterno'],
                'apellido_materno' => $master['apellido_materno'],
                'carnet_identidad' => $master['carnet_identidad'] ?? null,
                'profile_photo_path' => $master['profile_photo_path']
            ]);
            $user->assignRole('Master');
        }

        // Crear usuarios administrativos
        for ($i = 1; $i <= 5; $i++) {
            $nombre = $faker->firstName;
            $email = strtolower($nombre) . "@gmail.com";
            while (User::where('email', $email)->exists()) {
                $email = strtolower($nombre) . rand(1, 100) . "@gmail.com";
            }

            $user = User::create([
                'name' => "Administrativo $i",
                'email' => $email,
                'password' => Hash::make('123456789'),
                'nombre' => $nombre,
                'apellido_paterno' => $faker->lastName,
                'apellido_materno' => $faker->lastName,
                'jefe_id' => User::role('Master')->inRandomOrder()->first()->id,
                'usuarios_creables' => 25
            ]);
            $user->assignRole('Administrativo');
        }

        // Crear docentes y estudiantes según usuarios_creables
        $adminUsers = User::role('Administrativo')->get();
        $totalDocentes = 0;

        foreach ($adminUsers as $admin) {
            $totalUsers = $admin->usuarios_creables;

            // Crear docentes hasta que se hayan creado 30 en total
            for ($j = 1; $j <= $totalUsers && $totalDocentes < 30; $j++) {
                $nombre = $faker->firstName;
                $email = strtolower($nombre) . $j . "@gmail.com";
                while (User::where('email', $email)->exists()) {
                    $email = strtolower($nombre) . rand(1, 100) . $j . "@gmail.com";
                }

                $user = User::create([
                    'name' => "Docente $admin->id-$j",
                    'email' => $email,
                    'password' => Hash::make('123456789'),
                    'nombre' => $nombre,
                    'apellido_paterno' => $faker->lastName,
                    'apellido_materno' => $faker->lastName,
                    'jefe_id' => $admin->id
                ]);
                $user->assignRole('Docente');
                $totalDocentes++;
                if ($totalDocentes >= 30) {
                    break;
                }
            }

            // Crear estudiantes con el resto de los usuarios creables
            for ($k = 1; $k <= $totalUsers - $j + 1; $k++) {
                $nombre = $faker->firstName;
                $email = strtolower($nombre) . $k . "@gmail.com";
                while (User::where('email', $email)->exists()) {
                    $email = strtolower($nombre) . rand(1, 100) . $k . "@gmail.com";
                }

                $user = User::create([
                    'name' => "Estudiante $admin->id-$k",
                    'email' => $email,
                    'password' => Hash::make('123456789'),
                    'nombre' => $nombre,
                    'apellido_paterno' => $faker->lastName,
                    'apellido_materno' => $faker->lastName,
                    'jefe_id' => $admin->id,
                    'carnet_identidad' => $faker->unique()->numberBetween(1000000, 9999999)
                ]);
                $user->assignRole('Estudiante');
            }
        }
    }
}
