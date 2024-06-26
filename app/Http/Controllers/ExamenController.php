<?php

namespace App\Http\Controllers;

use App\Models\Anomalia;
use App\Models\Calificacion;
use App\Models\Ejecucion;
use App\Models\Examen;
use App\Models\GrupoMateria;
use App\Models\Pregunta;
use App\Models\PreguntaSeleccionada;
use App\Models\Respuesta;
use App\Models\RespuestaCalificacion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        /**
         * Actualmente se esta manejando con usuario, luego se tiene que cambiar
         * por docente.
         */

        $id_user = Auth::user()->id;
        $user = User::find($id_user); //Para poder manipularlo como un objeto User

        if ($user) {

            $examenes = $user->examenes()->get();

            $creados = count($examenes);

            $ejecutados = 0;
            foreach ($examenes as $examen) {
                $ejecutados += count($examen->ejecuciones()->where('estado_ejecucion_id', 2)->get());
            }

            $data = array(
                'user_id' => $user->id,
                'min' => 1
            );
            $ejecutando = Ejecucion::getExamenesEjecutandose($data)[0];

            $data = compact(
                'examenes',
                'ejecutados',
                'creados',
                'ejecutando'
            );
            return view('VistaExamen.index')->with($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($grupo_materia_id)
    {
        //dd($id);
        $grupo_materia = GrupoMateria::find($grupo_materia_id);

        $data = compact(
            'grupo_materia'
        );
        return view('VistaExamen.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        //echo ($request);

        //Colocar filtro de profesor
        if ($user) {

            $request->validate([
                'tema' => 'required|string|max:100',
                'descripcion' => 'required|string|max:255',
            ]);

            $examen = Examen::create([
                'tema'              =>  $request->tema,
                'descripcion'       =>  $request->descripcion,
                'user_id'           =>  $user->id,
                'grupo_materia_id'  => $request->grupo_materia_id
            ]);

            $preguntas = $request->preguntas;

            foreach ($preguntas as $item_pregunta) {

                $pregunta = Pregunta::create([
                    'descripcion'       =>  $item_pregunta['descripcion_pregunta'],
                    'ponderacion'       =>  $item_pregunta['ponderacion_pregunta'],
                    'comentario'        =>  $item_pregunta['comentario_pregunta'],
                    'tipo_pregunta_id'  =>  $item_pregunta['tipo_pregunta'],
                    'examen_id'         =>  $examen->id,
                ]);

                $respuestas = $item_pregunta['respuestas'];
                foreach ($respuestas as $item_respuesta) {
                    $respuesta = Respuesta::create([
                        'descripcion' => $item_respuesta['descripcion'],
                        'es_correcta' => $item_respuesta['es_correcta'],
                        'pregunta_id' => $pregunta->id,
                    ]);
                }
            }

            if ($request->ejecucion) {

                $ejecucion = Ejecucion::create([
                    'fecha'                 =>  $request->fecha,
                    'hora_inicio'           =>  $request->hora_inicio,
                    'hora_final'            =>  $request->hora_final,
                    'ponderacion'           =>  $request->ponderacion,
                    'contrasena'            =>  $request->contrasena,
                    'nro_preguntas'         =>  $request->nro_preguntas,
                    'examen_id'             =>  $examen->id,
                    'estado_ejecucion_id'   =>  3,
                    'navegacion'            =>  $request->navegacion == 'on' ? '1' : '0',
                    'retroalimentacion'     =>  $request->retroalimentacion == 'on' ? '1' : '0',
                ]);

                toastr('Ejecucion de examen programada correctamete', 'success', 'Ejecucion de examen');
            }
            toastr('Examen creado correctamente', 'success', 'Examen');

            return array('msg' => 'ok');
        }
    }

    public function edit(string $id)
    {
        $examen = Examen::findOrFail($id);
        $preguntas = $examen->preguntas()->with('respuestas')->get();
        $grupo_materia = GrupoMateria::find($examen->grupo_materia_id);
        $ejecucion = $examen->ejecucion; 

        $data = compact(
            'examen',
            'preguntas',
            'grupo_materia',
            'ejecucion'
        );
        return view('VistaExamen.edit', $data);
    }


    public function update(Request $request, string $id)
    {
        $examen = Examen::findOrFail($id);

        $request->validate([
            'tema' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
        ]);

        $examen->update([
            'tema' => $request->tema,
            'descripcion' => $request->descripcion,
        ]);

        $preguntas = $request->preguntas;

        // Eliminar preguntas anteriores
        $examen->preguntas()->delete();

        // Crear nuevas preguntas y respuestas
        foreach ($preguntas as $item_pregunta) {
            $pregunta = Pregunta::create([
                'descripcion' => $item_pregunta['descripcion_pregunta'],
                'ponderacion' => $item_pregunta['ponderacion_pregunta'],
                'comentario' => $item_pregunta['comentario_pregunta'],
                'tipo_pregunta_id' => $item_pregunta['tipo_pregunta'],
                'examen_id' => $examen->id,
            ]);

            $respuestas = $item_pregunta['respuestas'];
            foreach ($respuestas as $item_respuesta) {
                Respuesta::create([
                    'descripcion' => $item_respuesta['descripcion'],
                    'es_correcta' => $item_respuesta['es_correcta'],
                    'pregunta_id' => $pregunta->id,
                ]);
            }
        }

        if ($request->ejecucion) {
            Ejecucion::updateOrCreate(
                ['examen_id' => $examen->id],
                [
                    'fecha' => $request->fecha,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_final' => $request->hora_final,
                    'ponderacion' => $request->ponderacion,
                    'contrasena' => $request->contrasena,
                    'nro_preguntas' => $request->nro_preguntas,
                    'estado_ejecucion_id' => 3,
                    'navegacion' => $request->navegacion == 'on' ? '1' : '0',
                    'retroalimentacion' => $request->retroalimentacion == 'on' ? '1' : '0',
                ]
            );
        }

        toastr('Examen actualizado correctamente', 'success', 'Examen');
        return redirect()->back();
    }

    public function show(string $id)
    {
        $examen = Examen::findOrFail($id);
        $preguntas = $examen->preguntas()->with('respuestas')->get();
        $grupo_materia = GrupoMateria::find($examen->grupo_materia_id);

        $data = compact(
            'examen',
            'preguntas',
            'grupo_materia'
        );
        return view('VistaExamen.show', $data);
    }

    public function destroy(string $id)
    {
        $examen = Examen::findOrFail($id);
        $examen->delete();

        toastr('Examen eliminado correctamente', 'success', 'Examen');
        return redirect()->route('Examen.index');
    }

    public function start($id)
    {
        $ejecucion = Ejecucion::findOrFail($id);
        $examen = $ejecucion->examen()->first();

        $user = Auth::user();
        $user = User::findOrFail($user->id);
        $calificacion = Calificacion::where('user_id', $user->id)
            ->where('ejecucion_id', $ejecucion->id)->first();

        //Da 2 vueltas por si acaso
        for ($i = 0; $i < 2; $i++) {
            $ejecucion->estado_ejecucion_id = $this->verificarEjecucion($ejecucion);
            $ejecucion->save();
        }


        $now = Carbon::now();
        $fecha = Carbon::parse($ejecucion->fecha);

        switch ($ejecucion->estado_ejecucion_id) {
            case 1:
                $restante = 'El examen termina en: ' . $now->diff($fecha->copy()->setTimeFrom($ejecucion->hora_final))->format('%H:%I:%S');
                break;
            case 2:
                $restante = 'El examen terminó hace: ' . $fecha->copy()->setTimeFrom($ejecucion->hora_final)->diff($now)->format('%H:%I:%S');
                break;
            case 3:
                $restante = 'El examen inicia en: ' . $now->diff($fecha->copy()->setTimeFrom($ejecucion->hora_inicio))->format('%H:%I:%S');
                break;
        }

        $data = compact(
            'examen',
            'ejecucion',
            'calificacion',
            'restante'
        );
        return view('VistaExamen.start', $data);
    }

    private function verificarEjecucion(Ejecucion $ejecucion)
    {
        $now = Carbon::now();

        // Si está en proceso
        if ($ejecucion->estado_ejecucion_id == '1') {
            // Si la fecha actual es después de la fecha de ejecución
            if ($now->isAfter(Carbon::createFromFormat('Y-m-d H:i:s', $ejecucion->fecha . ' ' . $ejecucion->hora_final))) {
                return '2';
            }
        }

        // Si está pendiente
        if ($ejecucion->estado_ejecucion_id == '3') {
            $horaInicio = Carbon::createFromFormat('H:i:s', $ejecucion->hora_inicio);
            $horaFinal = Carbon::createFromFormat('H:i:s', $ejecucion->hora_final);
            $nowTime = $now->format('H:i:s');

            // Si la fecha actual es igual a la fecha de ejecución y la hora actual está entre la hora de inicio y la hora final
            if ($now->format('Y-m-d') == $ejecucion->fecha && $nowTime >= $horaInicio->format('H:i:s') && $nowTime <= $horaFinal->format('H:i:s')) {
                return '1';
            }
        }

        return $ejecucion->estado_ejecucion_id;
    }


    public function running($id)
    {
        $user = Auth::user();

        if ($user) {
            $user = User::find($user->id);
        }

        $ejecucion = Ejecucion::findOrFail($id);
        if ($ejecucion->estado_ejecucion_id == 1) {

            $examen = $ejecucion->examen()->first();
            $preguntas = $examen->preguntas()->get();

            // echo($preguntas);
            // dd($preguntas);

            $calificacion = Calificacion::where('user_id', $user->id)
                ->where('ejecucion_id', $ejecucion->id)
                ->first();

            $inicial = 0;

            if (!$calificacion) {
                $newCalificacion = new Calificacion();
                $newCalificacion->ejecucion_id = $ejecucion->id;
                $newCalificacion->user_id = $user->id;
                $newCalificacion->save();

                //dd($calificacion);

                if (count($preguntas) > $ejecucion->nro_preguntas) {

                    $total_ponderacion = 0;

                    while ($total_ponderacion != 100) {
                        $preguntas = $examen->preguntas()->inRandomOrder()->limit($ejecucion->nro_preguntas)->get();
                        $preguntas_seleccionadas = [];

                        $total_ponderacion = $preguntas->sum('ponderacion');
                        //echo $total_ponderacion;

                        if ($total_ponderacion == 100) {
                            $preguntas_seleccionadas = $preguntas->toArray();
                            break;
                        }
                    }
                } else {
                    $preguntas_seleccionadas = $preguntas;
                }


                foreach ($preguntas_seleccionadas as $pregunta) {
                    $preguntaSeleccionada = new PreguntaSeleccionada();
                    $preguntaSeleccionada->pregunta_id = $pregunta['id'];
                    $preguntaSeleccionada->calificacion_id = $newCalificacion->id;
                    $preguntaSeleccionada->save();
                    //echo($preguntaSeleccionada);
                }
                //dd($preguntas_seleccionadas);

            } else {

                $preguntas_previas = PreguntaSeleccionada::where('calificacion_id', $calificacion->id)->get();
                $preguntas_seleccionadas = [];

                foreach ($preguntas_previas as $pregunta) {
                    $preguntas_seleccionadas[] = Pregunta::find($pregunta->pregunta_id)->toArray();
                }

                $respuestasMarcadas = count(RespuestaCalificacion::where('calificacion_id', $calificacion->id)->orderBy('id', 'ASC')->get());

                $inicial = $respuestasMarcadas;
            }


            for ($i = 0; $i < count($preguntas_seleccionadas); $i++) {
                $preguntas_seleccionadas[$i]['respuestas'] = Pregunta::getAllRespuestas($preguntas_seleccionadas[$i]['id'], 1);
            }
            //dd($preguntas_seleccionadas);


            $fecha = Carbon::parse($ejecucion->fecha);
            $now = Carbon::now();

            $tiempo_restante = $fecha->copy()->setTimeFrom($ejecucion->hora_final)->diff($now)->format('%H:%I:%S');

            $data = compact(
                'preguntas_seleccionadas',
                'tiempo_restante',
                'examen',
                'ejecucion',
                'inicial'
            );

            //dd($examen);


            return view('VistaExamen.running', $data);
        }
    }

    public function guardarRespuesta(Request $request)
    {
        try {

            $data = [
                'ejecucion_id' => $request->ejecucion_id,
                'respuestas' => $request->respuestas_array,
                'pregunta_id' => $request->pregunta_id,
                'tipo_pregunta_id' => $request->tipo_pregunta_id,
            ];

            $this->storeAnswer($data);
            return ['msg' => 'ok'];
        } catch (\Exception $e) {
            return ['error' => '!ok', 'msg' => $e];
        }
    }

    private function storeAnswer($data)
    {
        $user = User::find(Auth::user()->id);
        $calificacion = Calificacion::where('user_id', $user->id)
            ->where('ejecucion_id', $data['ejecucion_id'])->first();
        $pregunta_id = $data['pregunta_id'];
        $tipoPregunta = $data['tipo_pregunta_id'];

        $this->verificarRespuesta($pregunta_id, $calificacion->id);

        foreach ($data['respuestas'] as $respuesta) {

            $respuestaCalificacion = RespuestaCalificacion::create([
                'calificacion_id' => $calificacion->id,
                'respuesta_id' => $tipoPregunta != '3' ? $respuesta : null,
                'pregunta_id' => $pregunta_id,
                'contenido' => $tipoPregunta == '3' ? $respuesta : null,
            ]);
        }
    }

    private function verificarRespuesta($pregunta_id, $calificacion_id)
    {
        $preguntaYaRespondida = RespuestaCalificacion::where('pregunta_id', $pregunta_id)
            ->where('calificacion_id', $calificacion_id)->get();

        foreach ($preguntaYaRespondida as $respuesta) {
            $respuesta->delete();
        }
    }


    public function enviar($ejecucion_id)
    {
        $user = Auth::user();

        $calificacion = Calificacion::where('user_id', $user->id)
            ->where('ejecucion_id', $ejecucion_id)->first();

        if ($calificacion) {
            $respuestasCalificacion = RespuestaCalificacion::where('calificacion_id', $calificacion->id)->get();
            $preguntas_seleccionadas = PreguntaSeleccionada::where('calificacion_id', $calificacion->id)->get();
            foreach ($preguntas_seleccionadas as $pregunta_sel) {
                foreach ($respuestasCalificacion as $respuesta) {
                    if ($respuesta->respuesta_id) {
                        $respuestaEncontrada = Respuesta::find($respuesta->respuesta_id);
                        if ($respuestaEncontrada->pregunta_id == $pregunta_sel->pregunta_id) {
                            $pregunta_sel->hecha = '1';
                        }
                    } else {
                        if ($respuesta->pregunta_id == $pregunta_sel->pregunta_id) {
                            $pregunta_sel->hecha = '1';
                        }
                    }
                }
                if (!$pregunta_sel->hecha) {
                    $pregunta_sel->hecha = '0';
                }
            }

            $ejecucion = Ejecucion::find($ejecucion_id);
            $examen = Examen::find($ejecucion->examen_id);

            $data = compact(
                'preguntas_seleccionadas',
                'ejecucion',
                'examen',
                'calificacion'
            );

            //dd($preguntas_seleccionadas);
            return view('VistaExamen.enviar', $data);
        } else {
            return redirect()->route('Examen.start', $ejecucion_id);
        }
    }

    public function verificarNavegabilidad(Request $request)
    {
        $ejecucion_id = $request->ejecucion_id;
        $user = Auth::user();

        $calificacion = Calificacion::where('ejecucion_id', $ejecucion_id)
            ->where('user_id', $user->id)->first();

        if ($calificacion) {
            $respuestasCalificacion = RespuestaCalificacion::where('calificacion_id', $calificacion->id)->get();
            $preguntas_seleccionadas = PreguntaSeleccionada::where('calificacion_id', $calificacion->id)->get();
            foreach ($preguntas_seleccionadas as $pregunta_sel) {
                foreach ($respuestasCalificacion as $respuesta) {
                    if ($respuesta->respuesta_id) {
                        $respuestaEncontrada = Respuesta::find($respuesta->respuesta_id);
                        if ($respuestaEncontrada->pregunta_id == $pregunta_sel->pregunta_id) {
                            $pregunta_sel->hecha = '1';
                        }
                    } else {
                        if ($respuesta->pregunta_id == $pregunta_sel->pregunta_id) {
                            $pregunta_sel->hecha = '1';
                        }
                    }
                }

                if (!$pregunta_sel->hecha) {
                    $pregunta_sel->hecha = '0';
                }
            }

            return [
                'msg' => 'ok',
                'preguntas' => $preguntas_seleccionadas
            ];
        }
        return ['msg' => '!ok'];
    }

    public function terminarIntento($calificacion_id)
    {
        $calificacion = Calificacion::find($calificacion_id);
        if ($calificacion->finaliado != '0') {
            $preguntas_seleccionadas = PreguntaSeleccionada::where('calificacion_id', $calificacion->id)->get();
            $nota = 0;
            foreach ($preguntas_seleccionadas as $pregunta_seleccionada) {
                $pregunta = Pregunta::find($pregunta_seleccionada->pregunta_id);
                if ($pregunta->tipo_pregunta_id == '1') {
                    $respuesta_correcta = Respuesta::where('pregunta_id', $pregunta->id)
                        ->where('es_correcta', 1)->first();

                    $respuesta_dada = RespuestaCalificacion::where('calificacion_id', $calificacion_id)
                        ->where('respuesta_id', $respuesta_correcta->id)->first();

                    if ($respuesta_dada) {
                        $nota += $pregunta->ponderacion;
                    }
                }

                if ($pregunta->tipo_pregunta_id == '2') {
                    $notaParcial = $this->calcularNotaPreguntaMultiple($pregunta->id, $calificacion->id);
                    $nota += $notaParcial;
                }

                if ($pregunta->tipo_pregunta_id == '3') {
                    $respuesta_enviada = RespuestaCalificacion::where('calificacion_id', $calificacion->id)
                        ->where('pregunta_id', $pregunta->id)->first();
                    if ($respuesta_enviada && $respuesta_enviada->puntaje) {
                        $nota += $respuesta_enviada->puntaje;
                    }
                }
            }

            $calificacion->finalizado = '1';
            $calificacion->nota = $nota;
            $calificacion->save();
        }

        $ejecucion = Ejecucion::find($calificacion->ejecucion_id);

        $examen = Examen::find($ejecucion->examen_id);

        $data = compact(
            'calificacion',
            'ejecucion',
            'examen'
        );
        return view('VistaExamen.finalizado', $data);
    }

    public function verIntento($calificacion_id)
    {
        $user = User::find(Auth::id());

        $calificacion = Calificacion::find($calificacion_id);

        $ejecucion = Ejecucion::find($calificacion->ejecucion_id);

        if ($calificacion->user_id == $user->id && $ejecucion->retroalimentacion) {
            $preguntas_seleccionadas = PreguntaSeleccionada::where('calificacion_id', $calificacion->id)->get();

            $preguntas_respuestas = new Collection;

            foreach ($preguntas_seleccionadas as $pregunta_seleccionada) {

                $pregunta_respuesta = new Collection;

                $pregunta = Pregunta::where('id', $pregunta_seleccionada->pregunta_id)->first();

                if ($pregunta->tipo_pregunta_id != '3') {

                    $respuestas = Respuesta::where('pregunta_id', $pregunta->id)->get();

                    $respuestas_enviadas = RespuestaCalificacion::where('calificacion_id', $calificacion->id)
                        ->where('pregunta_id', $pregunta->id)->get();

                    $pregunta->nota = $this->calcularNotaPreguntaMultiple($pregunta->id, $calificacion->id);

                    //Si ha respondido la pregunta o no
                    if (count($respuestas_enviadas) > 0) {

                        foreach ($respuestas as $respuesta) {
                            if ($respuestas_enviadas->pluck('respuesta_id')->contains($respuesta->id)) {
                                $respuesta->respondida = '1';
                            } else {
                                $respuesta->respondida = '0';
                            }
                        }
                    } else {
                        foreach ($respuestas as $respuesta) {
                            $respuesta->respondida = '0';
                        }
                    }
                } else {

                    $respuesta_libre = RespuestaCalificacion::where('calificacion_id', $calificacion->id)
                        ->where('pregunta_id', $pregunta->id)->first();
                    $respuestas = new Collection;
                    if ($respuesta_libre) {
                        $respuestas[]  = $respuesta_libre;
                    } else {
                        $respuestas[] = [];
                    }
                }

                $pregunta_respuesta['pregunta'] = $pregunta;
                $pregunta_respuesta['respuestas'] = $respuestas;

                $preguntas_respuestas[] = $pregunta_respuesta;
            }

            $examen = Examen::find($ejecucion->examen_id);

            $data = compact(
                'preguntas_respuestas',
                'examen',
                'calificacion',
                'user'
            );

            return view('VistaExamen.retroalimentacion', $data);
        }

        //dd($preguntas_respuestas);

    }

    private function calcularNotaPreguntaMultiple($pregunta_id, $calificacion_id)
    {
        $nota = 0;
        $pregunta = Pregunta::find($pregunta_id);

        $calificacion = Calificacion::find($calificacion_id);

        $respuestas_correctas = Respuesta::where('pregunta_id', $pregunta->id)
            ->where('es_correcta', 1)->get();

        $cantidad_respuestas = count(Respuesta::where('pregunta_id', $pregunta->id)->get());

        $cantidad_verdaderas = count($respuestas_correctas);

        $ponderacion_verdadera = $pregunta->ponderacion / $cantidad_verdaderas;

        $ponderacion_falsa = $pregunta->ponderacion / ($cantidad_respuestas - $cantidad_verdaderas);


        $verdaderas_respondidas = 0;

        $notaParcial = 0;

        foreach ($respuestas_correctas as $respuesta_correcta) {
            $respondio = RespuestaCalificacion::where('respuesta_id', $respuesta_correcta->id)->first();

            if ($respondio) {
                $verdaderas_respondidas++;
            }
        }

        $respuestas_dadas = RespuestaCalificacion::where('calificacion_id', $calificacion_id)
            ->where('pregunta_id', $pregunta->id)->get();

        $incorrectas_respondidas = 0;

        foreach ($respuestas_dadas as $respuesta_dada) {
            $respuesta = Respuesta::where('id', $respuesta_dada->respuesta_id)
                ->whereNot('es_correcta', 1)->first();

            if ($respuesta) {
                $incorrectas_respondidas++;
            }
        }

        $notaParcial = $verdaderas_respondidas * $ponderacion_verdadera;
        $notaParcial -= $incorrectas_respondidas * $ponderacion_falsa;

        if ($notaParcial > 0) {
            $nota += $notaParcial;
            $nota = round($nota, 2);
        }

        return $nota;
    }

    public function ausente()
    {
        return view('VistaExamen.ausente');
    }

    public function supervicion($ejecucion_id)
    {
        $ejecucion = Ejecucion::find($ejecucion_id);

        $data = compact(
            'ejecucion'
        );

        return view('VistaExamen.supervicion', $data);
    }

    public function meet($ejecucion_id)
    {
        $ejecucion = Ejecucion::find($ejecucion_id);
        $teacherName = auth()->user()->name; // Obtener el nombre del docente autenticado

        $data = compact('ejecucion', 'teacherName');

        return view('teacher_video', $data);
    }


    public function getEstudiantes(Request $request)
    {
        $ejecucion_id = $request->ejecucion_id;

        $calificaciones = Calificacion::where('ejecucion_id', $ejecucion_id)
            ->get();

        foreach ($calificaciones as $calificacion) {
            $user = User::where('id', $calificacion->user_id)->first();
            $calificacion->usuario = $user;

            $anomalias =  Anomalia::where('user_id', $user->id)
                ->where('ejecucion_id', $ejecucion_id)->get();

            $calificacion->anomalias = $anomalias;
        }

        return [
            'msg' => 'ok',
            'data' => $calificaciones
        ];
    }

    public function getAnomalias(Request $request)
    {
        $ejecucion_id = $request->ejecucion_id;
        $user_id = $request->user_id;

        $user = User::where('id', $user_id)->first();

        $anomalias =  Anomalia::where('user_id', $user->id)
            ->where('ejecucion_id', $ejecucion_id)->get();


        return [
            'msg' => 'ok',
            'data' => $anomalias
        ];
    }

    public function storeEjecucion(Request $request)
    {
        $examen = Examen::find($request->examen_id);

        $preguntas = Pregunta::where('examen_id', $examen->id)->get();

        if (count($preguntas) < $request->nro_preguntas) {
            return ['msg' => 'neq']; //not enougth questions
        }

        $ejecucion = Ejecucion::create([
            'fecha'                 =>  $request->fecha,
            'hora_inicio'           =>  $request->hora_inicio,
            'hora_final'            =>  $request->hora_final,
            'ponderacion'           =>  $request->ponderacion,
            'contrasena'            =>  $request->contrasena,
            'nro_preguntas'         =>  $request->nro_preguntas,
            'examen_id'             =>  $examen->id,
            'estado_ejecucion_id'   =>  3,
            'navegacion'            =>  $request->navegacion == 'on' ? '1' : '0',
            'retroalimentacion'     =>  $request->retroalimentacion == 'on' ? '1' : '0',
        ]);

        toastr('Ejecucion de examen programada correctamete', 'success', 'Ejecucion de examen');

        return ['msg' => 'ok'];
    }
}
