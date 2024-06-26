<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Vigilante</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    @livewireStyles
</head>
<div class="flex flex-col min-h-screen h-auto bg-gray-100">
    <!-- Barra Superior -->
    <div class="bg-white shadow-md w-full p-4 flex items-center justify-between">
        <div class="flex items-center">
            <button id="menuBtn" class="p-2 text-gray-700 focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <span class="font-extrabold uppercase text-xl text-blue-900 ml-2">Vigilante Virtual</span>
        </div>
        <div class="space-x-5 flex items-center">
            <a href="{{ route('Usuario.show', Auth::user()->id) }}" class="relative flex items-center">
                @if (Auth::user()->profile_photo_path)
                    <img src="{{ asset(Auth::user()->profile_photo_path) }}" alt="Avatar"
                        class="w-8 h-8 rounded-full">
                @else
                    <span
                        class="w-8 h-8 bg-blue-900 text-white flex justify-center items-center rounded-full">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                @endif
                <span class="text-blue-900 hidden md:inline ml-2">{{ Auth::user()->name }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="relative">
                @csrf
                <button type="submit" class="relative">
                    <i class="fa-solid fa-right-from-bracket text-blue-900 text-2xl"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Contenido Principal -->
    <div class="flex flex-1">
        <!-- Barra Lateral -->
        <div class="bg-white w-64 min-h-screen p-4 flex flex-col shadow-lg md:block" id="sideNav">
            <div class="space-y-6">
                <a href="{{ route('Usuario.show', Auth::user()->id) }}" class="block text-center mb-6">
                    <div class="space-y-3 p-4 shadow-md rounded-lg bg-white">
                        <img src="{{ Auth::user()->profile_photo_path ? asset(Auth::user()->profile_photo_path) : 'https://img.freepik.com/premium-vector/user-profile-icon-flat-style-member-avatar-vector-illustration-isolated-background-human-permission-sign-business-concept_157943-15752.jpg' }}"
                            alt="Avatar de {{ Auth::user()->name }}"
                            class="w-20 h-20 md:w-24 md:h-24 rounded-full mx-auto border-4 border-blue-500 shadow-md" />
                        <div>
                            <h2 class="font-medium text-lg md:text-xl text-blue-900">{{ Auth::user()->name }}</h2>
                            <p class="text-sm md:text-base text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                </a>

                <nav class="space-y-2">
                    @if (Auth::user()->hasRole('Master') ||
                            Auth::user()->hasRole('Administrativo') ||
                            Auth::user()->hasRole('Docente') ||
                            Auth::user()->hasRole('Estudiante'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('Dashboard') }}">
                            <i class="fa-solid fa-home text-lg mr-2 text-blue-900"></i><span
                                class="text-base">Inicio</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('Docente'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('GrupoMateria.docente', Auth::user()->id) }}">
                            <i class="fa-solid fa-home text-lg mr-2 text-blue-900"></i><span class="text-base">Mis
                                grupos</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('Master') || Auth::user()->hasRole('Administrativo'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('Usuario.index') }}">
                            <i class="fa-solid fa-user text-lg mr-2 text-blue-900"></i><span
                                class="text-base">Usuario</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('Master'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('Roles.index') }}">
                            <i class="fa-solid fa-lock text-lg mr-2 text-blue-900"></i><span class="text-base">Roles y
                                Permisos</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('Master') || Auth::user()->hasRole('Administrativo'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('Inscripcion.index') }}">
                            <i class="fas fa-edit text-lg mr-2 text-blue-900"></i><span
                                class="text-base">Inscripcion</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('Master') || Auth::user()->hasRole('Administrativo'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('PagoServicio.index') }}">
                            <i class="fas fa-shopping-cart text-lg mr-2 text-blue-900"></i><span
                                class="text-base">Pagos</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('Master') || Auth::user()->hasRole('Administrativo'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('Servicio.index') }}">
                            <i class="fas fa-store text-lg mr-2 text-blue-900"></i><span
                                class="text-base">Servicios</span>
                        </a>
                    @endif

                    @if (Auth::user()->hasRole('Master') || Auth::user()->hasRole('Administrativo'))
                        <a class="flex items-center text-gray-700 py-2 px-4 rounded transition duration-300 hover:bg-blue-50 shadow"
                            href="{{ route('GrupoMateria.index') }}">
                            <i class="fas fa-users text-lg mr-2 text-blue-900"></i><span class="text-base">Grupos y
                                Materias</span>
                        </a>
                    @endif
                </nav>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="flex-1 p-4 w-full md:w-auto" id="mainContent">
            <div class="mt-1 min-h-full flex flex-wrap space-x-0 space-y-2 md:space-x-4 md:space-y-0">
                <div class="flex-1 bg-white p-4 shadow rounded-lg w-full">
                    @yield('Panza')
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const menuBtn = document.getElementById('menuBtn');
        const sideNav = document.getElementById('sideNav');
        const mainContent = document.getElementById('mainContent');

        menuBtn.addEventListener('click', () => {
            sideNav.classList.toggle('hiddenPanel');
            if (sideNav.classList.contains('hiddenPanel')) {
                mainContent.classList.remove('md:w-auto');
                mainContent.classList.add('w-full');
            } else {
                mainContent.classList.remove('w-full');
                mainContent.classList.add('md:w-auto');
            }
        });
    });
</script>

<style>
    /* La barra lateral está desplegada por defecto */
    .hiddenPanel {
        display: block;
    }

    @media (min-width: 768px) {
        .hiddenPanel {
            display: none;
        }
    }
</style>


</html>
