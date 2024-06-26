@extends('Panza')
@section('Panza')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Administración De Usuarios</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        <div class="bg-white p-4 rounded-xl shadow-md text-center">
            <h3 id="creados" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">{{ $totalUsuarios }}</h3>
            <i class="fa-solid fa-user text-2xl sm:text-3xl lg:text-4xl"></i>
            <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Total De Usuarios</span>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md text-center">
            <h3 id="ejecutando" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">{{ $totalDocentes }}</h3>
            <i class="fa-solid fa-chalkboard-teacher text-2xl sm:text-3xl lg:text-4xl"></i>
            <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Docentes</span>
        </div>
        <div class="bg-white p-4 rounded-xl shadow-md text-center">
            <h3 id="ejecutados" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">{{ $totalEstudiantes }}</h3>
            <i class="fa-solid fa-user-graduate text-2xl sm:text-3xl lg:text-4xl"></i>
            <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Estudiantes</span>
        </div>
        @if (auth()->user()->hasRole('Administrativo Premium') || auth()->user()->hasRole('Administrativo'))
            <div class="bg-white p-4 rounded-xl shadow-md text-center">
                <h3 id="ejecutados" class="font-extrabold text-4xl sm:text-5xl lg:text-6xl">{{ $usuarios_creables }}</h3>
                <i class="fa-solid fa-user-graduate text-2xl sm:text-3xl lg:text-4xl"></i>
                <span class="mt-1 font-semibold text-lg sm:text-xl lg:text-2xl">Usuario Creables</span>
            </div>
        @endif
    </div>

    <div class="flex justify-center mt-8">
        <a href="{{ route('Usuario.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded shadow-md">Crear Usuario</a>
    </div>

    @if (session('success'))
        <div id="flash-message" class="my-4 bg-green-500 text-white p-4 rounded-md shadow-lg text-center text-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="mt-8 overflow-x-auto" id="usuariosTableContainer">
        @include('VistaUsuario.table', ['usuarios' => $usuarios])
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('creados').textContent = "{{ $totalUsuarios }}";
        document.getElementById('ejecutando').textContent = "{{ $totalDocentes }}";
        document.getElementById('ejecutados').textContent = "{{ $totalEstudiantes }}";

        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 3000);

        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let form = this;
            let url = form.action;
            let method = form.method;
            let formData = new FormData(form);

            fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('usuariosTableContainer').innerHTML = html;
                document.getElementById('clearButton').classList.remove('hidden');
            })
            .catch(error => console.log(error));
        });

        document.getElementById('clearButton').addEventListener('click', function() {
            document.getElementById('search').value = '';
            document.getElementById('rol').value = '{{ encrypt('') }}';
            this.classList.add('hidden');
            document.getElementById('searchForm').dispatchEvent(new Event('submit'));
        });
    });
</script>
@endsection
