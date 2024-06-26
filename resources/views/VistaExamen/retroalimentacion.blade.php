<x-navbar />

<div class="bg-gray-100 py-10">
    <div class="container mx-auto max-w-5xl">
        <!-- Encabezado del Examen -->
        <div class="border p-8 bg-white shadow-md rounded-lg mb-8">
            <h1 class="text-4xl font-semibold text-gray-800 mb-4">{{$examen->tema}}</h1>
            <p class="text-lg text-gray-600 mb-6">{{$examen->descripcion}}</p>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Información del Estudiante</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-600 font-medium">Nombre Completo</label>
                    <p class="text-gray-800">{{$user->nombre}} {{$user->apellido_paterno}} {{$user->apellido_materno}}</p>
                </div>
                <div>
                    <label class="block text-gray-600 font-medium">Carnet de Identidad</label>
                    <p class="text-gray-800">{{$user->carnet_identidad}}</p>
                </div>
                <div>
                    <label class="block text-gray-600 font-medium">Correo Electrónico</label>
                    <p class="text-gray-800">{{$user->email}}</p>
                </div>
                <div>
                    <label class="block text-gray-600 font-medium">Teléfono</label>
                    <p class="text-gray-800">{{$user->telefono}}</p>
                </div>
            </div>
        </div>

        <!-- Preguntas y Respuestas -->
        <div>
            @php 
            $x = 1;
            $nota_total = 0;
            @endphp
            @foreach ($preguntas_respuestas as $pregunta_respuesta)
                @php
                    $puntua = 0;
                    if($pregunta_respuesta['pregunta']['tipo_pregunta_id'] != '3'){
                        $puntua = $pregunta_respuesta['pregunta']['nota'];
                        $nota_total += $puntua;
                    } else {
                        if($pregunta_respuesta['respuestas'][0]['puntaje']){
                            $puntua = $pregunta_respuesta['respuestas'][0]['puntaje'];
                            $nota_total += $puntua;
                        } else {
                            $puntua = 'n/a';
                        }
                    }
                @endphp

                <div class="border p-6 mb-6 bg-white shadow-md rounded-lg">
                    <div class="flex flex-wrap md:flex-nowrap gap-8">
                        <div class="rounded p-4 bg-blue-600 w-full md:w-1/4 text-center">
                            <h3 class="text-white font-bold text-xl mb-2">Pregunta {{$x}}</h3>
                            <span class="block text-white">Puntúa como: {{$puntua != 'n/a' ? $puntua : '0'}}/{{$pregunta_respuesta['pregunta']['ponderacion']}} pts.</span>
                            @if ($puntua == 'n/a')
                                <span class="font-bold text-white mt-2 block">No revisado</span>
                            @endif
                        </div>
                        <div class="w-full">
                            <div class="bg-gray-100 rounded-xl overflow-hidden">
                                <div class="bg-blue-700 shadow-lg rounded-t-xl p-6 text-white font-bold text-xl">
                                    <h1 class="uppercase">{{$pregunta_respuesta['pregunta']['descripcion']}}</h1>
                                    <h2 class="font-medium text-sm mt-2">{{$pregunta_respuesta['pregunta']['comentario']}}</h2>
                                </div>
                                <div class="p-6">
                                    @if ($pregunta_respuesta['pregunta']['tipo_pregunta_id'] != '3')
                                        @foreach ($pregunta_respuesta['respuestas'] as $respuesta)
                                            <h4 class="flex items-center mb-2">{{$respuesta['descripcion']}} 
                                                @if ($respuesta['es_correcta'] == '1')
                                                    <i class="fa-solid fa-check text-green-500 ml-2"></i>
                                                @elseif ($respuesta['es_correcta'] == '0' && $respuesta['respondida'] == '1')
                                                    <i class="fa-solid fa-x text-red-500 ml-2"></i>
                                                @endif
                                            </h4>
                                        @endforeach
                                    @else 
                                        <textarea name="" id="" disabled class="w-full h-auto text-gray-500 bg-gray-200 rounded-md p-2">{{$pregunta_respuesta['respuestas'][0]['contenido']}}</textarea>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @php $x++; @endphp
            @endforeach

            <div class="border p-6 bg-white shadow-md rounded-lg mt-8 text-center">
                <h4 class="text-2xl font-bold">Nota final: {{$nota_total}} pts.</h4>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
<!-- Incluye Font Awesome para los íconos -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
