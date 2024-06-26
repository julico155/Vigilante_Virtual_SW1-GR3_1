@extends('Panza')
@section('Panza')
    @if (session('error'))
        <div id="flash-message"
            class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 p-4 bg-red-500 text-white rounded-lg shadow-lg text-center text-lg transition-all duration-500 ease-in-out"
            style="opacity: 1; z-index: 50;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('Inscripcion.update', $boleta_inscripcion->id) }}" method="POST"
        class="w-full mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        @method('PUT')
        <div class="flex mb-4">
            <div class="w-1/2 mr-2">
                <label for="carnet_identidad" class="block text-gray-700 font-bold mb-2">Carnet de Identidad</label>
                <input type="text" name="carnet_identidad" id="carnet_identidad"
                    value="{{ $user_estudiante->carnet_identidad }}" placeholder="Nombre Del Usuario"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
            <div class="w-1/2 mr-2">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nombre Del Usuario</label>
                <input type="text" name="name" id="name" value="{{ $user_estudiante->name }}"
                    placeholder="Nombre Del Usuario"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
        </div>
        <div class="flex mb-4">
            <div class="w-1/3 mr-2">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre</label>
                <input type="text" name="nombre" id="nombre" value="{{ $user_estudiante->nombre }}"
                    placeholder="Nombre"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
            <div class="w-1/3 mr-2">
                <label for="apellido_paterno" class="block text-gray-700 font-bold mb-2">Apellido Paterno</label>
                <input type="text" name="apellido_paterno" id="apellido_paterno"
                    value="{{ $user_estudiante->apellido_paterno }}" placeholder="Apellido Paterno"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
            <div class="w-1/3 ml-2">
                <label for="apellido_materno" class="block text-gray-700 font-bold mb-2">Apellido Materno</label>
                <input type="text" name="apellido_materno" id="apellido_materno"
                    value="{{ $user_estudiante->apellido_materno }}" placeholder="Apellido Materno"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
        </div>

        <div id="total" class="text-center font-bold mb-4">Total De Materias inscritas: {{ $total_materias_inscritas }}</div>

        <div class="mt-8 overflow-x-auto" id="tableContainer">
            @include('VistaInscripcion.tablaedit', [
                'grupomaterias' => $grupomaterias,
                'inscribedGrupoMaterias' => $inscribedGrupoMaterias,
            ])
        </div>
        <div class="flex justify-center mt-8">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                Actualizar
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.opacity = '0';
                    setTimeout(function() {
                        flashMessage.style.display = 'none';
                    }, 500);
                }, 3000);
            }
            fetch('/obtener-grupo-materias/' + '{{ $boleta_inscripcion->id }}')
                .then(response => response.json())
                .then(data => {
                    window.grupoMaterias = data;
                    addCheckboxListeners();
                    updateTotal();
                });
        });

        document.getElementById('carnet_identidad').addEventListener('change', function() {
            fetch('/obtener-carnet/' + this.value)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.name;
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellido_paterno').value = data.apellido_paterno;
                    document.getElementById('apellido_materno').value = data.apellido_materno;
                });
        });

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var searchValue = document.getElementById('searchInput').value;

            axios.get('{{ route('Inscripcion.edit', $boleta_inscripcion->id) }}', {
                    params: {
                        search: searchValue
                    }
                })
                .then(function(response) {
                    document.getElementById('tableContainer').innerHTML = response.data.view;
                    document.getElementById('total').innerText =
                        `Total De Materias inscritas: ${response.data.total}`;
                    document.getElementById('clearButton').style.display = 'inline-flex';
                    addCheckboxListeners();
                    updateTotal();
                })
                .catch(function(error) {
                    console.error(error);
                });
        });

        document.getElementById('clearButton').addEventListener('click', function() {
            document.getElementById('searchInput').value = '';
            this.style.display = 'none';
            document.getElementById('searchForm').dispatchEvent(new Event('submit'));
        });

        document.getElementById('deselectAll').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            localStorage.removeItem('checkedMaterias');
            updateTotal();
        });

        function addCheckboxListeners() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var savedCheckboxes = JSON.parse(localStorage.getItem('checkboxes')) || [];

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    var checkedMaterias = Array.from(checkboxes).filter(checkbox => checkbox.checked);
                    document.getElementById('total').innerText =
                        `Total De Materias inscritas: ${checkedMaterias.length}`;

                    localStorage.setItem('checkboxes', JSON.stringify(checkedMaterias.map(checkbox =>
                        checkbox.value)));
                });

                if (window.grupoMaterias.includes(checkbox.value) || savedCheckboxes.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
        }

        function updateTotal() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            var checkedMaterias = Array.from(checkboxes).filter(checkbox => checkbox.checked);
            document.getElementById('total').innerText =
                `Total De Materias inscritas: ${checkedMaterias.length}`;
        }

        document.addEventListener('DOMContentLoaded', function() {
            addCheckboxListeners();
            updateTotal();
        });

        document.getElementById('registrar').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            localStorage.removeItem('checkedMaterias');
            updateTotal();
        });
    </script>
@endsection
