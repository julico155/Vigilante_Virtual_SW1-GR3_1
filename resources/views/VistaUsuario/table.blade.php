<table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
    <thead class="bg-gradient-to-r from-blue-700 to-black text-white uppercase text-sm leading-normal">
        <tr>
            <th class="py-3 px-6 text-left">Usuario</th>
            <th class="py-3 px-6 text-left">Nombre del Usuario</th>
            <th class="py-3 px-6 text-center">Rol</th>
            <th class="py-3 px-6 text-center">Usuarios Creables</th>
            <th class="py-3 px-6 text-center">Acciones</th>
        </tr>
    </thead>
    <tbody class="text-black text-sm font-light">
        @foreach ($usuarios as $usuario)
            @if (auth()->user()->hasRole('Master') || !$usuario->hasRole('Master'))
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-3 px-6 text-left">
                        <a href="{{ route('Usuario.show', $usuario->id) }}" class="flex items-center text-blue-600 hover:text-blue-800">
                            <div class="mr-4 flex justify-center items-center w-12 h-12 rounded-full border-2 border-blue-500 shadow-lg bg-blue-900 text-white">
                                @if ($usuario->profile_photo_path)
                                    <img class="w-12 h-12 rounded-full" src="{{ asset('images/user/' . basename($usuario->profile_photo_path)) }}" alt="Profile Photo">
                                @else
                                    <span class="text-xl">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="font-semibold text-lg">{{ $usuario->name }}</span>
                                <p class="text-gray-500 text-xs">{{ $usuario->email }}</p>
                            </div>
                        </a>
                    </td>
                    <td class="py-3 px-6 text-left">
                        <a href="{{ route('Usuario.show', $usuario->id) }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</a>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex items-center justify-center">
                            @if ($usuario->roles->isNotEmpty())
                                @foreach ($usuario->roles as $rol)
                                    <span class="bg-blue-300 text-black-700 py-1 px-3 rounded-full text-xs mr-2">{{ $rol->name }}</span>
                                @endforeach
                            @else
                                <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs">Por designar</span>
                            @endif
                        </div>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <span class="bg-blue-100 text-black py-1 px-3 rounded-full text-xs">{{ $usuario->usuarios_creables }}</span>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('Usuario.edit', $usuario->id) }}" class="w-4 mr-2 transform hover:text-blue-500 hover:scale-125 transition duration-200 ease-in-out">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('Usuario.destroy', $usuario->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-125 transition duration-200 ease-in-out">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
