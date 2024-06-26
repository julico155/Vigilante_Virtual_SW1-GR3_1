<x-navbar />

<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <!-- Encabezado con datos del estudiante -->
        <div class="px-6 py-6 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <h2 class="text-3xl font-bold text-center mb-6">Reporte de Calificaciones</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div>
                    <dt class="text-lg font-semibold">Nombre Completo</dt>
                    <dd class="mt-1 text-lg">{{ $usuario->nombre }} {{ $usuario->apellido_paterno }} {{ $usuario->apellido_materno }}</dd>
                </div>
                <div>
                    <dt class="text-lg font-semibold">Carnet de Identidad</dt>
                    <dd class="mt-1 text-lg">{{ $usuario->carnet_identidad }}</dd>
                </div>
                <div>
                    <dt class="text-lg font-semibold">Correo Electrónico</dt>
                    <dd class="mt-1 text-lg">{{ $usuario->email }}</dd>
                </div>
                <div>
                    <dt class="text-lg font-semibold">Teléfono</dt>
                    <dd class="mt-1 text-lg">{{ $usuario->telefono }}</dd>
                </div>
            </div>
        </div>
        
        <!-- Tabla de calificaciones -->
        <div class="border-t border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Examen</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Fecha y Hora</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Materia</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Grupo</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500 uppercase tracking-wider">Calificación</th>
                        <th scope="col" class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @if($calificaciones->isEmpty())
                        <tr>
                            <td colspan="7" class="py-6 px-4 text-sm text-gray-600 text-center">
                                <svg class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m0-4h.01M12 14h.01M5 13h.01M19 13h.01M6 10h.01M18 10h.01M7 7h.01M17 7h.01M4 4h16v16H4z" />
                                </svg>
                                <p>No hay calificaciones disponibles</p>
                            </td>
                        </tr>
                    @else
                        @foreach ($calificaciones as $calificacion)
                            <tr class="hover:bg-gray-50">
                                <td class="py-4 px-6 text-sm text-gray-800">{{ $calificacion->ejecucion->examen->tema ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-sm text-gray-800">{{ \Carbon\Carbon::parse($calificacion->ejecucion->fecha)->locale('es_BO')->isoFormat('dddd, D [de] MMMM [de] YYYY, h:mm a') }}</td>
                                <td class="py-4 px-6 text-sm text-gray-800">{{ $calificacion->ejecucion->examen->grupoMateria->materia->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-sm text-gray-800">{{ $calificacion->ejecucion->examen->grupoMateria->grupo->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-sm text-gray-800">{{ $calificacion->ejecucion->examen->grupoMateria->userDocente->nombre ?? 'N/A' }}</td>
                                <td class="py-4 px-6 text-sm text-gray-800">{{ $calificacion->nota }}</td>
                                <td class="py-4 px-6 text-sm text-blue-600 hover:text-blue-900">
                                  <a href="{{ route('Examen.verIntento', ['calificacion' => $calificacion]) }}" class="flex items-center">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12.293 9.293a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L12 10.414l-6.293 6.293a1 1 0 01-1.414-1.414l6-6a1 1 0 011.414 0z"/>
                                      </svg>
                                      Ver
                                  </a>
                              </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('components.footer')
