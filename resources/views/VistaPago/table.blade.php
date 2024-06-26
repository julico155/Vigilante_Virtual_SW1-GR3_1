<div class="mt-8 overflow-x-auto">
    <table class="min-w-full bg-white shadow-xl rounded-xl overflow-hidden">
        <thead class="bg-gradient-to-r from-blue-500 to-teal-300 text-white">
            <tr>
                <th class="w-1/12 py-4 border-b-2 border-blue-600 text-center">No.</th>
                <th class="w-2/12 py-4 border-b-2 border-blue-600 text-center">Estudiante</th>
                <th class="w-2/12 py-4 border-b-2 border-blue-600 text-center">Administrativo</th>
                <th class="w-1/12 py-4 border-b-2 border-blue-600 text-center">Hora</th>
                <th class="w-1/12 py-4 border-b-2 border-blue-600 text-center">Fecha</th>
                <th class="w-1/12 py-4 border-b-2 border-blue-600 text-center">Monto Total</th>
                <th class="w-2/12 py-4 border-b-2 border-blue-600 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm font-light">
            @if ($comprobantes->isEmpty())
                <tr>
                    <td colspan="7" class="text-center py-5 border border-gray-400">Sin Comprobantes</td>
                </tr>
            @else
                @foreach ($comprobantes as $comprobante)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} transition-colors duration-300 hover:bg-purple-50 hover:shadow-md">
                        <td class="text-center py-4 border border-gray-300 font-semibold">{{ $loop->iteration }}</td>
                        <td class="py-4 px-6 text-center border border-gray-300">{{ optional($comprobante->userEstudiante)->name }}</td>
                        <td class="py-4 px-6 text-center border border-gray-300">{{ optional($comprobante->userAdministrativo)->name }}</td>
                        <td class="text-center py-4 border border-gray-300">{{ $comprobante->hora }}</td>
                        <td class="text-center py-4 border border-gray-300">{{ $comprobante->fecha }}</td>
                        <td class="py-4 px-6 text-center border border-gray-300 font-bold text-green-600">{{ $comprobante->monto_total }}</td>
                        <td class="py-4 px-6 text-center border border-gray-300">
                            <a href="{{ route('PagoServicio.edit', $comprobante->id) }}" class="text-indigo-500 hover:text-indigo-700 font-bold mr-3 transition duration-300 ease-in-out transform hover:scale-110">
                                <i class="fas fa-edit fa-lg"></i>
                            </a>
                            <form action="{{ route('PagoServicio.destroy', $comprobante->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold transition duration-300 ease-in-out transform hover:scale-110">
                                    <i class="fas fa-trash fa-lg"></i>
                                </button>
                            </form>
                            <a href="{{ route('PagoServicio.show', $comprobante->id) }}" class="text-gray-500 hover:text-indigo-500 font-bold transition duration-300 ease-in-out transform hover:scale-110">
                                <i class="fas fa-eye fa-lg"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
