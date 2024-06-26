<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoletaInscripcion;
use App\Models\Comprobante;
use App\Models\GrupoMateria;
use App\Models\GrupoMateriaBoletaInscripcion;
use App\Models\Servicio;
use App\Models\ServicioComprobante;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $fecha = $request->get('fecha');

        $boleta_inscripcion = BoletaInscripcion::query()
            ->where(function ($query) use ($search) {
                $query->whereHas('user_estudiante', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('carnet_identidad', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('user_administrativo', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('carnet_identidad', 'LIKE', "%{$search}%");
                });
            })
            ->where(function ($query) use ($fecha) {
                if ($fecha) {
                    $query->whereDate('fecha', Carbon::parse($fecha)->format('Y-m-d'));
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($boleta_inscripcion as $inscripcion) {
            $inscripcion->materias_inscritas = $inscripcion->grupo_materia_boleta_inscripcion->count();
        }

        if ($request->ajax()) {
            return view('VistaInscripcion.table', compact('boleta_inscripcion'));
        }

        $usuarios = User::all();

        $totalMatriculados = 0;
        $totalMatriculasNoUsadas = 0;

        foreach ($usuarios as $usuario) {
            $matriculaUsada = $usuario->comprobantes()->whereHas('servicios', function ($query) {
                $query->where('usado', 1);
            })->exists();

            $matriculaNoUsada = $usuario->comprobantes()->whereHas('servicios', function ($query) {
                $query->where('usado', 0);
            })->exists();

            if ($matriculaUsada) {
                $totalMatriculados++;
            }
            if ($matriculaNoUsada) {
                $totalMatriculasNoUsadas++;
            }
        }

        return view('VistaInscripcion.index', compact('boleta_inscripcion', 'totalMatriculados', 'totalMatriculasNoUsadas'));
    }

    public function create(Request $request)
    {
        $search = $request->get('search');
        $carnet_identidad = $request->get('carnet_identidad');
        $usuario = User::where('carnet_identidad', $carnet_identidad)->first();

        $grupomaterias = GrupoMateria::query()
            ->where(function ($query) use ($search) {
                $query->whereHas('materia', function ($query) use ($search) {
                    $query->where('nombre', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('grupo', function ($query) use ($search) {
                        $query->where('nombre', 'LIKE', "%{$search}%");
                    });
            })
            ->get();

        if ($grupomaterias->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron resultados');
        }

        if ($request->ajax()) {
            return view('VistaInscripcion.tablacreate', compact('grupomaterias'));
        }

        return view('VistaInscripcion.create', compact('grupomaterias'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carnet_identidad' => 'required',
            'grupomaterias' => 'required|array',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = '';

            if ($errors->has('carnet_identidad')) {
                $error = 'Carnet no encontrado';
            }

            return redirect()->back()->withErrors($error)->withInput();
        }

        $carnet_identidad = $request->carnet_identidad;

        $estudiante = User::where('carnet_identidad', $request->carnet_identidad)->first();

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado');
        }

        $servicioMatricula = Servicio::where('nombre', 'Matricula')->first();
        if (!$servicioMatricula) {
            return redirect()->back()->with('error', 'Servicio Matricula no encontrado');
        }

        $comprobante = Comprobante::where('user_estudiante_id', $estudiante->id)->orderBy('created_at', 'desc')->first();
        if (!$comprobante) {
            return redirect()->back()->with('error', 'Comprobante no encontrado');
        }

        $servicioNoUsado = ServicioComprobante::where('comprobante_id', $comprobante->id)
            ->where('servicio_id', $servicioMatricula->id)
            ->where('usado', false)
            ->first();

        if (!$servicioNoUsado) {
            $servicioNoUsado = ServicioComprobante::whereHas('comprobante', function ($query) use ($estudiante) {
                $query->where('user_estudiante_id', $estudiante->id);
            })
                ->where('servicio_id', $servicioMatricula->id)
                ->where('usado', false)
                ->first();

            if (!$servicioNoUsado) {
                return redirect()->back()->with('error', 'No Tiene Matricula Disponible');
            }
        }

        $grupomaterias = $request->grupomaterias;

        $boleta_inscripcion = BoletaInscripcion::create([
            'user_estudiante_id' => $estudiante->id,
            'user_administrativo_id' => auth()->user()->id,
            'hora' => now()->timezone('America/La_Paz')->format('H:i:s'),
            'fecha' => now()->timezone('America/La_Paz')->format('Y-m-d'),
            'cantidad_materias_inscritas' => count($grupomaterias),
        ]);

        foreach ($grupomaterias as $grupomateria) {
            $grupo_materia = GrupoMateria::find($grupomateria);

            if ($grupo_materia->cantidad_estudiantes_inscritos >= $grupo_materia->cantidad_estudiantes) {
                return redirect()->back()->with('error', 'El grupo de materia seleccionado ya no tiene cupo');
            }

            $boleta_inscripcion->grupo_materia_boleta_inscripcion()->create([
                'boleta_inscripcion_id' => $boleta_inscripcion->id,
                'grupo_materia_id' => $grupo_materia->id,
            ]);

            $grupo_materia->cantidad_estudiantes_inscritos += 1;
            $grupo_materia->save();
        }

        $servicioNoUsado->usado = true;
        $servicioNoUsado->save();

        return redirect()->route('Inscripcion.index')->with('success', 'Inscripción realizada con éxito');
    }

    public function show(string $id)
    {
        $boletaInscripcion = BoletaInscripcion::find($id);
        if (!$boletaInscripcion) {
            return redirect()->back()->with('error', 'Boleta de inscripción no encontrada');
        }

        $nombreEstudiante = $boletaInscripcion->user_estudiante ? $boletaInscripcion->user_estudiante->name : 'No asignado';
        $nombreAdministrativo = $boletaInscripcion->user_administrativo ? $boletaInscripcion->user_administrativo->name : 'No asignado';

        $materias_inscritas = [];
        $grupoMateriaBoletaInscripcions = $boletaInscripcion->grupo_materia_boleta_inscripcion ?? [];
        foreach ($grupoMateriaBoletaInscripcions as $gmbi) {
            $materias_inscritas[] = [
                'nombre_materia' => $gmbi->grupo_materia->materia->nombre,
                'nombre_grupo' => $gmbi->grupo_materia->grupo->nombre,
            ];
        }
        $totalMateriasInscritas = $boletaInscripcion->cantidad_materias_inscritas;

        return view('VistaInscripcion.show', compact('materias_inscritas', 'boletaInscripcion', 'totalMateriasInscritas', 'nombreEstudiante', 'nombreAdministrativo'));
    }

    public function edit(string $id, Request $request)
    {

        $boleta_inscripcion = BoletaInscripcion::find($id);
        if (!$boleta_inscripcion) {
            return redirect()->back()->with('error', 'Boleta de inscripción no encontrada');
        }

        $user_estudiante = User::find($boleta_inscripcion->user_estudiante_id);
        if (!$user_estudiante) {
            return redirect()->back()->with('error', 'Usuario estudiante no encontrado');
        }
        $total_materias_inscritas = GrupoMateriaBoletaInscripcion::where('boleta_inscripcion_id', $id)->count();

        $search = $request->get('search');

        if ($search) {
            $grupomaterias = GrupoMateria::query()
                ->whereHas('materia', function ($query) use ($search) {
                    $query->where('nombre', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('grupo', function ($query) use ($search) {
                    $query->where('nombre', 'LIKE', "%{$search}%");
                })
                ->get();
        } else {
            $grupomaterias = GrupoMateria::all();
        }

        $inscribedGrupoMaterias = $boleta_inscripcion->grupo_materia_boleta_inscripcion->pluck('grupo_materia_id')->toArray();

        if ($request->ajax()) {
            return response()->json([
                'view' => view('VistaInscripcion.tablaedit', compact('grupomaterias', 'inscribedGrupoMaterias'))->render(),
                'total' => $total_materias_inscritas,
            ]);
        }
        return view('VistaInscripcion.edit', compact('grupomaterias', 'boleta_inscripcion', 'user_estudiante', 'total_materias_inscritas', 'inscribedGrupoMaterias'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'carnet_identidad' => 'required',
            'grupomaterias' => 'required|array',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = '';

            if ($errors->has('carnet_identidad')) {
                $error = 'Carnet no encontrado';
            }
            return redirect()->back()->withErrors($error)->withInput();
        }

        $carnet_identidad = $request->carnet_identidad;

        $estudiante = User::where('carnet_identidad', $request->carnet_identidad)->first();

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado');
        }

        $grupomaterias = $request->grupomaterias;

        $boleta_inscripcion = BoletaInscripcion::find($id);

        if (!$boleta_inscripcion) {
            return redirect()->back()->with('error', 'Boleta de inscripción no encontrada');
        }

        $currentMaterias = $boleta_inscripcion->grupo_materia_boleta_inscripcion->pluck('grupo_materia_id')->toArray();

        $materiasToRemove = array_diff($currentMaterias, $grupomaterias);

        $materiasToAdd = array_diff($grupomaterias, $currentMaterias);

        foreach ($materiasToRemove as $materiaId) {
            $boleta_inscripcion->grupo_materia_boleta_inscripcion()->where('grupo_materia_id', $materiaId)->delete();
        }

        foreach ($materiasToAdd as $materiaId) {
            $boleta_inscripcion->grupo_materia_boleta_inscripcion()->create([
                'boleta_inscripcion_id' => $boleta_inscripcion->id,
                'grupo_materia_id' => $materiaId,
            ]);
        }

        $boleta_inscripcion->update([
            'user_estudiante_id' => $estudiante->id,
            'user_administrativo_id' => auth()->user()->id,
            'hora' => now()->timezone('America/La_Paz')->format('H:i:s'),
            'fecha' => now()->timezone('America/La_Paz')->format('Y-m-d'),
            'cantidad_materias_inscritas' => count($grupomaterias),
        ]);

        return redirect()->route('Inscripcion.index')->with('success', 'Inscripción actualizada con éxito');
    }

    public function destroy(string $id)
    {
        $inscripcion = BoletaInscripcion::find($id);

        if (!$inscripcion) {
            return redirect()->back()->with('error', 'Inscripción no encontrada');
        }

        $inscripcion->delete();

        return redirect()->route('Inscripcion.index')->with('success', 'Inscripción eliminada con éxito');
    }
}
