<div class="mt-8 overflow-x-auto">
    <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <thead class="bg-gradient-to-r from-blue-500 to-teal-500 text-white uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-center">Nro</th>
                <th class="py-3 px-6 text-left">Materia</th>
                <th class="py-3 px-6 text-left">Grupo</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm font-light">
            @php
                $materias_inscritas = $materias_inscritas ?? [];
            @endphp
            @foreach ($materias_inscritas as $materia)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-3 px-6 text-center">{{ $loop->iteration }}</td>
                    <td class="py-3 px-6 text-left">{{ $materia['nombre_materia'] }}</td>
                    <td class="py-3 px-6 text-left">{{ $materia['nombre_grupo'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
