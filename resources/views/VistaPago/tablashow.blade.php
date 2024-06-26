<table class="min-w-full divide-y divide-gray-200 mt-4 shadow-lg rounded-lg">
    <thead class="bg-gradient-to-r from-blue-500 to-teal-300 text-white">
        <tr>
            <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Nro</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Servicio</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Descripción</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Precio</th>
            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Estado</th>
        </tr>
    </thead>
    <tbody class="bg-white divide-y divide-gray-200">
        @foreach ($servicios as $servicio)
            <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $servicio->nombre }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $servicio->descripcion }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $servicio->precio }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $servicio->pivot->usado ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $servicio->pivot->usado ? 'Usado' : 'No usado' }}
                    </span>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
