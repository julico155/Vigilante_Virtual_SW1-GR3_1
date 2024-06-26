@foreach($ejecuciones as $ejecucion)
<tr class="*:py-1 *:px-2">
    <td>{{$ejecucion->id}}</td>
    <td>{{$ejecucion->tema}}</td>
    <td>{{$ejecucion->estado_ejecucion}}</td>
    <td class="flex flex-wrap justify-center gap-2">
        <a href="{{route('Examen.supervicion', $ejecucion->id)}}" class="bg-gradient-to-t text-white font-bold rounded transition duration-200
        from-blue-600 to-blue-500 py-1 px-2">
            Ver
        </a>
        <a href="{{route('Examen.meet', $ejecucion->id)}}" class="bg-gradient-to-t text-white font-bold rounded transition duration-200
            from-blue-600 to-blue-500 py-1 px-2">
                Meet
            </a>
    </td>
</tr>
@endforeach