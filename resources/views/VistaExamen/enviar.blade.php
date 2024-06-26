<x-navbar />

<style>
    .disabled-link {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<form action="{{route('Examen.terminarIntento', $calificacion->id)}}" method="POST" class="flex justify-center h-full items-center py-10">
    @csrf
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

        <!-- Navegación de preguntas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @for ($i = 0; $i < count($preguntas_seleccionadas); $i++)
                <div class="p-4 bg-white shadow-md rounded-lg flex items-center justify-between border-t-4 {{$preguntas_seleccionadas[$i]->hecha == 1 ? 'border-green-500' : 'border-red-500'}}">
                    <span class="text-blue-500 font-bold text-xl">{{$i + 1}}</span>
                    <span class="{{$preguntas_seleccionadas[$i]->hecha == 1 ? 'text-green-500' : 'text-red-500'}}">{{$preguntas_seleccionadas[$i]->hecha == 1 ? 'Respuesta guardada' : 'Sin respuesta'}}</span>
                </div>
            @endfor
        </div>

        <!-- Botón de envío -->
        <div class="mt-8 text-center">
            <button type="submit" class="bg-blue-600 text-white py-2 px-6 rounded-md font-bold hover:bg-blue-700 transition duration-300">
                Enviar todo y terminar <i class="fa-solid fa-check ml-2"></i>
            </button>
        </div>
    </div>
</form>

@include('components.footer')

<!-- Incluye Font Awesome para los íconos -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
