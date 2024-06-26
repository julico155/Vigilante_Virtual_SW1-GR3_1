<x-navbar />

<div class="container mx-auto py-8 px-4 md:px-6">
    <h1 class="text-4xl font-bold text-gray-800 text-center mb-12">Mis Materias</h1>
    @if(empty($grupomaterias))
        <div class="flex flex-col items-center justify-center h-64 bg-white border border-gray-200 rounded-lg shadow-lg">
            <svg class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m0-4h.01M12 14h.01M5 13h.01M19 13h.01M6 10h.01M18 10h.01M7 7h.01M17 7h.01M4 4h16v16H4z" />
            </svg>
            <p class="text-gray-500 text-xl text-center font-semibold">No hay materias inscritas actualmente.<br>¡Por favor, regístrate en tus materias para verlas aquí!</p>
        </div>
    @else
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
            @foreach ($grupomaterias as $grupomateria)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden transition-shadow duration-300 hover:shadow-xl">
                    <div class="p-6 bg-blue-600 text-white">
                        <h3 class="font-bold text-2xl">{{ $grupomateria['materia']->sigla }} - {{ $grupomateria['materia']->nombre }}</h3>
                        <p class="text-sm mt-2">{{ $grupomateria['materia']->descripcion }}</p>
                        <div class="mt-4 flex items-center">
                            <span class="text-lg">{{ $grupomateria['grupo']->nombre }}</span>
                        </div>
                    </div>
                    <div class="p-6 bg-gray-50">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <svg class="h-6 w-6 text-gray-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6.5 21c0-2.19 1.36-4.03 3.28-4.72C10.67 16.21 11.32 16 12 16s1.33.21 1.22.28C15.14 16.97 16.5 18.81 16.5 21H6.5z" />
                                </svg>
                                <span class="text-gray-800 font-semibold">Docente: {{ $grupomateria['docente']->name }}</span>
                            </div>
                            <a href="{{ route('Estudiante.materia', ['id' => $grupomateria['gp']->id]) }}" class="text-blue-600 hover:text-blue-800 transition-colors font-semibold">Ver detalles</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@include('components.footer')

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
