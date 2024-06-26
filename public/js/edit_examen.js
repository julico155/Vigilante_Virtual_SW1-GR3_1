document.addEventListener('DOMContentLoaded', () => {

    const contenedor = document.getElementById('contenedor');
    const ejecucion = document.getElementById('ejecucion');

    ejecucion.addEventListener('change', () => {
        contenedor.classList.toggle('hidden');
    });

    const randomPassword = document.getElementById('randomPassword');
    const contrasena = document.getElementById('contrasena');
    randomPassword.addEventListener('click', () => {
        let password = '';
        for (let i = 0; i < 5; i++) {
            password += Math.floor(Math.random() * 10);
        }
        contrasena.value = password;
    });


    const ponderacion = document.getElementById('ponderacion');
    ponderacion.addEventListener('input', (event) => {
        if (event.target.value > 100) {
            event.target.value = 100;
        }
    });

    const crear_pregunta_modal = document.getElementById('crear_pregunta_modal');
    const btn_agregar_pregunta = document.getElementById('btn_agregar_pregunta');
    const close_pregunta_modal = document.getElementById('close_pregunta_modal');

    btn_agregar_pregunta.addEventListener('click', () => {
        crear_pregunta_modal.classList.remove('hidden');
    });

    close_pregunta_modal.addEventListener('click', () => {
        crear_pregunta_modal.classList.add('hidden');
    });

    const vfRadio = document.getElementById('vf');
    const multipleRadio = document.getElementById('multiple');
    const abiertaRadio = document.getElementById('abierta');

    const vf_container = document.getElementById('vf_container');
    const no_option_container = document.getElementById('no_option_container');
    const multiple_container = document.getElementById('multiple_container');
    const abierta_container = document.getElementById('abierta_container');

    var flag = 'n';


    vfRadio.addEventListener('change', function () {
        vf_container.classList.remove('hidden');
        no_option_container.classList.add('hidden');
        multiple_container.classList.add('hidden');
        abierta_container.classList.add('hidden');
        flag = 'vf';

    });

    multipleRadio.addEventListener('change', function () {
        vf_container.classList.add('hidden');
        no_option_container.classList.add('hidden');
        multiple_container.classList.remove('hidden');
        abierta_container.classList.add('hidden');
        flag = 'ml';

    });

    abiertaRadio.addEventListener('change', function () {
        vf_container.classList.add('hidden');
        no_option_container.classList.add('hidden');
        multiple_container.classList.add('hidden');
        abierta_container.classList.remove('hidden');
        flag = 'a';
    });

    const agregar_opcion = document.getElementById('agregar_opcion');
    const contenedor_opciones = document.getElementById('contenedor_opciones');
    var contador_opciones = 0;

    agregar_opcion.addEventListener('click', () => {

        contador_opciones++;
        var div = document.createElement('div');
        div.classList.add('flex', 'flex-wrap', 'gap-x-2', 'p-2',
            'justify-center', 'items-center', 'bg-blue-100', 'rounded-xl',
            'mb-2');
        div.id = "opcion" + contador_opciones;

        var check = document.createElement('input');
        check.type = 'checkbox';
        check.id = 'check' + contador_opciones;
        check.classList.add('bg-blue-100', 'border-2', 'rounded-full',
            'mr-2');

        var text = document.createElement('input');
        text.type = 'text';
        text.classList.add('border-x-transparent', 'border-t-transparent',
            'border-b-2', 'focus:outline-none', 'focus:border-transparent', 'h-8',
            'bg-blue-100', 'border-gray-400');

        text.id = 'text' + contador_opciones;

        var button = document.createElement('button');
        button.className = 'text-gray-300 hover:text-red-500 ml-2 text-xl';
        button.innerHTML = '<i class="fa-solid fa-trash"></i>';

        button.onclick = function () {
            deleteOption(div.id);
        };


        div.appendChild(check);
        div.appendChild(text);
        div.appendChild(button);

        contenedor_opciones.appendChild(div);
    });


    function deleteOption(id) {
        const div = document.getElementById(id);
        contenedor_opciones.removeChild(div)
    }

    var preguntas = [];

    const add = document.getElementById('add');
    const loading_gif = document.getElementById('loading_gif');

    const descripcion_pregunta = document.getElementById('descripcion_pregunta');
    const comentario_pregunta = document.getElementById('comentario_pregunta');
    const ponderacion_pregunta = document.getElementById('ponderacion_pregunta');

    var contador_preguntas = 0;

    add.addEventListener('click', () => {
        loading_gif.classList.remove('hidden');

        add.setAttribute('disabled', true);
        add.classList.remove('bg-blue-600', 'text-white');
        add.classList.add('bg-blue-700', 'text-gray-300');

        var respuestas = [];
        var tp = 0;
        switch (flag) {
            case 'vf':

                var respuesta = {
                    'descripcion': 'verdadero',
                    'es_correcta': document.getElementById('v').checked,
                };
                respuestas.push(respuesta);
                respuesta = {
                    'descripcion': 'falso',
                    'es_correcta': document.getElementById('f').checked,
                };
                respuestas.push(respuesta);
                tp = 1;

                break;
            case 'ml':
                var opciones = contenedor_opciones.querySelectorAll('div');
                opciones.forEach(function (opcion) {

                    respuesta = {
                        'descripcion': opcion.querySelector('input[type="text"]').value,
                        'es_correcta': opcion.querySelector('input[type="checkbox"]').checked
                    }
                    respuestas.push(respuesta);
                });
                tp = 2;

                break;
            case 'a':
                tp = 3;

                break;
        }

        contador_preguntas++;

        var pregunta = {
            'id': contador_preguntas,
            'descripcion_pregunta': descripcion_pregunta.value,
            'comentario_pregunta': comentario_pregunta.value,
            'ponderacion_pregunta': ponderacion_pregunta.value,
            'tipo_pregunta': tp,
            'respuestas': respuestas
        }

        preguntas.push(pregunta);

        descripcion_pregunta.value = '';
        comentario_pregunta.value = '';
        ponderacion_pregunta.value = '';

        contenedor_opciones.innerHTML = '';

        setTimeout(() => {

            add.removeAttribute('disabled');
            add.classList.add('bg-blue-600', 'text-white');
            add.classList.remove('bg-blue-700', 'text-gray-300');

            loading_gif.classList.add('hidden');
            crear_pregunta_modal.classList.add('hidden');
        }, 300);


        actualizarContenedorPreguntas();
    });

    const questions_container = document.getElementById('questions_container');

    function actualizarContenedorPreguntas() {

        questions_container.innerHTML = '';

        preguntas.forEach(function (pregunta) {

            var div = document.createElement('div');
            div.id = pregunta['id'];
            div.classList.add('p-4', 'bg-blue-600', 'rounded-xl', 'w-full', 'flex', 'justify-between', 'items-center', 'mb-2');

            var qc_container = document.createElement('div');

            var q = document.createElement('h3');
            q.classList.add('text-white', 'font-bold', 'text-xl');
            q.textContent = pregunta['descripcion_pregunta'];

            var c = document.createElement('h4');
            c.classList.add('text-white', 'font-semibold', 'text-lg');
            var comentario = pregunta['comentario_pregunta'];
            if (comentario.length > 40) {
                comentario = comentario.substring(0, 40) + '...';
            }
            c.textContent = comentario;

            qc_container.appendChild(q);
            qc_container.appendChild(c);

            div.appendChild(qc_container);

            var delete_button = document.createElement('button');
            delete_button.type = 'button';
            delete_button.className = 'text-gray-300 hover:text-red-500 ml-2 text-xl';
            delete_button.innerHTML = '<i class="fa-solid fa-trash"></i>';

            delete_button.onclick = function () {
                deleteQuestion(pregunta['id']);
            }

            div.appendChild(delete_button);

            questions_container.appendChild(div);
        });

        console.log(preguntas);
    }

    function deleteQuestion(id) {
        var question = questions_container.querySelector('div[id="' + id + '"]');
        questions_container.removeChild(question);

        preguntas = preguntas.filter(function (pregunta) {
            return pregunta['id'] !== id;
        });

        actualizarContenedorPreguntas();
    }

    const save = document.getElementById('save');

    const hora_inicio = document.getElementById('hora_inicio');
    const hora_final = document.getElementById('hora_final');
    const fecha = document.getElementById('fecha');
    const tema = document.getElementById('tema');
    const descripcion = document.getElementById('descripcion');
    const nro_preguntas = document.getElementById('nro_preguntas');

    const fechaActual = new Date();
    const fechaString = fechaActual.toISOString().split('T')[0];
    const horaInicioString = '12:00';
    const horaFinalString = '13:00';
    const csrfToken = document.getElementById('csrf_token').value;
    const navegacion = document.getElementById('navegacion');
    const retroalimentacion = document.getElementById('retroalimentacion');


    fecha.value = fechaString;
    hora_inicio.value = horaInicioString;
    hora_final.value = horaFinalString;
    ponderacion.value = 40;
    nro_preguntas.value = 1;


    save.addEventListener('click', () => {

        if(preguntas.length < nro_preguntas.value){
            alert('Cantidad de preguntas invalida');
            return;
        }

        const grupo_materia_id = document.getElementById('grupo_materia_id').value;

        var data = {
            'grupo_materia_id': grupo_materia_id,
            'preguntas':        preguntas,
            'tema':             tema.value,
            'descripcion':      descripcion.value,
            'ejecucion':        ejecucion.checked,
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
        fetch('/examenes//{id}/update', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
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
                }
                console.log(responseData);
            });
    });
});
