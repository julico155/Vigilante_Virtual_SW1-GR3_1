@extends('Panza')
@section('Panza')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Administración del grupo: {{ $grupo->nombre }}</h1>
    @if(isset($fromShow) && $fromShow)
        <div class="flex justify-center items-center mt-4">
            <a href="{{ route('Grupo.index') }}" class="transform transition duration-300 ease-in-out hover:scale-105">
                <div class="bg-yellow-500 p-4 rounded-xl shadow-md text-center hover:bg-yellow-600 hover:text-white">
                    <h3 id="totalGrupos" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">{{ $totalGrupos }}</h3>
                    <i class="fas fa-users text-2xl sm:text-3xl lg:text-4xl"></i>
                    <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Total De Grupos</span>
                </div>
            </a>
        </div>
    @endif

    <div class="flex justify-start mt-8 space-x-4">
        <a href="{{ route('Grupo.index') }}"
            class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded shadow-md">Volver</a>
    </div>

    @if (session('success'))
    <div id="flash-message" class="my-4 bg-green-500 text-white p-4 rounded-md shadow-lg text-center text-lg animate-bounce">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div id="flash-message" class="my-4 bg-red-500 text-white p-4 rounded-md shadow-lg text-center text-lg animate-bounce">
        {{ session('error') }}
    </div>
    @endif

    <div class="mt-8 overflow-x-auto" id="tableContainer">
        @include('VistaGrupoMateria.tablalistado')
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

        axios.get('{{ route('Grupo.show', ['id' => $grupo->id]) }}', {
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
