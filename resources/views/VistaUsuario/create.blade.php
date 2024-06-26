@extends('Panza')

@section('Panza')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Crear Usuario</h1>

    <form id="userForm" action="{{ route('Usuario.store') }}" method="POST" enctype="multipart/form-data" class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="mb-4">
            <label for="profile_photo_path" class="block text-gray-700 font-bold mb-2">Foto de Perfil</label>
            <input type="file" name="profile_photo_path" id="profile_photo_path" class="hidden rounded-full" onchange="loadImage(event)">
            <label for="profile_photo_path" class="cursor-pointer block w-full h-32 border border-gray-300 rounded-lg text-center leading-8 relative overflow-hidden">
                <span id="select_image_text" class="text-gray-500">Selecciona una imagen</span>
                <img id="preview_image" class="hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-32 h-32 object-cover rounded-full" alt="">
            </label>
        </div>
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre</label>
            <input type="text" name="name" id="name" placeholder="Nombre" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Correo Electrónico</label>
            <input type="email" name="email" id="email" placeholder="Correo Electrónico" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700 font-bold mb-2">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="Contraseña" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar Contraseña" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-bold mb-2">Rol</label>
            <select name="role" id="role" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @foreach ($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <div id="cantidad_usuarios_container" class="mb-4 hidden">
            <label for="cantidad_usuarios" class="block text-gray-700 font-bold mb-2">Cantidad de Usuarios</label>
            <input type="number" name="cantidad_usuarios" id="cantidad_usuarios" placeholder="Cantidad de Usuarios" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" id="submitButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Registrar</button>
        </div>
    </form>

    <script>
        const roleSelect = document.getElementById('role');
        const cantidadUsuariosContainer = document.getElementById('cantidad_usuarios_container');

        function showCantidadUsuarios() {
            const selectedRole = roleSelect.value;
            const show = selectedRole === 'Administrativo' || selectedRole === 'Administrativo Premium';
            cantidadUsuariosContainer.classList.toggle('hidden', !show);
        }

        showCantidadUsuarios();
        roleSelect.addEventListener('change', showCantidadUsuarios);

        function loadImage(event) {
            var output = document.getElementById('preview_image');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src)
                output.classList.remove('hidden');
                document.getElementById('select_image_text').classList.add('hidden');
            }
        }
    </script>
</div>
@endsection
