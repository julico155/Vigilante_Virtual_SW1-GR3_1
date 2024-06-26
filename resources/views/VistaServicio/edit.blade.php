@extends('Panza')
@section('Panza')

<form action="{{ route('Servicio.update', $servicio->id) }}" method="POST" class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" id="updateForm">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre</label>
        <input type="text" name="nombre" id="nombre" placeholder="Nombre" value="{{ $servicio->nombre }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" {{ $servicio->nombre == 'Matricula' ? 'readonly' : '' }}>
    </div>
    <div class="mb-4">
        <label for="descripcion" class="block text-gray-700 font-bold mb-2">Descripción</label>
        <textarea name="descripcion" id="descripcion" placeholder="Descripción" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">{{ $servicio->descripcion }}</textarea>
    </div>
    <div class="mb-4">
        <label for="fecha" class="block text-gray-700 font-bold mb-2">Fecha</label>
        <input type="date" name="fecha" id="fecha" placeholder="Fecha" value="{{ $servicio->fecha }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" readonly>
    </div>
    <div class="mb-4">
        <label for="precio" class="block text-gray-700 font-bold mb-2">Precio</label>
        <input type="text" name="precio" id="precio" placeholder="Precio" value="{{ $servicio->precio }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="flex items-center justify-between">
        <button type="submit" id="updateButton" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar</button>
    </div>
</form>


@endsection
