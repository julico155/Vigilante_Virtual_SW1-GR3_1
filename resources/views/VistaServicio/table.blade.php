<div class="mt-8 overflow-x-auto">
    <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <thead class="bg-gradient-to-r from-blue-500 to-teal-500 text-white uppercase text-sm leading-normal">
            <tr>
                <th class="w-1/12 py-3 border-b-2 border-blue-500 text-center">No.</th>
                <th class="w-2/12 py-3 border-b-2 border-blue-500 text-center">Nombre</th>
                <th class="w-4/12 py-3 border-b-2 border-blue-500 text-center">Descripción</th>
                <th class="w-2/12 py-3 border-b-2 border-blue-500 text-center">Fecha</th>
                <th class="w-1/12 py-3 border-b-2 border-blue-500 text-center">Precio</th>
                <th class="w-2/12 py-3 border-b-2 border-blue-500 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm font-light">
            @if($servicios->isEmpty())
                <tr>
                    <td colspan="6" class="text-center py-4 border border-gray-400">Sin Servicios</td>
                </tr>
            @else
                @foreach ($servicios as $servicio)
                    <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} transition duration-300 ease-in-out transform hover:bg-blue-50 hover:shadow-lg">
                        <td class="text-center py-4 border border-gray-300 font-semibold">{{ $loop->iteration }}</td>
                        <td class="py-3 px-4 border border-gray-300 text-center">{{ $servicio->nombre }}</td>
                        <td class="py-3 px-4 border border-gray-300 text-center">{{ $servicio->descripcion }}</td>
                        <td class="text-center py-3 border border-gray-300">{{ $servicio->fecha }}</td>
                        <td class="text-center py-3 border border-gray-300 font-bold text-green-500">{{ $servicio->precio }}</td>
                        <td class="py-3 px-4 text-center border border-gray-300">
                            <a href="{{ route('Servicio.edit', $servicio->id) }}" class="text-blue-500 hover:text-blue-700 font-bold mr-3 transition duration-300 transform hover:scale-125">
                                <i class="fas fa-edit fa-lg"></i>
                            </a>
                            @if($servicio->nombre !== 'Matricula')
                                <form action="{{ route('Servicio.destroy', $servicio->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-bold mr-3 transition duration-300 transform hover:scale-125">
                                        <i class="fas fa-trash fa-lg"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
