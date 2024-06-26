<div class="mt-8 overflow-x-auto">
    <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <thead class="bg-gradient-to-r from-blue-500 to-teal-500 text-white uppercase text-sm leading-normal">
            <tr>
                <th class="py-3 px-6 text-center">Nro</th>
                <th class="py-3 px-6 text-left">Materia Y Grupo</th>
                <th class="py-3 px-6 text-center">Seleccionar</th>
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm font-light">
            @foreach ($grupomaterias as $grupomateria)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200 ease-in-out">
                    <td class="py-3 px-6 text-center">{{ $loop->iteration }}</td>
                    <td class="py-3 px-6 text-left">{{ $grupomateria->materia->nombre }} - {{ $grupomateria->grupo->nombre }}</td>
                    <td class="py-3 px-6 text-center">
                        <input type="checkbox" name="grupomaterias[]" value="{{ $grupomateria->id }}"
                            class="form-checkbox h-5 w-5 text-blue-600"
                            {{ in_array($grupomateria->id, $inscribedGrupoMaterias) ? 'checked' : '' }}>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
