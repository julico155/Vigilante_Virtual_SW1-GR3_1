@extends('Panza')
@section('Panza')
    <div class="mt-8 flex justify-center">
        <form id="searchForm" method="GET" action="{{ route('Inscripcion.create') }}" class="w-full max-w-lg">
            <div class="flex items-center border-b-2 border-teal-500 py-2">
                <input type="text" id="searchInput" name="search" placeholder="Buscar Materia Y Grupo"
                    class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                <button type="submit" id="searchButton"
                    class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded">Buscar</button>
                <button type="button" id="clearButton"
                    class="flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 rounded ml-2"
                    style="display: none;">Eliminar filtro</button>
            </div>
        </form>
    </div>
    @if (session('error'))
        <div id="flash-message"
            class="fixed top-0 left-1/2 transform -translate-x-1/2 mt-4 p-4 bg-red-500 text-white rounded-lg shadow-lg text-center text-lg transition-all duration-500 ease-in-out"
            style="opacity: 1; z-index: 50;">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ route('Inscripcion.store') }}" method="POST"
        class="w-full mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        @csrf
        <div class="flex mb-4">
            <div class="w-1/2 mr-2">
                <label for="carnet_identidad" class="block text-gray-700 font-bold mb-2">Carnet de Identidad</label>
                <input type="number" name="carnet_identidad" id="carnet_identidad" placeholder="Carnet de Identidad"
                    min="0"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="w-1/2 mr-2">
                <label for="name" class="block text-gray-700 font-bold mb-2">Nombre Del Usuario</label>
                <input type="text" name="name" id="name" placeholder="Nombre Del Usuario"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
        </div>
        <div class="flex mb-4">
            <div class="w-1/3 mr-2">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
            <div class="w-1/3 mr-2">
                <label for="apellido_paterno" class="block text-gray-700 font-bold mb-2">Apellido Paterno</label>
                <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
            <div class="w-1/3 ml-2">
                <label for="apellido_materno" class="block text-gray-700 font-bold mb-2">Apellido Materno</label>
                <input type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    readonly>
            </div>
        </div>

        <div id="total" class="mt-4 text-center text-xl font-bold">Total De Materias A Inscribir: 0</div>
        <div class="flex justify-center mt-4">
            <button id="deselectAll" type="button"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                Deseleccionar Todos
            </button>
        </div>
        <div class="flex justify-center mt-8">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-500 ease-in-out transform hover:-translate-y-1 hover:scale-110">
                Registrar
            </button>
        </div>
        
        <div class="mt-8 overflow-x-auto" id="tableContainer">
            @include('VistaInscripcion.tablacreate')
        </div>

    </form>

    <script>
        window.onload = function() {
            var flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.opacity = '0';
                    setTimeout(function() {
                        flashMessage.style.display = 'none';
                    }, 500);
                }, 3000);
            }
            verificarGrupoMateria();
            addCheckboxListeners();
            updateTotal();
        };

        function verificarGrupoMateria() {
            var carnet = document.getElementById('carnet_identidad').value;
            if (!carnet) return;

            fetch(`/verificar-grupo-materia/${carnet}`)
                .then(response => response.json())
                .then(data => {
                    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                    checkboxes.forEach(function(checkbox) {
                        if (data.includes(checkbox.value)) {
                            checkbox.parentElement.parentElement.style.display = 'none';
                        }
                    });
                })
                .catch(error => console.error('Error al verificar el grupo_materia:', error));
        }

        document.getElementById('carnet_identidad').addEventListener('change', function() {
            fetch(`/obtener-carnet/${this.value}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('name').value = data.name;
                    document.getElementById('nombre').value = data.nombre;
                    document.getElementById('apellido_paterno').value = data.apellido_paterno;
                    document.getElementById('apellido_materno').value = data.apellido_materno;

                    // Verificar si el estudiante está habilitado para inscribirse
                    fetch(`/verificar-matricula/${this.value}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.habilitado !== undefined) {
                                document.getElementById('habilitado').innerText = data.habilitado ?
                                    'Habilitado Para Inscribir' : 'No Habilitado Para Inscribir';
                            } else {
                                console.error('Respuesta inesperada del servidor:', data);
                            }
                        })
                        .catch(error => console.error('Error al verificar la matrícula:', error));

                    verificarGrupoMateria();
                    addCheckboxListeners();
                    updateTotal();
                })
                .catch(error => console.error('Error al obtener el carnet:', error));
        });

        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            var searchValue = document.getElementById('searchInput').value;

            axios.get('{{ route('Inscripcion.create') }}', {
                    params: {
                        search: searchValue
                    }
                })
                .then(function(response) {
                    document.getElementById('tableContainer').innerHTML = response.data;
                    document.getElementById('clearButton').style.display = 'inline-flex';

                    verificarGrupoMateria();
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
            checkboxes.forEach(function(checkbox) {
                // Primero, elimina el event listener para evitar duplicados
                checkbox.removeEventListener('change', handleCheckboxChange);

                // Luego, agrega el event listener
                checkbox.addEventListener('change', handleCheckboxChange);

                // Marca el checkbox como checked si ya estaba seleccionado
                var checkedMaterias = JSON.parse(localStorage.getItem('checkedMaterias')) || [];
                checkbox.checked = checkedMaterias.some(function(materia) {
                    return materia.value === checkbox.value;
                });
            });
        }

        // Definir la función del event listener fuera para poder referenciarla
        function handleCheckboxChange() {
            var checkedMaterias = JSON.parse(localStorage.getItem('checkedMaterias')) || [];
            var materia = {
                value: this.value
            };
            if (this.checked) {
                checkedMaterias.push(materia);
            } else {
                var index = checkedMaterias.findIndex(function(m) {
                    return m.value === materia.value;
                });
                if (index !== -1) {
                    checkedMaterias.splice(index, 1);
                }
            }
            localStorage.setItem('checkedMaterias', JSON.stringify(checkedMaterias));
            updateTotal();
        }

        function updateTotal() {
            var checkedMaterias = JSON.parse(localStorage.getItem('checkedMaterias')) || [];
            var total = checkedMaterias.length;
            document.getElementById('total').innerText = 'Total De Materias A Inscribir: ' + total;
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
