@extends('Panza')
@section('Panza')
    <div class="container mx-auto mt-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-extrabold text-blue-900 text-3xl uppercase">Historial de Exámenes</h1>
            <a href="{{ route('Estudiante.index') }}" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Volver</a>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($examenes_dados as $examen)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 flex flex-col justify-between h-full">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $examen['tema'] }}</h3>
                        <p class="text-gray-600 mb-4">{{ $examen['descripcion'] }}</p>
                        <div class="flex flex-col text-sm text-gray-600 mb-2">
                            <div class="flex items-center mb-2">
                                <span>Fecha: {{ $examen['fecha_ejecucion'] }}</span>
                            </div>
                            <div class="flex items-center">
                                <span>Estado: {{ $examen['estado'] }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button class="w-full bg-blue-500 text-white py-3 px-6 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Visualizar</button>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>

        <!--Este es solo para ver como se muestra-->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Tarjeta de Ejemplo -->
            <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Tema del Examen</h3>
                    <p class="text-sm text-gray-600 mb-4">Descripción del examen...</p>
                    <div class="flex items-center justify-between text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fa-regular fa-calendar-days"></i>
                            <span>Fecha: 2024-04-01</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fa-regular fa-square-check"></i>
                            <span>Estado: Completado</span>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 bg-gray-100 border-t border-gray-200">
                    <button class="w-full bg-blue-500 text-white py-3 px-6 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Visualizar</button>
                </div>
            </div>
        </div>
    </div>

@endsection