@extends('Panza')
@section('Panza')
    <div class="container mx-auto p-6 bg-gray-100">
        <div class="flex flex-col md:flex-row bg-white p-6 rounded-lg shadow-lg">
            <!-- Profile Card -->
            <div
                class="md:w-1/3 p-6 flex flex-col items-center bg-gradient-to-r from-blue-500 to-black rounded-lg text-center text-white shadow-lg">
                <img src="{{ $user->profile_photo_path ? asset($user->profile_photo_path) : 'https://img.freepik.com/premium-vector/user-profile-icon-flat-style-member-avatar-vector-illustration-isolated-background-human-permission-sign-business-concept_157943-15752.jpg' }}"
                    alt="Avatar de {{ $user->name }}"
                    class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white shadow-md transition duration-500 transform hover:scale-110" />
                <h2 class="font-semibold text-2xl mt-4">{{ $user->name }}</h2>
                <p class="text-base">{{ $user->email }}</p>
                {{-- <a href="{{ route('Usuario.edit', $user->id) }}"
                    class="mt-4 inline-block text-blue-900 bg-white py-1 px-3 rounded shadow hover:bg-gray-200 transition">Editar
                    Perfil</a> --}}
            </div>

            <!-- Profile Details -->
            <div class="md:w-2/3 mt-6 md:mt-0 md:ml-6 flex flex-col">
                <div class="bg-white shadow-lg rounded-lg p-6 mb-6 flex-1">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Información Personal</h3>
                    <ul class="space-y-2">
                        @if ($user->carnet_identidad)
                            <li class="flex items-center">
                                <i class="fas fa-id-card mr-2 text-blue-500"></i>
                                <span><strong>Carnet de Identidad:</strong> {{ $user->carnet_identidad }}</span>
                            </li>
                        @endif
                        @if ($user->nombre || $user->apellido_paterno || $user->apellido_materno)
                            <li class="flex items-center">
                                <i class="fas fa-user mr-2 text-blue-500"></i>
                                <span><strong>Nombre:</strong> {{ $user->nombre }} {{ $user->apellido_paterno }}
                                    {{ $user->apellido_materno }}</span>
                            </li>
                        @endif
                        @if ($user->telefono)
                            <li class="flex items-center">
                                <i class="fas fa-phone mr-2 text-blue-500"></i>
                                <span><strong>Teléfono:</strong> {{ $user->telefono }}</span>
                            </li>
                        @endif
                        @if ($user->fecha_nacimiento)
                            <li class="flex items-center">
                                <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                <span><strong>Fecha de Nacimiento:</strong> {{ $user->fecha_nacimiento }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <!-- Materias Inscritas -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if (empty($materiasConGrupos))
                <div class="bg-white shadow-lg rounded-lg p-6">
                    @if($user->hasRole('Estudiante'))
                    <p class="text-gray-600">No tiene ninguna materia inscrita.</p>
                    @else
                    <p class="text-gray-600">No tiene ninguna materia asignada.</p>
                    @endif
                </div>
            @else
            @foreach ($materiasConGrupos as $infoGrupoMateria)
                <div class="redirectBtn relative bg-gradient-to-r from-blue-500 to-black shadow-xl rounded-lg overflow-hidden transform transition-transform duration-300 hover:scale-105 hover:shadow-2xl cursor-pointer" data-gp="{{ $infoGrupoMateria['gp'] }}">
                    <div class="absolute inset-0 bg-gradient-to-r from-black to-blue-500 opacity-70"></div>
                    <div class="relative p-6 z-10">
                        <h4 class="text-2xl font-semibold text-white mb-2">{{ $infoGrupoMateria['materia'] }}</h4>
                        <p class="text-lg text-white mb-2">Grupo: {{ $infoGrupoMateria['grupo'] }}</p>
                        @if($user->hasRole('Estudiante'))
                        <p class="text-lg text-white">Docente: {{ $infoGrupoMateria['docente'] }}</p>
                        @endif
                    </div>
                    <div class="absolute top-0 left-0 right-0 bottom-0 bg-gradient-to-r from-blue-500 to-black opacity-30"></div>
                </div>
            @endforeach

            @endif
        </div>


    </div>

    <script>
        document.querySelectorAll('.redirectBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                var gpId = this.getAttribute('data-gp');
                var url = "{{ route('GrupoMateria.prueba', ['id' => ':id']) }}";
                url = url.replace(':id', gpId);
                window.location.href = url;
            });
        });
        </script>



@endsection
