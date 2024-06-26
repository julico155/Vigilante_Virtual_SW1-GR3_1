@extends('Panza')
@section('Panza')

<h1 class="font-bold text-2xl border-b pb-2 text-gray-700/90">Seleccionar Grupo</h1>

<div class="flex justify-center">
    <div class="container max-w-6xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach ($grupo_materias as $grupo_materia)
                <a href="{{route('GrupoMateria.prueba', $grupo_materia->id)}}" class="block transform transition duration-300 hover:scale-105">
                    <div class="bg-white shadow-lg rounded-lg p-6 hover:bg-gray-100">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-blue-500 text-white flex items-center justify-center">
                                    <i class="fa-solid fa-book"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h2 class="text-lg font-semibold text-gray-800">{{$grupo_materia->materia}}</h2>
                                <p class="text-sm text-gray-600">{{$grupo_materia->materia}}</p>
                                <p class="text-sm text-gray-600">Grupo: {{$grupo_materia->grupo}}</p>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</div>

@endsection
