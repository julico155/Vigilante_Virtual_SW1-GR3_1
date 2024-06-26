<x-navbar />

<main class="w-full max-w-4xl mx-auto px-4 py-8 md:px-6 md:py-12">
    <h1 class="text-4xl font-bold text-gray-800 text-center mb-8">Materia: {{ $materia->nombre }} - Grupo: {{ $grupo->nombre }}</h1>
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Detalles de la materia</h2>
        <div class="space-y-2">
            <p class="text-lg">
                <span class="font-medium">Profesor:</span> {{ $docente->name }}
            </p>
        </div>
    </div>
    <div class="mt-8">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" id="tabExamenes" class="border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg transition-colors">Exámenes</a>
                <a href="#" id="tabEstudiantes" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg transition-colors">Estudiantes Inscritos</a>
                <a href="#" id="tabCalificaciones" class="border-transparent text-gray-500 hover:text-blue-600 hover:border-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-lg transition-colors">Mis Calificaciones</a>
            </nav>
        </div>
        <div id="contentExamenes" class="mt-4">
            <div class="space-y-4">
                @foreach ($examenes as $examen)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden p-6 flex items-center transition transform hover:scale-105 duration-300 hover:shadow-lg">
                        <div class="flex-shrink-0">
                            <div class="bg-pink-500 text-white rounded-full p-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-6 flex-1">
                            <h3 class="text-xl font-bold text-blue-600">{{ $examen->tema }}</h3>
                            <p class="text-gray-700">{{ $examen->descripcion }}</p>
                            <div class="mt-4 space-y-2">
                                @foreach ($ejecuciones->where('examen_id', $examen->id) as $ejecucion)
                                    <p class="text-gray-500"><strong>Abre:</strong> {{ \Carbon\Carbon::parse($ejecucion->fecha . ' ' . $ejecucion->hora_inicio)->locale('es_BO')->isoFormat('dddd, D [de] MMMM [de] YYYY, H:mm') }}</p>
                                    <p class="text-gray-500"><strong>Cierra:</strong> {{ \Carbon\Carbon::parse($ejecucion->fecha . ' ' . $ejecucion->hora_final)->locale('es_BO')->isoFormat('dddd, D [de] MMMM [de] YYYY, H:mm') }}</p>
                                    <p class="text-gray-500"><strong>Estado:</strong>
                                        @if ($ejecucion->estado_ejecucion_id == 1)
                                            <span class="text-yellow-500">En Proceso</span>
                                        @elseif ($ejecucion->estado_ejecucion_id == 2)
                                            <span class="text-green-500">Terminado</span>
                                        @elseif ($ejecucion->estado_ejecucion_id == 3)
                                            <span class="text-red-500">Pendiente</span>
                                        @endif
                                    </p>
                                    @if ($ejecucion->estado_ejecucion_id == 1)
                                        <p id="timer-{{ $ejecucion->id }}" class="text-red-500 font-bold"></p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        <div class="ml-6">
                            <div class="flex space-x-2">
                                @foreach ($ejecuciones->where('examen_id', $examen->id) as $ejecucion)
                                    @if ($ejecucion->estado_ejecucion_id == 3)
                                        <a href="{{ route('Examen.start', $ejecucion->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition">Realizar Examen</a>
                                    @elseif ($ejecucion->estado_ejecucion_id == 1)
                                        <a href="{{ route('Examen.start', $ejecucion->id) }}" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow cursor-not-allowed">Continuar Examen</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div id="contentEstudiantes" class="mt-4">
            <h2 class="text-2xl font-semibold mb-4">Estudiantes Inscritos</h2>
            <div class="border rounded-lg overflow-hidden shadow-lg">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-lg font-medium">Nombre</th>
                            <th class="px-4 py-2 text-left text-lg font-medium">Ver Perfil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes as $estudiante)
                            <tr>
                                <td class="border-b px-4 py-2 text-lg">{{ $estudiante->nombre ? $estudiante->nombre . ' ' . $estudiante->apellido : $estudiante->name }}</td>
                                <td class="border-b px-4 py-2">
                                    <a href="{{ route('Estudiante.perfil', ['id' => $estudiante->id]) }}" class="text-blue-600 hover:underline">Ver Perfil</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="contentCalificaciones" class="mt-4 hidden">
            <h2 class="text-2xl font-semibold mb-4">Mis Calificaciones</h2>
            <div class="border rounded-lg overflow-hidden shadow-lg">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-lg font-medium">Nro</th>
                            <th class="px-4 py-2 text-left text-lg font-medium">Examen</th>
                            <th class="px-4 py-2 text-left text-lg font-medium">Fecha</th>
                            <th class="px-4 py-2 text-left text-lg font-medium">Nota</th>
                            <th class="px-4 py-2 text-left text-lg font-medium">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($calificaciones->isEmpty())
                            <tr>
                                <td colspan="5" class="py-3 px-4 text-sm text-gray-600 text-center">
                                    <img src="{{ asset('path/to/your/icon.png') }}" alt="No hay notas de exámenes" class="mx-auto" style="width: 50px;">
                                    <p>No hay notas de exámenes</p>
                                </td>
                            </tr>
                        @else
                            @foreach ($calificaciones as $index => $calificacion)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $calificacion->ejecucion->examen->tema ?? 'N/A' }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($calificacion->ejecucion->fecha)->locale('es_BO')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $calificacion->nota }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">
                                        <a href="{{ route('Examen.verIntento', ['calificacion' => $calificacion]) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('tabExamenes').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('contentExamenes').classList.remove('hidden');
        document.getElementById('contentEstudiantes').classList.add('hidden');
        document.getElementById('contentCalificaciones').classList.add('hidden');
        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabEstudiantes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabEstudiantes').classList.add('border-transparent', 'text-gray-500');
        document.getElementById('tabCalificaciones').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabCalificaciones').classList.add('border-transparent', 'text-gray-500');
    });

    document.getElementById('tabEstudiantes').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('contentEstudiantes').classList.remove('hidden');
        document.getElementById('contentExamenes').classList.add('hidden');
        document.getElementById('contentCalificaciones').classList.add('hidden');
        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabExamenes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabExamenes').classList.add('border-transparent', 'text-gray-500');
        document.getElementById('tabCalificaciones').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabCalificaciones').classList.add('border-transparent', 'text-gray-500');
    });

    document.getElementById('tabCalificaciones').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('contentCalificaciones').classList.remove('hidden');
        document.getElementById('contentExamenes').classList.add('hidden');
        document.getElementById('contentEstudiantes').classList.add('hidden');
        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabExamenes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabExamenes').classList.add('border-transparent', 'text-gray-500');
        document.getElementById('tabEstudiantes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabEstudiantes').classList.add('border-transparent', 'text-gray-500');
    });

    document.addEventListener('DOMContentLoaded', (event) => {
        const endTime{{ $ejecucion->id }} = new Date('{{ $ejecucion->fecha }} {{ $ejecucion->hora_final }}').getTime();
        const timer{{ $ejecucion->id }} = setInterval(function() {
            const now = new Date().getTime();
            const distance = endTime{{ $ejecucion->id }} - now;

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById("timer-{{ $ejecucion->id }}").innerHTML = hours + "h " + minutes + "m " + seconds + "s ";

            if (distance < 0) {
                clearInterval(timer{{ $ejecucion->id }});
                document.getElementById("timer-{{ $ejecucion->id }}").innerHTML = "EXAMEN TERMINADO";
            }
        }, 1000);
    });

    // Mostrar inicialmente la tabla de estudiantes
    document.getElementById('tabEstudiantes').click();
</script>

@include('components.footer')
