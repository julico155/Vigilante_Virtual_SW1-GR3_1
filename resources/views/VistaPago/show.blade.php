@extends('Panza')
@section('Panza')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Servicios del Usuario
            {{ $comprobante->userEstudiante->name }}
        </h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 items-stretch">
            <a href="{{ route('PagoServicio.show', ['id' => $comprobante->id]) }}"
                class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-blue-500 p-4 rounded-xl shadow-md text-center hover:bg-blue-600 hover:text-white">
                    <h3 id="totalServicios" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">{{ $totalServicios }}</h3>
                    <i class="fas fa-book text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Total De Servicios</span>
                </div>
            </a>
            <a href="{{ route('PagoServicio.show', ['id' => $comprobante->id]) }}"
                class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-green-500 p-4 rounded-xl shadow-md text-center hover:bg-green-600 hover:text-white">
                    <h3 id="serviciosSinUtilizar" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">
                        {{ $totalServiciosSinUtilizar }}</h3>
                    <i class="fas fa-users-cog text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Servicios Sin Utilizar</span>
                </div>
            </a>
            <a href="{{ route('PagoServicio.show', ['id' => $comprobante->id]) }}"
                class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-yellow-500 p-4 rounded-xl shadow-md text-center hover:bg-yellow-600 hover:text-white">
                    <h3 id="serviciosUtilizados" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">
                        {{ $totalServiciosUtilizados }}</h3>
                    <i class="fas fa-users text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Servicios Utilizados</span>
                </div>
            </a>
        </div>


        <div class="flex justify-center mt-8 space-x-4">
            <a href="{{ route('PagoServicio.index') }}"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded shadow-md">Volver</a>
        </div>

        @if (session('success'))
            <div id="flash-message" class="my-4 bg-green-500 text-white p-4 rounded-md shadow-lg text-center text-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="mt-8 overflow-x-auto" id="tableContainer">
            @include('VistaPago.tablashow')
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('totalServicios').textContent = "{{ $totalServicios }}";
        });
        window.onload = function() {
            var flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.display = 'none';
                }, 3000);
            }
        };
    </script>
@endsection
