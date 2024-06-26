@extends('Panza')
@section('Panza')

<h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Examenes Pendientes</h1>

<div class="relative flex flex-col mt-6 text-gray-700 bg-white shadow-md bg-clip-border rounded-xl w-96">
    <div class="p-6">
        <h5 id="tituloexamen" class="block mb-2 font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
            Nombre del examen
        </h5>
        <p id="descripcionexamen" class="block font-sans text-base antialiased font-light leading-relaxed text-inherit">
            Descripcion...
        </p>
        <p id="fechaexamen" class="block font-sans text-base antialiased font-light leading-relaxed text-inherit">
            fecha...
        </p>
        <p id="inicioexamen" class="block font-sans text-base antialiased font-light leading-relaxed text-inherit">
            Inicio:
        </p>
        <p id="finexamen" class="block font-sans text-base antialiased font-light leading-relaxed text-inherit">
            Fin:
        </p>
    </div>
    <div class="p-6 pt-0">
        <a href="">
            <button
                class="inline-block py-2 px-6 bg-blue-500 hover:bg-blue-600 text-white font-sans font-bold rounded-full shadow-md transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Iniciar Examen
            </button>
        </a>
    </div>
</div>

@endsection