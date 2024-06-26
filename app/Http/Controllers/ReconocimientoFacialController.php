<?php

namespace App\Http\Controllers;
use App\Models\TipoAnomalia;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Anomalia;
use Carbon\Carbon;
class ReconocimientoFacialController extends Controller
{
    public function index()
    {
        $tipoAnomalias = TipoAnomalia::all('nombre');
        $nombreUsuario = auth()->user()->name;
        return view('VistaReconocimientoFacial.index', ['tipoAnomalias' => $tipoAnomalias, 'nombreUsuario' => $nombreUsuario]);
    }

    public function guardarFotoAnomalia(Request $request)
    {
        $imageData = $request->input('image');
        $image = str_replace('data:image/jpeg;base64,', '', $imageData);
        $image = str_replace(' ', '+', $image);
        $imageName = 'anomalia_' . time() . '.jpg';

        // Guardar la imagen en el sistema de archivos
        Storage::disk('public')->put('anomalias/' . $imageName, base64_decode($image));

        // Guardar la información de la anomalia en la base de datos
        $anomalia = new Anomalia();
        $anomalia->ejecucion_id = null; // Actualiza esto según tus necesidades
        $anomalia->user_id = auth()->user()->id;
        $anomalia->hora = Carbon::now()->format('H:i:s');
        $anomalia->fecha = Carbon::today()->format('Y-m-d');
        $anomalia->url_imagen = 'anomalias/' . $imageName;
        $anomalia->tipo_anomalia_id = $request->input('tipo_anomalia_id');
        $anomalia->ejecucion_id = $request->input('ejecucion_id');
        $anomalia->save();

        return response()->json(['message' => 'Imagen y anomalia guardadas exitosamente']);
    }

}
