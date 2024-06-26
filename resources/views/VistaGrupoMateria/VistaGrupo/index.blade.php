@extends('Panza')
@section('Panza')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Administración De Grupos</h1>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4 justify-center items-center">
            <a href="{{ route('Grupo.index') }}" class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-yellow-500 p-4 rounded-xl shadow-md text-center hover:bg-yellow-600 hover:text-white">
                    <h3 id="ejecutados" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">{{ $totalGrupos }}</h3>
                    <i class="fas fa-users text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Total De Grupos</span>
                </div>
            </a>
            <div
                class="bg-blue-500 p-4 rounded-xl shadow-md text-center hover:bg-blue-600 transition-colors transform  duration-300 ease-in-out hover:scale-105">
                <h3 class="font-extrabold text-base sm:text-2xl lg:text-3xl text-white">Crear Nuevo Grupo</h3>
                <form action="{{ route('Grupo.store') }}" method="POST"
                    class="mt-4 flex flex-col sm:flex-row items-start sm:items-center">
                    @csrf
                    <div class="flex-grow mr-2">
                        <label for="nombre" class="block text-sm font-medium text-white mb-2">Nombre Del Nuevo
                            Grupo</label>
                        <input type="text" name="nombre" id="nombre"
                            class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                    <button type="submit"
                        class="mt-4 sm:mt-0 inline-flex justify-center py-2 px-3 border border-transparent shadow-sm text-sm sm:text-lg font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                        Crear
                    </button>
                </form>
            </div>
        </div>


        <div class="flex justify-center mt-8 space-x-4">
            <a href="{{ route('Materia.index') }}"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded shadow-md">Ir a Materias</a>
        </div>

        @if (session('success'))
            <div id="flash-message"
                class="my-4 bg-green-500 text-white p-4 rounded-md shadow-lg text-center text-lg animate-bounce">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div id="flash-message"
                class="my-4 bg-red-500 text-white p-4 rounded-md shadow-lg text-center text-lg animate-bounce">
                {{ session('error') }}
            </div>
        @endif


        <div class="mt-8 flex justify-center">
            <form id="searchForm" method="GET" action="{{ route('Grupo.index') }}" class="w-full max-w-lg">
                <div class="flex items-center border-b-2 border-teal-500 py-2">
                    <input type="text" id="searchInput" name="search" placeholder="Buscar Grupo"
                        class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <button type="submit" id="searchButton"
                        class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded">Buscar</button>
                    <button type="button" id="clearButton"
                        class="flex-shrink-0 bg-red-500 hover:bg-red-700 border-red-500 hover:border-red-700 text-sm border-4 text-white py-1 px-2 rounded ml-2"
                        style="display: none;">Eliminar filtro</button>
                </div>
            </form>
        </div>

        <div class="mt-8 overflow-x-auto" id="tableContainer">
            @include('VistaGrupoMateria.VistaGrupo.table')
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('totalGrupos').textContent = "{{ $totalGrupos }}";
        });
        window.onload = function() {
            var flashMessage = document.getElementById('flash-message');
            if (flashMessage) {
                setTimeout(function() {
                    flashMessage.style.display = 'none';
                }, 3000);
            }
        };
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var searchValue = document.getElementById('searchInput').value;

            axios.get('{{ route('Grupo.index') }}', {
                    params: {
                        search: searchValue
                    }
                })
                .then(function(response) {
                    document.getElementById('tableContainer').innerHTML = response.data;
                    document.getElementById('clearButton').style.display = 'inline-flex';
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
    </script>
@endsection
