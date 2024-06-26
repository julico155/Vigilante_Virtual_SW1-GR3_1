<div class="mt-8 overflow-x-auto">
    <div class="flex justify-center mt-4">
        <button id="deselectAll" type="button"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
            Deseleccionar Todos
        </button>
    </div>

    <table class="min-w-full divide-y divide-gray-200 mt-4 shadow-lg rounded-lg">
        <thead class="bg-gradient-to-r from-blue-500 to-teal-300 text-white">
            <tr>
                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Nro</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Servicio</th>
                <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Precio</th>
                <th class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Seleccionar</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($servicios as $servicio)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $servicio->nombre }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $servicio->precio }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                        <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}"
                            data-precio="{{ $servicio->precio }}" class="form-checkbox h-5 w-5 text-blue-600">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
    document.getElementById('deselectAll').addEventListener('click', function () {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = false;
        });
        localStorage.removeItem('checkedServices');
        updateTotal();
    });
</script>
