<x-navbar />

<style>
    .disabled-link {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 40;
    }

    .modal-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 50;
    }
</style>

<div class="flex justify-center py-10">
    <div class="container max-w-5xl bg-white p-8 shadow-lg rounded-lg">
        <!-- Encabezado del Examen -->
        <div class="flex items-center mb-6">
            <div class="bg-blue-600 rounded-full p-3 text-white text-4xl mr-4">
                <i class="fa-solid fa-file-lines"></i>
            </div>
            <div class="text-blue-600">
                <span class="text-md">Examen</span>
                <h1 class="text-2xl font-bold uppercase">{{$examen->tema}}</h1>
            </div>
        </div>

        <!-- Detalles del Examen -->
        <div class="flex gap-x-4 mb-6 text-sm">
            <div class="bg-gray-100 rounded-full px-4 py-2">
                <strong>Desde:</strong> {{$ejecucion->hora_inicio}}
            </div>
            <div class="bg-gray-100 rounded-full px-4 py-2">
                <strong>Hasta:</strong> {{$ejecucion->hora_final}}
            </div>
        </div>

        <!-- Descripción del Examen -->
        <div class="bg-gray-100 p-6 rounded-lg mb-6">
            <h2 class="text-lg font-semibold mb-2">Descripción</h2>
            <p class="text-gray-700">{{$examen->descripcion}}</p>
        </div>

        <!-- Información adicional -->
        <div class="bg-white shadow-inner rounded-lg">
            <div class="border-b border-gray-300 p-4">
                <strong>Fecha:</strong> {{$ejecucion->fecha}}
            </div>
            @php
                switch($ejecucion->estado_ejecucion_id){
                    case 1:
                        $text_content = 'En proceso';
                        $color = 'text-yellow-500 font-bold';
                        break;
                    case 2:
                        $text_content = 'Terminado';
                        $color = 'text-red-500 font-bold';
                        break;
                    case 3:
                        $text_content = 'Pendiente';
                        $color = '';
                        break;
                }
            @endphp

            <div class="border-b border-gray-300 p-4">
                <strong>Estado del examen:</strong> <span class="{{$color}}">{{$text_content}}</span>
            </div>

            <div class="border-b border-gray-300 p-4">
                <strong>Estado de la entrega:</strong> <span class="{{!$calificacion || !$calificacion->finalizado ? 'text-red-500' : 'text-green-500'}}">{{!$calificacion || !$calificacion->finalizado ? 'No entregada' : 'Entregada'}}</span>
            </div>

            <div class="border-b border-gray-300 p-4">
                <strong>Tiempo restante:</strong> <span>{{$restante}}</span>
            </div>

            @if($calificacion && $calificacion->finalizado == '1')
            <div class="border-b border-gray-300 p-4">
                <strong>Nota:</strong> <span>{{$calificacion->nota}} / 100 pts.</span>
            </div>
            @endif
        </div>

        <!-- Botón de Comenzar Intento -->
        <div class="mt-8 text-center">
            <button id="comenzar_btn" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded-md {{ $ejecucion->estado_ejecucion_id != 1 || ($calificacion && $calificacion->finalizado == '1') ? 'disabled-link' : '' }}"
            {{ $ejecucion->estado_ejecucion_id != 1 || ($calificacion && $calificacion->finalizado == '1') ? 'disabled' : '' }}>
                Realizar intento
            </button>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div id="confirmar_intento_modal" class="fixed z-50 inset-0 hidden overflow-auto">
    <div class="modal-overlay"></div>
    <div class="modal-container mx-auto mt-24 rounded-lg overflow-hidden shadow-lg bg-white max-w-lg">
        <div class="modal-content text-left relative">
            <div class="bg-blue-600 px-4 py-2 flex justify-between items-center">
                <h2 class="text-white font-bold uppercase text-2xl">Confirmar intento</h2>
                <button class="text-white text-xl hover:text-red-500" id="close_intento_modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="p-6">
                <h3 class="text-center mb-6">¿Estás seguro de comenzar el intento ahora?</h3>
                <div class="text-center">
                    <a href="/examenes/running/{{$ejecucion->id}}" class="bg-blue-600 hover:bg-blue-500 text-white font-bold py-2 px-6 rounded-md">Comenzar intento</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('comenzar_btn').addEventListener('click', function() {
        if (!this.classList.contains('disabled-link')) {
            document.getElementById('confirmar_intento_modal').classList.remove('hidden');
        }
    });

    document.getElementById('close_intento_modal').addEventListener('click', function() {
        document.getElementById('confirmar_intento_modal').classList.add('hidden');
    });
</script>

@include('components.footer')

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
