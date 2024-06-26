@extends('Panza')
@section('Panza')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Administración De Pagos Y Transacciones</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4 items-stretch">
            <a href="{{ route('PagoServicio.index') }}" class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-blue-500 p-4 rounded-xl shadow-md text-center hover:bg-blue-600 hover:text-white">
                    <h3 id="totalComprobantes" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">
                        {{ $totalComprobantes }}</h3>
                    <i class="fas fa-book text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Total De Transacciones</span>
                </div>
            </a>
            <a href="{{ route('PagoServicio.index') }}"
                class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-yellow-500 p-4 rounded-xl shadow-md text-center hover:bg-yellow-600 hover:text-white">
                    <h3 id="ejecutados" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">
                        {{ $totalComprobantesDelDia }}</h3>
                    <i class="fas fa-users text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Total De Comprobantes Del Dia</span>
                </div>
            </a>
            <a href="{{ route('PagoServicio.index') }}"
                class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-green-500 p-4 rounded-xl shadow-md text-center hover:bg-green-600 hover:text-white">
                    <h3 id="creados" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">
                        {{ $totalServiciosSinUtilizar }}</h3>
                    <i class="fas fa-users-cog text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Servicios Sin Utilizar</span>
                </div>
            </a>
        </div>


        <div class="flex justify-center mt-8 space-x-4">
            <a href="{{ route('PagoServicio.create') }}"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded shadow-md">Pagar Servicio</a>
        </div>

        @if (session('success'))
            <div id="flash-message" class="my-4 bg-green-500 text-white p-4 rounded-md shadow-lg text-center text-lg">
                {{ session('success') }}
            </div>
        @endif
        <div class="mt-8 flex justify-center">
            <form id="searchForm" method="GET" action="{{ route('PagoServicio.index') }}" class="w-full max-w-lg">
                <div class="flex items-center border-b-2 border-teal-500 py-2">
                    <input type="text" id="searchInput" name="search" placeholder="Buscar Comprobante"
                        class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none">
                    <input type="date" id="fechaInput" name="fecha" placeholder="Fecha"
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
            @include('VistaPago.table')
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('totalComprobantes').textContent = "{{ $totalComprobantes }}";
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
            var fechaValue = document.getElementById('fechaInput').value;

            axios.get('{{ route('PagoServicio.index') }}', {
                    params: {
                        search: searchValue,
                        fecha: fechaValue
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
