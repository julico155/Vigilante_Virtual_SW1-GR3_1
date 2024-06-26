@extends('Panza')
@section('Panza')

<div class="container mx-auto px-4">
    <div class="flex justify-center">
        <div class="w-full lg:w-1/2">
            <div class="bg-white shadow-md rounded-lg p-8">
                <div class="text-2xl font-bold mb-6">{{ __('Crear nuevo rol') }}</div>

                <form method="POST" action="{{ route('Roles.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Nombre del Rol') }}</label>
                        <input id="name" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="text-red-500 text-xs italic mt-2">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">{{ __('Permisos') }}</label>
                        @foreach($permissions as $permission)
                            <div class="mt-2">
                                <input type="checkbox" id="{{ $permission->name }}" name="permissions[]" value="{{ $permission->id }}">
                                <label for="{{ $permission->name }}" class="ml-2">{{ $permission->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-between mt-6">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Crear Rol') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('form').submit(function(e) {
    if ($('input[type=checkbox]:checked').length === 0) {
        e.preventDefault();
        alert('Por favor, selecciona al menos un permiso.');
    }
});

</script>

@endsection
