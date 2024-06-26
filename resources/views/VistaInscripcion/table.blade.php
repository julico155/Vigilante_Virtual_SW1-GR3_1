<div class="mt-8 overflow-x-auto">
    <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <thead class="bg-gradient-to-r from-blue-500 to-teal-500 text-white uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-center">No.</th>
                <th class="py-3 px-6 text-left">Estudiante</th>
                <th class="py-3 px-6 text-left">Administrativo</th>
                <th class="py-3 px-6 text-left">Materias Inscritas</th>
                <th class="py-3 px-6 text-center">Hora</th>
                <th class="py-3 px-6 text-center">Fecha</th>
                <th class="py-3 px-6 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm font-light">

            @if ($boleta_inscripcion->isEmpty())
                <tr>
                    <td colspan="7" class="text-center py-4 border border-gray-400">Sin Boleta Inscripcion</td>
                </tr>
            @else
                @foreach ($boleta_inscripcion as $boleta)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200 ease-in-out">
                        <td class="py-3 px-6 text-center">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6 text-left">{{ $boleta->user_estudiante->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $boleta->user_administrativo->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $boleta->cantidad_materias_inscritas }}</td>
                        <td class="py-3 px-6 text-center">{{ $boleta->hora }}</td>
                        <td class="py-3 px-6 text-center">{{ $boleta->fecha }}</td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="{{ route('Inscripcion.edit', $boleta->id) }}" class="w-4 mr-2 transform hover:text-purple-500 hover:scale-125 transition duration-200 ease-in-out">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('Inscripcion.destroy', $boleta->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-4 mr-2 transform hover:text-red-500 hover:scale-125 transition duration-200 ease-in-out">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('Inscripcion.show', $boleta->id) }}" class="w-4 mr-2 transform hover:text-green-500 hover:scale-125 transition duration-200 ease-in-out">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
