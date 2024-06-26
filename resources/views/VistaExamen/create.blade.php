@extends('Panza')
@section('Panza')


<div class=" border-b pb-1 flex justify-between">
    <h1 class="text-gray-800 font-semibold uppercase text-xl">Crear Examen</h1>
    <div class="gap-x-2 fflex flex-wrap -translate-y-1">
        <button id="save" class="text-white bg-green-500 px-2 py-1 rounded-md"><i class="fa-solid fa-circle-check mr-1"></i>Guardar</button>
        <a href="{{route('Examen.index')}}" class="text-white bg-red-500 px-2 py-1 rounded-md">
            <i class="fa-solid fa-circle-xmark mr-1"></i></i>Cancelar</a>
    </div>

</div>
<div class="grid md:grid-cols-2 md:gap-x-2 mt-4 h-5/6">

    <div class="p-2 md:border-r pr-4 ">
        <div class="w-full ">
            <label for="tema" class="text-sm font-semibold block text-gray-700">Tema</label>
            <input type="text" name="tema" id="tema" class="border-x-transparent border-t-transparent 
            border-b focus:outline-none focus:border-transparent w-full ">
        </div>

        <div class="mt-4">
            <label for="descripcion" class="text-sm font-semibold block text-gray-700">Descripcion</label>
            <input type="text" name="descripcion" id="descripcion" class="w-full h-[150px] rounded">
        </div>

        <div class="mt-6 overflow-hidden">
            <div class="flex items-center gap-x-1 ml-1">
                <input type="checkbox" id="ejecucion" class="rounded-full border-2"></input> <span class="font-semibold -translate-y-[1px]">Configurar ejecucion</span>
            </div>

            <div class="grid md:grid-cols-2 gap-x-4 animate-fade-down 
            animate-duration-[400ms] animate-ease-out hidden" id="contenedor">

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
                    <button id="randomPassword" class="mt-auto justify-start">
                        <i class="fa-solid fa-dice text-2xl mb-2 text-blue-600 hover:text-blue-500"></i>
                    </button>
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
        </div>
    </div>


    <div class="p-2">
        <span class="font-semibold text-sm text-gray-700">Preguntas</span>

        <div class="mt-4" id="questions_container">

        </div>

        <div class="text-center mt-4">
            <button class="px-4 py-2 text-white bg-blue-600 rounded-xl shadow-md shadow-gray-300 hover:bg-blue-500" id="btn_agregar_pregunta">
                <i class="fa-solid fa-circle-plus "></i> Agregar pregunta
            </button>
        </div>
    </div>

</div>

<div id="crear_pregunta_modal" class="fixed z-50 inset-0 hidden overflow-auto ">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 bg-opacity-75"></div>
    <div class="modal-container mx-auto mt-8 rounded-lg overflow-hidden shadow-lg
     animate-fade-down animate-duration-300 bg-white max-w-4xl">

        <div class="modal-content text-left relative">

            <div class="bg-blue-600 px-4 py-2 flex justify-between">
                <h2 class="text-white font-bold uppercase text-2xl">Crear pregunta</h2>
                <button class="text-white text-xl hover:text-red-500" id="close_pregunta_modal"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <div class="p-4 bg-white">
                <div class="grid md:grid-cols-2">
                    <div class="md:border-r md:pr-4">

                        <div class="w-full">
                            <label for="descripcion_pregunta" class="text-sm font-semibold block text-gray-700">Descripcion</label>
                            <input type="text" name="descripcion_pregunta" id="descripcion_pregunta" class="border-x-transparent border-t-transparent 
                            border-b focus:outline-none focus:border-transparent w-full h-8">
                        </div>

                        <div class="mt-4">
                            <label for="comentario_pregunta" class="text-sm font-semibold block text-gray-700">Comentario</label>
                            <input type="text" name="comentario_pregunta" id="comentario_pregunta" class="border-x-transparent border-t-transparent
                            border-b focus:outline-none focus:border-transparent w-full h-8">
                        </div>

                        <div class="mt-4">
                            <label for="ponderacion_pregunta" class="text-sm font-semibold block text-gray-700">Ponderacion</label>
                            <input type="number" name="ponderacion_pregunta" id="ponderacion_pregunta" class="border-x-transparent border-t-transparent
                             border-b focus:outline-none focus:border-transparent w-full h-8" max="100" min="0">
                        </div>

                        <span class="font-semibold text-sm text-gray-700 mt-4 block">Tipo pregunta</span>

                        <div class=" flex gap-x-4 text-sm  text-gray-700 justify-center flex-wrap">
                            <div class="text-center">
                                <span class="block">V/F</span>
                                <input type="radio" name="tipo_pregunta" id="vf" value="1">
                            </div>

                            <div class="text-center">
                                <span class="block">Multiple</span>
                                <input type="radio" name="tipo_pregunta" id="multiple" value="2">
                            </div>

                            <div class="text-center">
                                <span class="block">Abierta</span>
                                <input type="radio" name="tipo_pregunta" id="abierta" value="3">
                            </div>
                        </div>

                    </div>

                    <div class="md:pl-4">

                        <div id="no_option_container">
                            <h2 class="text-sm font-semibold block text-gray-700">Selecciona una opcion de pregunta!</h2>
                        </div>

                        <div id="abierta_container" class="hidden">
                            <h2 class="text-sm font-semibold block text-gray-700">Respuesta abierta seleccionada!</h2>
                        </div>

                        <div class="text-center hidden" id="vf_container">
                            <h2 class="text-sm font-semibold block text-gray-700">Respuesta</h2>

                            <div class=" flex gap-x-4 text-sm  text-gray-700 justify-center flex-wrap mt-4">
                                <div class="text-center">
                                    <span class="block">Verdadero</span>
                                    <input type="radio" name="respuesta_vf" id="v">
                                </div>

                                <div class="text-center">
                                    <span class="block">Falso</span>
                                    <input type="radio" name="respuesta_vf" id="f">
                                </div>
                            </div>
                        </div>
                        <div class="text-center hidden" id="multiple_container">
                            <h2 class="text-sm font-semibold block text-gray-700 ">Respuesta</h2>
                            <span class="text-sm mb-4 block">(Seleccione las opciones correctas)</span>
                            <div class="mb-4" id="contenedor_opciones">

                            </div>
                            <button id="agregar_opcion" class="text-sm px-2 py-1 hover:bg-blue-500 
                            shadow-md shadow-gray-300 bg-blue-600 text-white rounded-xl">Agregar opcion</button>

                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <img src="{{asset('images/loading.gif')}}" id="loading_gif" class="h-10 hidden" alt="">

                    <button class="bg-blue-600 hover:bg-blue-500 py-2 px-4 
                    font-bold rounded-xl text-md text-white" id="add">
                        Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
<input type="hidden" id="grupo_materia_id" value="{{ $grupo_materia->id }}">
<script src="{{asset('js/examenes.js')}}"></script>

@endsection