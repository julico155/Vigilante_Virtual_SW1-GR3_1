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


    <!-- Styles -->
    @livewireStyles
</head>
<div class="flex flex-col min-h-screen h-auto bg-gray-300">
    <div class="bg-blue-900 text-white shadow w-full p-2 flex items-center justify-between">
        <div class="flex items-center">
            <span class="font-extrabold uppercase text-xl">Verificador</span><span class=" text-xl uppercase ml-1">online.com</span>
            <div class="md:hidden flex items-center">
                <button id="menuBtn">
                    <i class="fas fa-bars text-gray-500 text-lg"></i>
                </button>
            </div>
        </div>
        <div class="space-x-5">
            <button>
                <i class="fas fa-user text-white text-lg"></i>
                <span class="text-white hidden md:inline">{{ Auth::user()->name }}</span>
            </button>
        </div>
    </div>
    <div class="flex-1 flex flex-wrap">
        <div class="flex-1 p-4 w-full md:w-1/2">
            <div class="mt-1 min-h-full flex flex-wrap space-x-0 space-y-2 md:space-x-4 md:space-y-0">
                <div class="flex-1  bg-white shadow rounded-lg w-full overflow-hidden">
                    @yield('Panza')
                </div>
            </div>
        </div>
    </div>
</div>