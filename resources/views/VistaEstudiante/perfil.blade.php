<x-navbar />

<main class="w-full max-w-4xl mx-auto px-4 py-8 md:px-6 md:py-12">
    <div class="bg-white shadow-lg rounded-lg p-8 flex flex-col md:flex-row items-center space-y-6 md:space-y-0 md:space-x-8">
        <div class="flex justify-center md:justify-start">
            <div class="relative w-48 h-48 rounded-lg overflow-hidden shadow-md bg-gray-200">
                <img src="{{ asset( $usuario->profile_photo_path) }}" alt="Foto de Perfil" class="object-cover w-full h-full">
                <label for="upload-photo" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z"/>
                    </svg>
                </label>
                <input type="file" id="upload-photo" class="hidden">
            </div>
        </div>
        <div class="flex-grow">
            <h2 class="text-3xl font-bold mb-6 text-center md:text-left">Perfil del Estudiante</h2>
            <div class="space-y-6">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <label class="block text-gray-700 font-semibold w-48">Nombre Completo</label>
                    <p class="text-gray-900 flex-grow">
                        @if($usuario->nombre) {{ $usuario->nombre }} @endif
                        @if($usuario->apellido_paterno) {{ $usuario->apellido_paterno }} @endif
                        @if($usuario->apellido_materno) {{ $usuario->apellido_materno }} @endif
                        @unless($usuario->nombre || $usuario->apellido_paterno || $usuario->apellido_materno)
                            {{ $usuario->name }}
                        @endunless
                    </p>
                </div>
                @if($usuario->email)
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <label class="block text-gray-700 font-semibold w-48">Correo Electrónico</label>
                    <p class="text-gray-900 flex-grow">{{ $usuario->email }}</p>
                </div>
                @endif

                @if($usuario->carnet_identidad)
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <label class="block text-gray-700 font-semibold w-48">Carnet de Identidad</label>
                    <p class="text-gray-900 flex-grow">{{ $usuario->carnet_identidad }}</p>
                </div>
                @endif

                @if($usuario->telefono)
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <label class="block text-gray-700 font-semibold w-48">Teléfono</label>
                    <p class="text-gray-900 flex-grow">{{ $usuario->telefono }}</p>
                </div>
                @endif

                @if($usuario->fecha_nacimiento)
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <label class="block text-gray-700 font-semibold w-48">Fecha de Nacimiento</label>
                    <p class="text-gray-900 flex-grow">{{ $usuario->fecha_nacimiento }}</p>
                </div>
                @endif
            </div>
            <div class="mt-8 text-center md:text-left">
                <button onclick="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-700 transition duration-300">Editar Perfil</button>
            </div>
        </div>
    </div>
</main>

@include('components.footer')

<!-- Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl">
        <h3 class="text-2xl font-semibold mb-4 text-center">Editar Perfil</h3>
        <form action="{{ route('Estudiante.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="mb-4 flex flex-wrap -mx-2">
                <div class="relative w-24 h-24 rounded-lg overflow-hidden shadow-md bg-gray-200 mx-auto mb-4">
                    <img src="{{ asset( $usuario->profile_photo_path) }}" alt="Foto de Perfil" class="object-cover w-full h-full">
                    <label for="edit-upload-photo" class="absolute bottom-0 right-0 bg-blue-600 text-white p-1 rounded-full cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v16h16V4H4z"/>
                        </svg>
                    </label>
                    <input type="file" id="edit-upload-photo" name="profile_photo" class="hidden">
                </div>
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <label for="nombre" class="block text-gray-700 font-semibold">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="w-full px-3 py-2 border rounded-lg" value="{{ $usuario->nombre }}" readonly>
                </div>
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <label for="apellido_paterno" class="block text-gray-700 font-semibold">Apellido Paterno</label>
                    <input type="text" id="apellido_paterno" name="apellido_paterno" class="w-full px-3 py-2 border rounded-lg" value="{{ $usuario->apellido_paterno }}" readonly>
                </div>
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <label for="apellido_materno" class="block text-gray-700 font-semibold">Apellido Materno</label>
                    <input type="text" id="apellido_materno" name="apellido_materno" class="w-full px-3 py-2 border rounded-lg" value="{{ $usuario->apellido_materno }}" readonly>
                </div>
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <label for="email" class="block text-gray-700 font-semibold">Correo Electrónico</label>
                    <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg" value="{{ $usuario->email }}">
                </div>
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <label for="telefono" class="block text-gray-700 font-semibold">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="w-full px-3 py-2 border rounded-lg" value="{{ $usuario->telefono }}">
                </div>
                <div class="w-full md:w-1/2 px-2 mb-4">
                    <label for="fecha_nacimiento" class="block text-gray-700 font-semibold">Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="w-full px-3 py-2 border rounded-lg" value="{{ $usuario->fecha_nacimiento }}">
                </div>
            </div>
            <div class="flex justify-end">
                <button type="button" onclick="closeModal()" class="bg-gray-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-gray-700 transition duration-300 mr-2">Cancelar</button>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md shadow-md hover:bg-blue-700 transition duration-300">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('editModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
    }
</script>
