@extends('Panza')

@section('Panza')
    <div class="container mx-auto py-8">
        <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-8 py-6">
                <h2 class="text-3xl font-extrabold text-blue-900 mb-4">Únete a la Clase</h2>
                <div class="mb-6">
                    <label for="materia" class="block text-sm font-bold text-gray-900 mb-2">Materia:</label>
                    <select id="materia_id" name="materia_id" required
                        class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="">Selecciona una materia</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label for="grupo" class="block text-sm font-bold text-gray-900 mb-2">Grupo:</label>
                    <select id="grupo_id" name="grupo_id" required
                        class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="">Selecciona un grupo</option>
                        @foreach ($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label for="contraseña" class="block text-sm font-bold text-gray-900 mb-2">Contraseña:</label>
                    <input id="contraseña" type="password" class="block w-full px-4 py-2 text-lg text-gray-800 bg-gray-100 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-400 placeholder-gray-400" placeholder="Contraseña">
                </div>
                <div class="flex justify-between">
                    <a href="" class="w-1/2 p-1">
                        <button class="w-full bg-blue-500 text-white py-3 px-6 rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Unirse a la Clase</button>
                    </a>
                    <a href="{{ route('Estudiante.index') }}" class="w-1/2 p-1">
                        <button class="w-full bg-red-500 text-white py-3 px-6 rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Cancelar</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection