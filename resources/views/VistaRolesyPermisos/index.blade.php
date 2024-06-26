@extends('Panza')
@section('Panza')

<h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Administracion De Roles y Permisos</h1>



    <div class="flex justify-center">
        <div class="container">
            <div class="w-full flex mt-8">
                <a href="{{ route('Roles.create') }}"
                    class="ml-auto rounded-xl bg-blue-500 text-white p-3 font-bold shadow-md shadow-gray-400">Crear
                    Rol</a>
                <a href="{{ route('Permisos.create') }}"
                    class="ml-auto rounded-xl bg-blue-500 text-white p-3 font-bold shadow-md shadow-gray-400">Crear
                    Permiso</a>
            </div>
            


            <div class="w-full mt-8">
                <table class="w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border px-4 py-2">#</th>
                            <th class="border px-4 py-2">Rol</th>
                            <th class="border px-4 py-2">Permisos</th>
                            <th class="border px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td class="border px-4 py-2">{{ $role->id }}</td>
                                <td class="border px-4 py-2">{{ $role->name }}</td>
                                <td class="border px-4 py-2">
                                    @foreach($role->permissions as $permission)
                                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td class="border px-4 py-2">
                                    <!-- Botón de editar -->
                                        <a href="{{ route('Roles.edit', $role->id) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Editar
                                        </a>

                                        <!-- Botón de eliminar -->
                                        <form action="{{ route('Roles.destroy', $role->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                Eliminar
                                            </button>
                                        </form>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

@endsection