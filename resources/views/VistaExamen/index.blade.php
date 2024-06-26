@extends('Panza')
@section('Panza')

<h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Administracion de examenes</h1>

<div class="rounded-xl bg-gray-200 p-4 mt-4 grid md:grid-cols-3 mg:gap-x-2 shadow-md shadow-gray-400 text-gray-700">
    <div class="md:border-r-2 border-gray-700 p-2 text-center">
        <h3 id="creados" class="font-extrabold text-6xl">0</h3>
        <i class="fa-solid fa-pen text-3xl"></i>
        <span class="mt-1 font-semibold text-2xl">Creados</span>
    </div>
    <div class="md:border-r-2 border-gray-700 p-2 text-center">
        <h3 id="ejecutando" class="font-extrabold text-6xl">0</h3>
        <i class="fa-solid fa-rocket text-3xl"></i>
        <span class="mt-1 ml-1 font-semibold text-2xl">En ejecucion</span>
    </div>
    <div class=" p-2 text-center">
        <h3 id="ejecutados" class="font-extrabold text-6xl">0</h3>
        <i class="fa-solid fa-eject text-3xl"></i>
        <span class="mt-1 ml-1 font-semibold text-2xl">Ejecutados</span>
    </div>

</div>

<div class="flex justify-center">
    <div class="container">
        <div class="w-full flex mt-8">
            <a href="{{route('Examen.create', 1)}}" class="ml-auto rounded-xl bg-blue-500 text-white p-3 font-bold shadow-md shadow-gray-400">Crear examen</a>
        </div>

        <div class="flex">
            <div class="mt-4 p-2 px-6 font-semibold text-gray-600 text-lg bg-gray-100">
                <span>Mis examenes</span>
            </div>
            <div class="overflow-x-auto">
                @include('VistaExamen._resultadoExamenes')
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const ejecutando = document.getElementById('ejecutando');
        const creados = document.getElementById('creados');
        const ejecutados = document.getElementById('ejecutados');

        //Es normal que aparezca error de sintaxis, pero funca
        const data = {
            'ejecutando': @json($ejecutando -> total),
            'creados': @json($creados),
            'ejecutados': @json($ejecutados),
        }

        ejecutados.textContent = data['ejecutados'];
        ejecutando.textContent = data['ejecutando'];
        creados.textContent = data['creados'];
    });
</script>

@endsection