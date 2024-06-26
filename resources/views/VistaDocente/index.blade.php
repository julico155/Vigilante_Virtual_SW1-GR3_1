@extends('Panza')
@section('Panza')
<div>
    <div class="container mx-auto mt-8">
        <div class="max-w-xl mx-auto bg-white rounded-lg overflow-hidden shadow-lg mt-8 border border-gray-200">
            <div class="px-8 py-6">
                <h2 class="text-3xl text-center font-semibold text-gray-800">Bienvenido, {{ Auth::user()->name }}👋</h2>

                <div class="flex items-center justify-center mt-4">
                    @if (Auth::user()->profile_photo_path)
                        <img class="w-32 h-32 rounded-full mr-4 border-2 border-blue-500" src="{{ Auth::user()->profile_photo_path }}" alt="Foto de perfil">
                    @else
                        <div class="w-32 h-32 rounded-full bg-gray-300 mr-4 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                    @endif
                </div>

                <div class="mt-6 space-y-4 text-gray-700">

                    @if (Auth::user()->carnet_identidad)
                        <p class="flex items-center"><strong class="w-1/3">CI:</strong> <span class="w-2/3">{{ Auth::user()->carnet_identidad }}</span></p>
                    @endif
                    @if(Auth::user()->nombre)
                    @if (Auth::user()->nombre)
                        <p class="flex items-center"><strong class="w-1/3">Nombre:</strong> <span class="w-2/3">{{ Auth::user()->nombre }}</span></p>
                    @endif

                    @if (Auth::user()->apellido_paterno)
                        <p class="flex items-center"><strong class="w-1/3">Apellido Paterno:</strong> <span class="w-2/3">{{ Auth::user()->apellido_paterno }}</span></p>
                    @endif

                    @if (Auth::user()->apellido_materno)
                        <p class="flex items-center"><strong class="w-1/3">Apellido Materno:</strong> <span class="w-2/3">{{ Auth::user()->apellido_materno }}</span></p>
                    @endif
                    @else
                        <p class="flex items-center"><strong class="w-1/3">Nombre:</strong> <span class="w-2/3">{{ Auth::user()->name }}</span></p>
                    @endif

                    @if (Auth::user()->telefono)
                        <p class="flex items-center"><strong class="w-1/3">Teléfono:</strong> <span class="w-2/3">{{ Auth::user()->telefono }}</span></p>
                    @endif

                    @if (Auth::user()->fecha_nacimiento)
                        <p class="flex items-center"><strong class="w-1/3">Fecha de Nacimiento:</strong> <span class="w-2/3">{{ Auth::user()->fecha_nacimiento }}</span></p>
                    @endif

                    <p class="flex items-center"><strong class="w-1/3">Correo:</strong> <span class="w-2/3">{{ Auth::user()->email }}</span></p>
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('Estudiante.editar', ['id' => Auth::user()->id]) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow-md transition duration-300">Editar</a>
                </div>
            </div>
        </div>
    </div>

    <p class="text-black text-center py-4 text-xl"><strong>Mis Materias</p>
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <!-- cursos activos del usuario (modificar despues)-->

        @foreach ($grupomaterias as $grupomateria)
            <div class="bg-white overflow-hidden shadow-lg rounded-lg border-t-4 border-blue-900">
                <div class="px-6 py-4">
                    <h3 class="font-bold text-xl text-gray-800 mb-2">{{ $grupomateria['materia']->sigla }} - {{ $grupomateria['materia']->nombre }} Grupo: {{ $grupomateria['grupo']->nombre }}</h3>
                    <p class="text-gray-700 text-base">{{ $grupomateria['materia']->descripcion}} </p>
                </div>
                <div class="px-4 py-2 bg-gray-100">
                    <a href="{{ route('Docente.materia', ['id' => $grupomateria['gp']->id]) }}" class="text-blue-600 hover:underline">Ver detalles</a>
                </div>
            </div>
        @endforeach
    </div>
</div>


@endsection
