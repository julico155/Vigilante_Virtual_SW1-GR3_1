@extends('Panza')

@section('Panza')
    <div class="flex justify-center">
        <form action="{{ route('GrupoMateria.store') }}" method="POST"
            class="bg-white shadow-md rounded-lg px-8 pt-6 pb-8 mb-4 w-full md:w-1/2">
            @csrf

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">¡Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <div class="mb-6">
                <label for="user_docente_id" class="block text-sm font-bold text-gray-700 mb-2">Selecciona un docente</label>
                <div class="relative">
                    <select id="user_docente_id" name="user_docente_id" required
                        class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="">Selecciona un docente</option>
                        @foreach ($docentes as $docente)
                            <option value="{{ $docente->id }}">{{ $docente->name }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 12l-6-6h12l-6 6z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="mb-6">
                <label for="grupo_id" class="block text-sm font-bold text-gray-700 mb-2">Selecciona un grupo</label>
                <div class="relative">
                    <select id="grupo_id" name="grupo_id" required
                        class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="">Selecciona un grupo</option>
                        @foreach ($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 12l-6-6h12l-6 6z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="materia_id" class="block text-sm font-bold text-gray-700 mb-2">Selecciona una materia</label>
                <div class="relative">
                    <select id="materia_id" name="materia_id" required
                        class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:border-blue-500">
                        <option value="">Selecciona una materia</option>
                        @foreach ($materias as $materia)
                            <option value="{{ $materia->id }}">{{ $materia->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path d="M10 12l-6-6h12l-6 6z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <label for="contraseña" class="block text-sm font-bold text-gray-700 mb-2">Ingresa una contraseña
                </label>
                <div class="flex">
                    <input id="contraseña" name="contraseña" type="text" required
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Contraseña">
                    <button id="generate" type="button"
                        class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        🎲
                    </button>
                </div>
            </div>


            <div class="mb-6">
                <label for="cantidad_estudiantes" class="block text-sm font-bold text-gray-700 mb-2">Ingresa la cantidad de
                    estudiantes</label>
                <input id="cantidad_estudiantes" name="cantidad_estudiantes" type="number" min="0" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    oninput="validity.valid||(value='');" placeholder="Cantidad de estudiantes">
            </div>

            <div class="mb-6">
                <label for="cantidad_estudiantes_inscritos" class="block text-sm font-bold text-gray-700 mb-2">Estudiantes
                    inscritos</label>
                <input id="cantidad_estudiantes_inscritos" name="cantidad_estudiantes_inscritos" type="number"
                    min="0" value="0" readonly required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    placeholder="Estudiantes inscritos">
            </div>

            <div class="flex items-center justify-between">
                <button
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                    type="submit">
                    ¡Crear GrupoMateria!
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('generate').addEventListener('click', function() {
            var password = Math.random().toString(36).substr(2, 5);
            document.getElementById('contraseña').value = password;
        });
    </script>
@endsection
