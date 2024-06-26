@extends('Panza')
@section('Panza')

@if (session('error'))
<div id="flash-message" class="my-4 bg-red-500 text-white p-4 rounded-md shadow-lg text-center text-lg animate-bounce">
    {{ session('error') }}
</div>
@endif

<form action="{{ route('Grupo.update', $grupo->id) }}" method="POST" class="max-w-md mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    @csrf
    @method('PUT')
    <div class="mb-4">
        <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre del Grupo</label>
        <input type="text" name="nombre" id="nombre" value="{{ $grupo->nombre }}" placeholder="Nombre del Grupo" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
    </div>

    <div class="flex items-center justify-between">
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Actualizar</button>
    </div>
</form>

<script>
    setTimeout(function() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.display = 'none';
        }
    }, 3000);
</script>
@endsection
