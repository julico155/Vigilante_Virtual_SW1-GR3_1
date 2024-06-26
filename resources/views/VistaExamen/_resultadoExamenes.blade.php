@foreach ($examenes as $examen)
<tr class="*:py-1 *:px-2">
    <td>{{$examen->id}}</td>
    <td>{{$examen->tema}}</td>
    <td>
        @if($examen->ejecutandose != '1')
            <button class="bg-gradient-to-t text-white font-bold rounded transition duration-200
                from-blue-600 to-blue-500 py-1 px-2 border-b-2 border-blue-800" onclick="showModal('{{$examen->id}}')">
                <i class="fa-solid fa-play"></i>
            </button>
        @else
            <button class="bg-gradient-to-t text-white font-bold rounded transition duration-200
                from-orange-600 to-orange-500 py-1 px-2 border-b-2 border-orange-800">
                <i class="fa-solid fa-eye"></i>
            </button>
        @endif
        <!-- Botón para editar -->
        <a href="{{ route('Examen.edit', $examen->id) }}" class="bg-gradient-to-t text-white font-bold rounded transition duration-200
            from-green-600 to-green-500 py-1 px-2 border-b-2 border-green-800">
            <i class="fa-solid fa-edit"></i>
        </a>
        <!-- Botón para eliminar -->
        <form action="{{ route('Examen.destroy', $examen->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-gradient-to-t text-white font-bold rounded transition duration-200
                from-red-600 to-red-500 py-1 px-2 border-b-2 border-red-800" onclick="return confirm('¿Estás seguro de que quieres eliminar este examen?');">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    </td>

</tr>
@endforeach
