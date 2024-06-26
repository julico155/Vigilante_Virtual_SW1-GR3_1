<x-navbar />

<div class="flex justify-center py-8">
    <div class="container max-w-4xl">
        <!-- Encabezado del Examen -->
        <div class="border p-8 bg-white shadow-md rounded-lg">
            <h1 class="text-4xl font-semibold text-gray-800 mb-2">{{$examen->tema}}</h1>
            <p class="text-lg text-gray-600">{{$examen->descripcion}}</p>
        </div>

        <!-- Información de la Calificación -->
        <div class="mt-8 border p-8 bg-white shadow-md rounded-lg">
            <h3 class="font-bold text-red-500 text-center">Examen finalizado</h3>
            <div class="text-center mt-4">
                <h2 class="text-2xl text-gray-400">Su nota final:</h2>
                <h4 class="text-5xl font-bold text-gray-800 mt-2">{{$calificacion->nota}} / 100</h4>
            </div>

            <!-- Botones de Acción -->
            <div class="w-full flex justify-between mt-8">
                <a href="{{route('Estudiante.index')}}" class="text-blue-500 hover:underline flex items-center">
                    <i class="fa-solid fa-backward mr-2"></i>Volver a Curso
                </a>
                @if ($ejecucion->retroalimentacion)
                <a href="{{route('Examen.verIntento', $calificacion->id)}}" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-700 transition duration-300">
                    Ver Examen
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

@include('components.footer')

<!-- Incluye Font Awesome para los íconos -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
