@extends('Panza')

@section('Panza')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-extrabold text-blue-900 text-3xl mt-2 uppercase">Detalles de Grupo Materia</h1>
        <div class="mt-8">
            <h3 class="font-extrabold text-blue-900 text-3xl">Usuarios De La Materia</h3>
            @include('VistaGrupoMateria.tableshow')
        </div>
    </div>
@endsection
