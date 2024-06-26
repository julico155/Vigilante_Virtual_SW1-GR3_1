@extends('Panza')
@section('Panza')

<main class="w-full max-w-4xl mx-auto px-4 py-8 md:px-6 md:py-12">
    <h1 class="text-3xl font-bold mb-4">Materia: {{ $materia->nombre }} - Grupo: {{ $grupo->nombre }}</h1>
    <div>
        <h2 class="text-xl font-semibold mb-2">Detalles de la materia</h2>
        <div class="space-y-2">
            <p>
                <span class="font-medium">Profesor:</span> {{ $docente->name }}
            </p>
        </div>
    </div>
    <div class="mt-6">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="#" id="tabExamenes" class="border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Exámenes</a>
                <a href="#" id="tabEjecuciones" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Ejecuciones</a>
                <a href="#" id="tabEstudiantes" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Estudiantes Inscritos</a>
            </nav>
        </div>
        <div id="contentExamenes" class="mt-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-semibold">Exámenes</h2>
                @if($user->hasRole('Docente'))
                <a href="{{ route('Examen.create', ['id' => $gp->id]) }}" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Crear Examen</a>
                @endif
            </div>
            <div class="border rounded-lg overflow-hidden">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100 ">
                        <tr clas="*:text-center">
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Examen</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="*:text-center">
                        @include('VistaExamen._resultadoExamenes')
                    </tbody>
                </table>
            </div>
        </div>
        <div id="contenedorEjecuciones" class="mt-4">
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-xl font-semibold">Ejecuciones</h2>
            </div>
            <div class="border rounded-lg overflow-hidden">
                <table class="w-full table-auto">
                    <thead class="bg-gray-100 ">
                        <tr class="*:text-center">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Examen</th>
                            <th class="px-4 py-2 text-left">Estado</th>
                            <th class="px-4 py-2 text-left">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="*:text-center">
                        @include('VistaExamen._resultadoEjecuciones')
                    </tbody>
                </table>
            </div>
        </div>
        <div id="contentEstudiantes" class="mt-4 hidden">
            <h2 class="text-xl font-semibold mb-2">Estudiantes Inscritos</h2>
            <div class="border rounded-lg overflow-hidden">
                <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden mt-4">
                    <thead class="bg-gradient-to-r from-blue-700 to-black text-white uppercase text-sm leading-normal">
                        <tr>
                            <th class="py-3 px-6 text-left">Usuario</th>
                            <th class="py-3 px-6 text-left">Nombre</th>
                            <th class="py-3 px-6 text-center">Rol</th>
                        </tr>
                    </thead>
                    <tbody class="text-black text-sm font-light">
                        @foreach ($usuarios as $usuario)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-200 ease-in-out">
                            <td class="py-3 px-6 text-left">
                                <a href="{{ route('Usuario.show', $usuario->id) }}" class="flex items-center text-blue-600 hover:text-blue-800">
                                    <div class="mr-4 flex justify-center items-center w-12 h-12 rounded-full border-2 border-blue-500 shadow-lg bg-blue-900 text-white">
                                        @if ($usuario->profile_photo_path)
                                        <img class="w-12 h-12 rounded-full" src="{{ asset('images/user/' . basename($usuario->profile_photo_path)) }}" alt="Profile Photo">
                                        @else
                                        <span class="text-xl">{{ strtoupper(substr($usuario->name, 0, 1)) }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <span class="font-semibold text-lg">{{ $usuario->name }}</span>
                                        <p class="text-gray-500 text-xs">{{ $usuario->email }}</p>
                                    </div>
                                </a>
                            </td>
                            <td class="py-3 px-6 text-left">
                                <a href="{{ route('Usuario.show', $usuario->id) }}" class="font-medium text-blue-600 hover:text-blue-800">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</a>
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex items-center justify-center">
                                    @if ($usuario->roles->isNotEmpty())
                                    @foreach ($usuario->roles as $rol)
                                    <span class="bg-blue-300 text-black-700 py-1 px-3 rounded-full text-xs mr-2">{{ $rol->name }}</span>
                                    @endforeach
                                    @else
                                    <span class="bg-yellow-200 text-yellow-700 py-1 px-3 rounded-full text-xs">Por designar</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

<div id="ejecutarModal" class=" fixed hidden z-50 inset-0 overflow-auto ">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 bg-opacity-75"></div>
    <div class="modal-container mx-auto mt-8 rounded-lg overflow-hidden shadow-lg bg-white animate-fade-down animate-duration-300 max-w-4xl">
        <div class="modal-content text-left relative">
            <div class="bg-blue-600 p-4 shadow-inner text-white flex justify-between">
                <span class="text-white text-2xl font-bold uppercase">Programar ejecucion</span>
                <button id="closeModalCancel" class="text-red-500 text-xl" type="button" onclick="closeEjecutarModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="bg-white p-4 ">
                <div class="grid md:grid-cols-2 gap-x-4 mb-4">

                    <input type="hidden" name="" id="examen_id">

                    <div class="mt-4">
                        <label for="fecha" class="text-sm font-semibold block text-gray-700 translate-x-2">Fecha</label>
                        <input type="date" name="fecha" id="fecha" class="rounded-xl w-full">
                    </div>

                    <div></div>

                    <div class="mt-4">
                        <label for="hora_inicio" class="text-sm font-semibold block text-gray-700 translate-x-2">Hora inicio</label>
                        <input type="time" name="hora_inicio" id="hora_inicio" class="rounded-xl w-full">
                    </div>

                    <div class="mt-4">
                        <label for="hora_final" class="text-sm font-semibold block text-gray-700 translate-x-2">Hora final</label>
                        <input type="time" name="hora_final" id="hora_final" class="rounded-xl w-full">
                    </div>

                    <div class="mt-4">
                        <label for="ponderacion" class="text-sm font-semibold block text-gray-700 translate-x-2">Ponderacion</label>
                        <input type="number" name="ponderacion" id="ponderacion" class="rounded-xl w-full" min="0" max="100">
                    </div>

                    <div class="mt-4">
                        <label for="nro_preguntas" class="text-sm font-semibold block text-gray-700 translate-x-2">Cantidad de preguntas</label>
                        <input type="number" name="nro_preguntas" id="nro_preguntas" class="rounded-xl w-full" min="0" max="100">
                    </div>

                    <div class="mt-4">
                        <label for="contrasena" class="text-sm font-semibold block text-gray-700 translate-x-2">Contraseña</label>
                        <input type="text" name="contrasena" id="contrasena" class="rounded-xl w-full">
                    </div>


                    <div class="flex mt-4">
                        
                    </div>


                    <div class="mt-4">
                        <input type="checkbox" name="navegacion" id="navegacion" class="rounded">
                        <label for="navegacion">Permitir navegacion?</label>
                    </div>
                    <div class="mt-4">
                        <input type="checkbox" name="retroalimentacion" id="retroalimentacion" class="rounded">
                        <label for="retroalimentacion">Permitir retroalimentacion?</label>
                    </div>

                </div>

                <button id="save" class="rounded bg-blue-600 py-1 px-2 text-white">Guardar</button>

            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('tabExamenes').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('contentExamenes').classList.remove('hidden');
        document.getElementById('contentEstudiantes').classList.add('hidden');
        document.getElementById('contenedorEjecuciones').classList.add('hidden');
        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabEstudiantes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabEstudiantes').classList.add('border-transparent', 'text-gray-500');

        document.getElementById('tabEjecuciones').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabEjecuciones').classList.add('border-transparent', 'text-gray-500');
    });

    document.getElementById('tabEstudiantes').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('contentEstudiantes').classList.remove('hidden');
        document.getElementById('contentExamenes').classList.add('hidden');

        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabExamenes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabExamenes').classList.add('border-transparent', 'text-gray-500');

        document.getElementById('contenedorEjecuciones').classList.add('hidden');
        document.getElementById('tabEjecuciones').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabEjecuciones').classList.add('border-transparent', 'text-gray-500');
    });

    document.getElementById('tabEjecuciones').addEventListener('click', function(event) {
        event.preventDefault();

        document.getElementById('contentExamenes').classList.add('hidden');
        document.getElementById('contentEstudiantes').classList.add('hidden');
        this.classList.add('border-blue-500', 'text-blue-600');
        this.classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tabExamenes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabExamenes').classList.add('border-transparent', 'text-gray-500');

        document.getElementById('contenedorEjecuciones').classList.remove('hidden');

        document.getElementById('tabEstudiantes').classList.remove('border-blue-500', 'text-blue-600');
        document.getElementById('tabEstudiantes').classList.add('border-transparent', 'text-gray-500');

    });

    // Mostrar inicialmente la tabla de estudiantes
    document.getElementById('tabEstudiantes').click();

    const ejecutarModal = document.getElementById('ejecutarModal');
    const input_examen_id = document.getElementById('examen_id');

    function showModal(examen_id){
        ejecutarModal.classList.remove('hidden');
        input_examen_id.value = examen_id;
    }

    function closeEjecutarModal(){
        ejecutarModal.classList.add('hidden');
        input_examen_id.value = '';
    }


    const save = document.getElementById('save');

    const hora_inicio = document.getElementById('hora_inicio');
    const hora_final = document.getElementById('hora_final');
    const fecha = document.getElementById('fecha');
    const nro_preguntas = document.getElementById('nro_preguntas');

    const fechaActual = new Date();
    const fechaString = fechaActual.toISOString().split('T')[0]; 
    const horaInicioString = '12:00';
    const horaFinalString = '13:00';
    const navegacion = document.getElementById('navegacion');
    const retroalimentacion = document.getElementById('retroalimentacion');

    
    fecha.value = fechaString;
    hora_inicio.value = horaInicioString;
    hora_final.value = horaFinalString;
    ponderacion.value = 40;
    nro_preguntas.value = 1;


    save.addEventListener('click', () => {

        const grupo_materia_id = '{{$gp->id}}';

        var data = {
            'examen_id':        input_examen_id.value,
            'grupo_materia_id': grupo_materia_id,
            'fecha':            fecha.value,
            'hora_inicio':      hora_inicio.value,
            'hora_final':       hora_final.value,
            'ponderacion':      ponderacion.value,
            'contrasena':       contrasena.value,
            'nro_preguntas':    nro_preguntas.value,
            'navegacion':       navegacion.value,
            'retroalimentacion':retroalimentacion.value,
        }
        console.log(data);
        fetch('/examenes/ejecucion/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error al enviar los datos');
                }
                return response.json();
            })
            .then(responseData => {
                if (responseData['msg'] == 'ok') {
                    window.location.href = '/grupo-materia/'+grupo_materia_id+'/prueba';
                }else{
                    alert('Numero de preguntas invalido');
                }
                console.log(responseData);
            });
    });
</script>

@endsection