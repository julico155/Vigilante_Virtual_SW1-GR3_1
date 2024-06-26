<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Grupo;
use App\Models\Examen;
use App\Models\Materia;
use App\Models\Ejecucion;
use App\Models\Calificacion;
use App\Models\GrupoMateria;
use Illuminate\Http\Request;
use App\Models\BoletaInscripcion;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\GrupoMateriaBoletaInscripcion;

class EstudianteController extends Controller
{
    public function index()
    {
        $detalleboletas = [];
        $user = Auth::user();
        $boletas = BoletaInscripcion::where('user_estudiante_id',$user->id)->get();
        foreach ($boletas as $boleta){
            $detalleboleta = GrupoMateriaBoletaInscripcion::where('boleta_inscripcion_id',$boleta->id)->get();
            foreach($detalleboleta as $detalle) {
                $detalleboletas[] = $detalle;
            }
        }
        $grupomaterias = [];
        foreach ($detalleboletas as $detalleboleta) {
            $gmateria = GrupoMateria::find($detalleboleta->grupo_materia_id);
            $materia = Materia::find($gmateria->materia_id);
            $grupo = Grupo::find($gmateria->grupo_id);
            $docente = User::find($gmateria->user_docente_id);
            $grupomaterias[] = [
                'gp' => $gmateria,
                'materia' => $materia,
                'grupo' => $grupo,
                'docente' => $docente
            ];
        }
        return view('VistaEstudiante.index', compact('grupomaterias'));
    }

    public function unirseCurso()
    {
        $grupos = Grupo::all();
        $materias = Materia::all();
        return view('VistaEstudiante.UnirseCurso', compact('grupos', 'materias'));
    }

    public function examenes()
    {
        $id_estudiante = Auth::user()->id;
        $user = User::findOrFail($id_estudiante);
        $ejecuciones = $user->ejecuciones;
        $examenes_dados = [];
        foreach ($ejecuciones as $ejecucion) {
            $examen = $ejecucion->examen;
            $datos_examen = [
                'tema' => $examen->tema,
                'descripcion' => $examen->descripcion,
                'fecha_ejecucion' => $ejecucion->fecha,
                'estado' => $ejecucion->estado_ejecucion_id,
            ];
            $examenes_dados[] = $datos_examen;
        }
        return view('VistaEstudiante.historialexamen', ['examenes_dados' => $examenes_dados]);
    }

    public function listaEstudiantes ()
    {
        return view('VistaEstudiante.listaestudiante');
    }

    public function calificaciones()
    {
        $usuario = Auth::user();

        // Obtener todas las calificaciones del usuario autenticado
        $calificaciones = Calificacion::whereHas('ejecucion.examen.grupoMateria.grupoMateriaBoletaInscripcions', function ($query) use ($usuario) {
            $query->whereHas('boleta_inscripcion', function ($query) use ($usuario) {
                $query->where('user_estudiante_id', $usuario->id);
            });
        })->with([
            'ejecucion.examen.grupoMateria.materia',
            'ejecucion.examen.grupoMateria.userDocente',
            'ejecucion.examen.grupoMateria.grupo'
        ])->get();

        return view('VistaEstudiante.calificaciones', compact('usuario', 'calificaciones'));
    }


    public function perfil()
    {
        $usuario = Auth::user();
        return view('VistaEstudiante.perfil', compact('usuario'));
    }

    public function materia($id)
    {
        $user = Auth::user();
        $gp = GrupoMateria::find($id);
        $materia = Materia::find($gp->materia_id);
        $docente = User::find($gp->user_docente_id);
        $grupo = Grupo::find($gp->grupo_id);
        $estudiantes = [];
        $detalles = GrupoMateriaBoletaInscripcion::where('grupo_materia_id', $id)->get();
        foreach ($detalles as $detalle) {
            $boleta = BoletaInscripcion::where('id', $detalle->boleta_inscripcion_id)->first();
            $alumno = User::where('id', $boleta->user_estudiante_id)->first();
            $estudiantes[] = $alumno;
        }
        $examenes = Examen::where('grupo_materia_id', $id)->get();
        $ejecuciones = Ejecucion::whereIn('examen_id', $examenes->pluck('id'))->get();
        $calificaciones = Calificacion::whereIn('ejecucion_id', $ejecuciones->pluck('id'))->get();
        foreach ($calificaciones as $calificacion) {
            Log::info('Calificacion:', ['calificacion' => $calificacion]);
            Log::info('Ejecucion:', ['ejecucion' => $calificacion->ejecucion]);
            Log::info('Examen:', ['examen' => $calificacion->ejecucion->examen]);
        }
        return view('VistaEstudiante.materia', compact('materia', 'gp', 'estudiantes', 'grupo', 'docente', 'examenes', 'ejecuciones', 'calificaciones'));
    }

    public function editar($id)
    {
        $usuario = User::find($id);
        return view('VistaEstudiante.editar', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        if ($request->hasFile('profile_photo_path')) {
            $imageName = $request->nombre . '.' . $request->profile_photo_path->extension();
            $request->profile_photo_path->move(public_path('images/user'), $imageName);
            $usuario->profile_photo_path = '/images/user/' . $imageName;
        }

        $usuario->carnet_identidad = $request->carnet_identidad;
        $usuario->nombre = $request->nombre;
        $usuario->apellido_paterno = $request->apellido_paterno;
        $usuario->apellido_materno = $request->apellido_materno;
        $usuario->telefono = $request->telefono;
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;

        $usuario->save();

        $authUser = Auth::user();
        if ($authUser->hasRole('Estudiante')) {
        return redirect()->route('Estudiante.perfil')->with('success', 'Usuario actualizado correctamente');
        }
        if($authUser->hasRole('Docente')) {
            return redirect()->route('Docente.index')->with('success', 'Usuario actualizado correctamente');
        }
    }

    public function calendar()
    {
        if (auth()->user()->hasRole('Estudiante')) {
        $events = [];
        
        $usuarioAutenticado = Auth::user();
        $examenes = Examen::where('user_id', $usuarioAutenticado->id)->get();
        foreach ($examenes as $examen){
            $ejecucion = Ejecucion::where('examen_id', $examen->id)->get()->first();
            $fechaHoraI = $ejecucion->fecha . 'T' . $ejecucion->hora_inicio;
            $fechaHoraF = $ejecucion->fecha . 'T' . $ejecucion->hora_final;
            
            $events[] = [
                'title' => $examen->tema,
                'start' => $fechaHoraI,
                'end' => $fechaHoraF,
            ];
        }

        return view('VistaWelcome.calendar',compact('events'));
        }
        else{
            $usuarioAutenticado = Auth::user();
            $ejecuciones = $usuarioAutenticado->ejecuciones;
            $events = [];
            foreach ($ejecuciones as $ejecucion){
                $examen = Examen::where('id',$ejecucion->examen_id);
                $fechaHoraI = $ejecucion->fecha . 'T' . $ejecucion->hora_inicio;
                $fechaHoraF = $ejecucion->fecha . 'T' . $ejecucion->hora_final;
                $events[] = [
                    'title' => $examen->tema,
                    'start' => $fechaHoraI,
                    'end' => $fechaHoraF,
                ];
            }
            
            return view('VistaWelcome.calendar',compact('events'));
        }
    }
}
