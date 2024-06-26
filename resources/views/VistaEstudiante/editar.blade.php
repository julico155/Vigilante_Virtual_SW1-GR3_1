@extends('Panza')

@section('Panza')
<main class="w-full max-w-lg mx-auto px-4 py-8 md:px-6 md:py-12">
    <h1 class="text-3xl font-bold mb-4">Editar Usuario</h1>
    
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('Estudiante.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="mb-4">
            <label for="carnet_identidad" class="block text-gray-700">Carnet de Identidad</label>
            <input type="text" name="carnet_identidad" id="carnet_identidad" value="{{ old('carnet_identidad', $usuario->carnet_identidad) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @error('carnet_identidad') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="nombre" class="block text-gray-700">Nombre</label>
            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $usuario->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @error('nombre') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="apellido_paterno" class="block text-gray-700">Apellido Paterno</label>
            <input type="text" name="apellido_paterno" id="apellido_paterno" value="{{ old('apellido_paterno', $usuario->apellido_paterno) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @error('apellido_paterno') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="apellido_materno" class="block text-gray-700">Apellido Materno</label>
            <input type="text" name="apellido_materno" id="apellido_materno" value="{{ old('apellido_materno', $usuario->apellido_materno) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @error('apellido_materno') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="telefono" class="block text-gray-700">Teléfono</label>
            <input type="text" name="telefono" id="telefono" value="{{ old('telefono', $usuario->telefono) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @error('telefono') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="fecha_nacimiento" class="block text-gray-700">Fecha de Nacimiento</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento', $usuario->fecha_nacimiento) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            @error('fecha_nacimiento') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="profile_photo_path" class="block text-gray-700">Foto de Perfil</label>
            <input type="file" name="profile_photo_path" id="profile_photo_path" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" >
            @error('profile_photo_path') <span class="text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            @if($usuario->profile_photo_path)
                <img src="{{ asset($usuario->profile_photo_path) }}" alt="Foto de Perfil" class="w-32 h-32 rounded-full mb-4">
            @endif
        </div>

        <div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Guardar Cambios</button>
        </div>
    </form>
</main>
@endsection
