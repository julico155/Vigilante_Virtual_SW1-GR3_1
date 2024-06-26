@extends('Panza')
@section('Panza')

<main class="w-full max-w-4xl mx-auto px-4 py-8 md:px-6 md:py-12">
    <h1 class="text-3xl font-bold mb-4">Materia: {{ $materia->nombre }} - Grupo: {{ $grupo->nombre }}</h1>
    <div>
        <h2 class="text-xl font-semibold mb-2">Detalles de la materia</h2>
        <div class="space-y-2">
            <p>
                <span class="font-medium">Profesor:</span> {{ Auth::user()->name }}
            </p>
        </div>
    </div>
    <div class="mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" id="tabExamenes" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Exámenes</a>
                <a href="#" id="tabEstudiantes" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Estudiantes Inscritos</a>
            </nav>
        </div>
        <div id="contentExamenes" class="mt-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-semibold">Exámenes</h2>
                <a href="{{ route('Examen.create', ['id' => $gp->id]) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Crear Examen</a>
            </div>
        </div>
        <div id="contentEstudiantes" class="mt-4 hidden">
            <h2 class="text-xl font-semibold mb-2">Estudiantes Inscritos</h2>
            <div class="border rounded-lg overflow-hidden">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100 dark:bg-gray-800">
                        <tr>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Ver Perfil</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estudiantes as $estudiante)
                            <tr>
                                <td class="border-b px-4 py-2">{{ $estudiante->nombre ? $estudiante->nombre . ' ' . $estudiante->apellido : $estudiante->name }}</td>
                                <td class="border-b px-4 py-2">
                                    <a href="{{ route('Estudiante.perfil', ['id' => $estudiante->id]) }}" class="text-blue-600 hover:underline">Ver Perfil</a>
                                </td>
                            </tr>
                        @endforeach
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
        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabEstudiantes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabEstudiantes').classList.add('border-transparent', 'text-gray-500');
    });

    document.getElementById('tabEstudiantes').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('contentEstudiantes').classList.remove('hidden');
        document.getElementById('contentExamenes').classList.add('hidden');
        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabExamenes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabExamenes').classList.add('border-transparent', 'text-gray-500');
    });

    // Mostrar inicialmente la tabla de estudiantes
    document.getElementById('tabEstudiantes').click();
</script>

@endsection
