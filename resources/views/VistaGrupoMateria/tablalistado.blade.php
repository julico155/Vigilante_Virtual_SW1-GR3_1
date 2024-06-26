<div class="overflow-x-auto">
    <table class="w-full border-collapse table-fixed">
        <thead>
            <tr class="bg-blue-300">
                <th class="w-1/12 py-3 border border-black">No.</th>
                <th class="w-1/12 py-3 border border-black">Grupo</th>
                <th class="w-2/12 py-3 border border-black">Materia</th>
                <th class="w-2/12 py-3 border border-black">Contraseña</th>
                <th class="w-2/12 py-3 border border-black">Cantidad de Estudiantes</th>
                <th class="w-2/12 py-3 border border-black">Estudiantes Inscritos</th>
                <th class="w-2/12 py-3 border border-black">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                $counter = 1;
            @endphp
            @if ($grupoMaterias->isEmpty())
                <tr>
                    <td colspan="7" class="text-center py-4 border border-gray-400">Sin Grupo-Materia</td>
                </tr>
            @else
                @foreach ($grupoMaterias as $grupoMateria)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} transition-colors duration-300 hover:bg-blue-400">
                        <td class="text-center py-2 border border-gray-400">{{ $counter++ }}</td>
                        <td class="py-2 px-4 text-center border border-gray-400">{{ $grupoMateria->grupo->nombre }}</td>
                        <td class="py-2 px-4 border border-gray-400">{{ $grupoMateria->materia->nombre }}</td>
                        <td class="text-center py-2 border border-gray-400">{{ $grupoMateria->contraseña }}</td>
                        <td class="text-center py-2 border border-gray-400">{{ $grupoMateria->cantidad_estudiantes }}</td>
                        <td class="text-center py-2 border border-gray-400">{{ $grupoMateria->cantidad_estudiantes_inscritos }}</td>
                        <td class="py-2 px-4 text-center border border-gray-400">
                            {{-- <a href="{{ route('GrupoMateria.edit', $grupoMateria->id) }}"
                                class="text-blue-500 hover:text-blue-700 font-bold mr-3 transition duration-300 transform hover:scale-110">
                                <i class="fas fa-edit fa-lg"></i>
                            </a> --}}
                            {{-- <form action="{{ route('GrupoMateria.destroy', $grupoMateria->id) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 font-bold mr-3 transition duration-300 transform hover:scale-110">
                                    <i class="fas fa-trash fa-lg"></i>
                                </button>
                            </form> --}}
                            <a href="{{ route('ListaEstudiantes.show', $grupoMateria->id) }}"
                                class="text-gray-500 hover:text-blue-500 font-bold transition duration-300 transform hover:scale-110">
                                <i class="fas fa-eye fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
