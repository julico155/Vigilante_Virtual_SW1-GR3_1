<div class="mt-8 overflow-x-auto">
    <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <thead class="bg-gradient-to-r from-blue-500 to-teal-500 text-white uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-left">No.</th>
                <th class="py-3 px-6 text-left">Grupo</th>
                <th class="py-3 px-6 text-center">Materia</th>
                <th class="py-3 px-6 text-center">Docente</th>
                <th class="py-3 px-6 text-center">Contraseña</th>
                <th class="py-3 px-6 text-center">Cantidad de Estudiantes</th>
                <th class="py-3 px-6 text-center">Estudiantes Inscritos</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm font-light">
            @forelse ($grupoMaterias as $index => $grupoMateria)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-3 px-6 text-left">{{ $index + 1 }}</td>
                    <td class="py-3 px-6 text-left">{{ $grupoMateria->grupo->nombre }}</td>
                    <td class="py-3 px-6 text-center">{{ $grupoMateria->materia->nombre }}</td>
                    <td class="py-3 px-6 text-center">{{ optional($grupoMateria->userDocente)->name }}</td>
                    <td class="py-3 px-6 text-center">{{ $grupoMateria->contraseña }}</td>
                    <td class="py-3 px-6 text-center">{{ $grupoMateria->cantidad_estudiantes }}</td>
                    <td class="py-3 px-6 text-center">{{ $grupoMateria->cantidad_estudiantes_inscritos }}</td>
                    <td class="py-3 px-6 text-center">
                        <div class="flex item-center justify-center">
                            <a href="{{ route('GrupoMateria.edit', $grupoMateria->id) }}"
                                class="w-4 mr-2 transform hover:text-purple-500 hover:scale-125 transition duration-200 ease-in-out">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('GrupoMateria.destroy', $grupoMateria->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-4 mr-2 transform hover:text-red-500 hover:scale-125 transition duration-200 ease-in-out">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('GrupoMateria.show', $grupoMateria->id) }}"
                                class="w-4 mr-2 transform hover:text-green-500 hover:scale-125 transition duration-200 ease-in-out">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-4">Sin Grupo-Materia</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
