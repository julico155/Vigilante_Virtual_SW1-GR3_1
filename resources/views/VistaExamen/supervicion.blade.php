@extends('Panza')
@section('Panza')

<div class="h-full w-full flex gap-4 flex-wrap">
    <div class="max-w-lg w-full h-full p-4 border">
        <h2 class="text-lg font-semibold text-gray-700 pb-2 border-b">Lista de alumnos</h2>

        <div class="*:rounded-xl *:border-b-2 *:border-gray-100 *:shadow-md *:w-full *:px-2 *:py-1 *:mt-2 *:flex *:justify-between" id="estudiantesContainer">

        </div>
    </div>

    <div class="p-4">
        <div id="anomaliasContainer">

        </div>
    </div>
</div>

<script>
    const estudiantesContainer = document.getElementById('estudiantesContainer');

    if(){
        setInterval(getEstudiantes, 3000);
    }

    function getEstudiantes() {
        let data = {
            'ejecucion_id': '{{$ejecucion->id}}'
        };
        fetch('/examenes/get-estudiantes', {
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
                    console.log(responseData);
                    estudiantesContainer.innerHTML = '';

                    responseData['data'].forEach(calificacion => {


                        const buttonUsuario = document.createElement('button');
                        buttonUsuario.textContent = calificacion['usuario']['name'];
                        buttonUsuario.onclick = function() {
                            getAnomalias(calificacion['usuario']['id']);
                        };


                        if (calificacion['anomalias'].length > 0) {
                            const a = document.createElement('a');
                            a.className = "fa-solid fa-circle-exclamation text-red-500";
                            buttonUsuario.appendChild(a);
                        }

                        estudiantesContainer.appendChild(buttonUsuario);


                    });
                }
            });
    }

    const anomaliasContainer = document.getElementById('anomaliasContainer');

    function getAnomalias(user_id) {
        let data = {
            'user_id': user_id,
            'ejecucion_id': '{{$ejecucion->id}}'
        };
        fetch('/examenes/get-anomalias', {
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
                    console.log(responseData['data']);
                    anomaliasContainer.innerHTML = '';
                    responseData['data'].forEach(anomaila => {
                        let img = document.createElement('img');
                        img.src = '/storage/' + anomaila['url_imagen'] ;

                        anomaliasContainer.appendChild(img);
                    });
                }
            });
    }
</script>
@endsection