<x-navbar />

<div class="flex justify-center relative">
    <div class="w-full h-full bg-black/40 absolute flex justify-center items-center" id="bloqueo" style="z-index: 500;">
        <span id="motivo" class="text-red-500 font-bold text-5xl">No se detectan rostros en la pantalla</span>
    </div>
    <div class="container">
        <div class="flex gap-4 flex-wrap md:flex-nowrap">
            <div class="border p-8 mt-8 w-full mb-auto">


                <h1 class="text-4xl font-semibold text-gray-500">{{$examen->tema}}</h1>
                <h2 class="text-gray-500">{{$examen->descripcion}}</h2>

            </div>
            <div class="mt-8 border w-[500px] h-[200px] flex items-center justify-center relative overflow-hidden">
                @component('components.reconocimiento-facial', ['ejecucion_id' => $ejecucion->id])
                @endcomponent
            </div>
        </div>


        <div class="grid md:grid-cols-4 mt-8 gap-8">
            <div class="md:col-span-3 ml-auto container flex items-center">
                @php
                $x = 0;
                @endphp
                @foreach($preguntas_seleccionadas as $pregunta)

                <div id="container-{{$x}}" class="hidden w-full">
                    <div class="flex flex-wrap md:flex-nowrap gap-8">

                        <div class="rounded p-4 bg-blue-500 w-full md:w-auto">
                            <h3 class="text-white font-bold text-xl">Pregunta {{$x + 1}}</h3>
                            <span class="mt-2 text-white block">Punta como: {{$pregunta['ponderacion']}} pts.</span>
                        </div>

                        <div class="w-full">
                            <div class="bg-gray-200 rounded-xl">
                                <div class="bg-blue-600 shadow-lg rounded-xl p-6 text-white font-bold text-xl">
                                    <h1 class="uppercase">{{$pregunta['descripcion']}}</h1>
                                </div>

                                <div class="p-6 pt-5">
                                    <h2>{{$pregunta['comentario']}}</h2>
                                </div>
                            </div>

                            <div class="rounded-xl p-6 bg-gray-200 mt-8 shadow-inner shadow-gray-400">
                                @switch($pregunta['tipo_pregunta_id'])
                                @case(1)
                                <!-- VERDADERO FALSO -->
                                @foreach ($pregunta['respuestas'] as $respuesta)
                                <div class="">
                                    <input class="respuesta_{{$pregunta['id']}}" id="{{$respuesta->id}}" name="{{$pregunta['id']}}" value="{{$respuesta->id}}" type="radio"></input>
                                    <label for="">{{$respuesta->descripcion}}</label>
                                </div>
                                @endforeach
                                @break
                                <!-- SEL MULTIPLE -->
                                @case(2)
                                @foreach ($pregunta['respuestas'] as $respuesta)
                                <div class="mb-1">
                                    <input class="respuesta_{{$pregunta['id']}}
                            -translate-y-0.5" id="{{$respuesta->id}}" name="{{$pregunta['id']}}" value="{{$respuesta->id}}" type="checkbox"></input>
                                    <label for="">{{$respuesta->descripcion}}</label>
                                </div>
                                @endforeach
                                @break

                                @case(3)
                                <div class="mb-1">
                                    <textarea id="" name="{{$pregunta['id']}}" class="w-full max-h-80 respuesta_{{$pregunta['id']}}" checked id=""></textarea>
                                </div>

                                @break

                                @default

                                @endswitch
                            </div>
                        </div>
                    </div>


                    <input type="hidden" name="tipo_pregunta" id="tipo_pregunta-{{$x}}" class="form-control" value="{{$pregunta['tipo_pregunta_id']}}">
                    <input type="hidden" id="pregunta_id-{{$x}}" class="form-control" value="{{$pregunta['id']}}">



                    @if($ejecucion->navegacion == '1')
                    <div class="flex w-full justify-between  mt-12">
                        <button class="border border-blue-500 rounded-xl text-blue-500 font-bold p-4 {{$x == '0' ? 'hidden' : ''}}" onclick="previousQuestion('{{$x}}')" id="previous-{{$x}}"><i class="fa-solid fa-arrow-left"></i> Pregunta anterior</button>
                        <div class="{{$x == '0' ? 'inline' : 'hidden'}}"></div>
                        <button class="bg-blue-600 text-white p-4 font-bold rounded-xl" id="next-{{$x}}" onclick="nextQuestion('{{$x}}')" datatype="{{$pregunta['tipo_pregunta_id']}}" datax="{{$pregunta['id']}}">@if($x != count($preguntas_seleccionadas) - 1)
                            Siguiente <i class="fa-solid fa-arrow-right"></i>
                            @else
                            Terminar intento
                            @endif
                        </button>

                    </div>
                    @else

                    <div class="w-full flex justify-end mt-12">
                        <button class="bg-blue-600 text-white p-4 font-bold rounded-xl " id="next-{{$x}}" onclick="nextQuestion('{{$x}}')" datatype="{{$pregunta['tipo_pregunta_id']}}" datax="{{$pregunta['id']}}">@if($x != count($preguntas_seleccionadas) - 1)
                            Siguiente <i class="fa-solid fa-arrow-right">
                                @else
                                Terminar intento
                                @endif

                            </i></button>

                    </div>
                    @endif

                </div>
                @php
                $x++;
                @endphp
                @endforeach
            </div>
            <div class=" ml-auto w-full">
                <div class="rounded p-4 bg-gray-200">
                    <h3>Navegacion del examen</h3>
                    <div class=" flex flex-wrap gap-2 mt-2" id="navegabilidadContainer">

                    </div>
                </div>

                <div class="mt-4 border-red-500 border p-4 font-bold flex justify-between">
                    <span>Tiempo restante:</span>
                    <span id="tiempo_restante"></span>
                </div>
            </div>
        </div>
    </div>

</div>



<script>
    console.log('ts');

    let hora_final = "{{$ejecucion->hora_final}}";

    let fecha_actual = new Date();

    let partes_hora = hora_final.split(":");
    let fecha_final = new Date(fecha_actual.getFullYear(), fecha_actual.getMonth(), fecha_actual.getDate(), partes_hora[0], partes_hora[1], partes_hora[2]);

    function actualizarContador() {
        let ahora = new Date().getTime();
        let tiempo_restante = fecha_final.getTime() - ahora;

        let horas = Math.floor((tiempo_restante % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        let minutos = Math.floor((tiempo_restante % (1000 * 60 * 60)) / (1000 * 60));
        let segundos = Math.floor((tiempo_restante % (1000 * 60)) / 1000);

        document.getElementById('tiempo_restante').textContent = `${horas}h ${minutos}m ${segundos}s`;

        if (tiempo_restante < 0) {
                (intervalo);
            document.getElementById('tiempo_restante').textContent = "Tiempo finalizado";
            alert('El tiempo ha terminado');
        }
    }

    // Paso 4: Configurar un temporizador que actualice el contador cada segundo
    let intervalo = setInterval(actualizarContador, 1000);

    let count_questions = "{{$ejecucion->navegacion == '1'? '0' : $inicial}}";
    var actualContainer = document.getElementById('container-' + count_questions);
    let nextBtn = document.getElementById('next-' + count_questions);
    actualContainer.classList.remove('hidden');

    verificarNavegabilidad();

    if (count_questions >= '{{count($preguntas_seleccionadas)}}') {
        window.location.href = "{{route('Examen.enviar', $ejecucion->id )}}"
    }


    function previousQuestion(x) {
        let buttonNext = document.getElementById('next-' + x)
        let pregunta_id = buttonNext.getAttribute('datax');

        actualContainer.classList.add('hidden');

        count_questions--;

        actualContainer.classList.add('hidden');
        actualContainer = document.getElementById('container-' + count_questions);


        actualContainer.classList.remove('hidden');

        verificarNavegabilidad();

        console.log(responseData);

    }



    function nextQuestion(x) {

        let buttonNext = document.getElementById('next-' + x)
        let pregunta_id = buttonNext.getAttribute('datax');
        //console.log(pregunta_id);
        let tipoPregunta = buttonNext.getAttribute('datatype');

        //Caso de que sea de opcion abierta (3)
        let respuestasArray = [];
        if (tipoPregunta != '3') {
            const respuestasSel = document.querySelectorAll('.respuesta_' + pregunta_id + ':checked');

            respuestasSel.forEach(respuesta => {
                respuestasArray.push(respuesta.value);
            });

        } else {
            const respuestasSel = document.querySelectorAll('.respuesta_' + pregunta_id)[0].value;
            console.log(respuestasSel);
            respuestasArray.push(respuestasSel);
        }



        console.log(respuestasArray);

        actualContainer.classList.add('hidden');

        let data = {
            'respuestas_array': respuestasArray,
            'ejecucion_id': '{{$ejecucion->id}}',
            'pregunta_id': pregunta_id,
            'tipo_pregunta_id': tipoPregunta,
        };

        console.log(data);

        fetch('/examenes/respuesta/store', {
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
                    count_questions++;

                    actualContainer.classList.add('hidden');
                    actualContainer = document.getElementById('container-' + count_questions);

                    if (!actualContainer) {
                        window.location.href = "{{route('Examen.enviar', $ejecucion->id )}}"
                    } else {

                        nextBtn = document.getElementById('next-' + count_questions);
                        actualContainer.classList.remove('hidden');
                        console.log(nextBtn);

                    }
                    verificarNavegabilidad();
                } else {

                }
                console.log(responseData);
            });

    };


    function verificarNavegabilidad() {
        const data = {
            ejecucion_id: '{{$ejecucion->id}}'
        };

        fetch('/examenes/verificar-navegabilidad', {
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
                    console.log(responseData['preguntas']);
                    const navegabilidadContainer = document.getElementById('navegabilidadContainer');
                    navegabilidadContainer.innerHTML = '';
                    let cont = 1;
                    responseData['preguntas'].forEach(pregunta => {

                        const div = document.createElement('div');
                        div.className = 'rounded overflow-hidden border-2 border-blue-500';

                        const divNroPregunta = document.createElement('div');
                        divNroPregunta.className = 'px-2 py-1 bg-white text-blue-500 text-center';
                        divNroPregunta.textContent = cont;

                        const divEstado = document.createElement('div');
                        divEstado.className = 'px-4 py-1 h-4';

                        if (pregunta['hecha'] == '0') {
                            divEstado.classList.add('bg-gray-400');
                        } else {
                            divEstado.classList.add('bg-green-400');
                        }

                        div.appendChild(divNroPregunta);
                        div.appendChild(divEstado);

                        navegabilidadContainer.appendChild(div);
                        cont++;
                    });
                } else {

                }
                //console.log(responseData);
            });
    }
</script>
@include('components.footer')
