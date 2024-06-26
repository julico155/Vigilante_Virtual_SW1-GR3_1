<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\GrupoMateria;
use App\Models\Materia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\GrupoMateriaBoletaInscripcion;
use App\Models\BoletaInscripcion;
use App\Models\Ejecucion;
use App\Models\Examen;
use Illuminate\Support\Facades\Auth;
class GrupoMateriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $grupoMaterias = GrupoMateria::query()
            ->join('grupos', 'grupo_materias.grupo_id', '=', 'grupos.id')
            ->join('materias', 'grupo_materias.materia_id', '=', 'materias.id')
            ->where(function ($query) use ($search) {
                $query->where('grupos.nombre', 'LIKE', "%{$search}%")
                    ->orWhere('materias.nombre', 'LIKE', "%{$search}%");
            })
            ->select('grupo_materias.*')
            ->get();

        if ($request->ajax()) {
            return view('VistaGrupoMateria.table', compact('grupoMaterias'));
        }

        $totalGrupoMaterias = $grupoMaterias->count();
        $totalGrupos = Grupo::count();
        $totalMaterias = Materia::count();

        return view('VistaGrupoMateria.index', compact('grupoMaterias', 'totalGrupoMaterias', 'totalGrupos', 'totalMaterias'));
    }

    public function create()
    {
        $grupos = Grupo::all();
        $materias = Materia::all();
        $docentes = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Docente', 'Docente Premium']);})->orderBy('id', 'desc')->get();
            return view('VistaGrupoMateria.create', compact('grupos', 'materias', 'docentes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'materia_id' => 'required|exists:materias,id',
            'user_docente_id' => 'required|exists:users,id',
            'contraseña' => 'required|string',
            'cantidad_estudiantes' => 'required|integer|min:0',
            'cantidad_estudiantes_inscritos' => 'required|integer|min:0',
        ]);

        if (GrupoMateria::where('grupo_id', $request->input('grupo_id'))->where('materia_id', $request->input('materia_id'))->exists()) {
            return redirect()->route('GrupoMateria.create')->with('error', 'Seleccione otro grupo, ya existe esa materia con ese grupo.');
        }

        $grupoMateria = new GrupoMateria;
        $grupoMateria->grupo_id = $request->input('grupo_id');
        $grupoMateria->materia_id = $request->input('materia_id');
        $grupoMateria->user_docente_id = $request->input('user_docente_id');
        $grupoMateria->contraseña = $request->input('contraseña');
        $grupoMateria->cantidad_estudiantes = $request->input('cantidad_estudiantes');
        $grupoMateria->cantidad_estudiantes_inscritos = $request->input('cantidad_estudiantes_inscritos');

        $grupoMateria->save();

        return redirect()->route('GrupoMateria.index')->with('success', 'GrupoMateria creado exitosamente.');
    }

    public function show($id)
    {
        $grupoMateria = GrupoMateria::findOrFail($id);
        $docente = $grupoMateria->userDocente;
        $estudiantes = $grupoMateria->inscripciones()->with('boleta_inscripcion.user_estudiante')->get()->pluck('boleta_inscripcion.user_estudiante');
        $usuarios = collect([$docente])->merge($estudiantes);

        return view('VistaGrupoMateria.show', compact('grupoMateria', 'usuarios'));
    }

    public function edit($id)
    {
        $grupoMateria = GrupoMateria::findOrFail($id);
        $grupos = Grupo::all();
        $materias = Materia::all();
        return view('VistaGrupoMateria.edit', compact('grupoMateria', 'grupos', 'materias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'grupo_id' => 'required|exists:grupos,id',
            'materia_id' => 'required|exists:materias,id',
            'contraseña' => 'nullable|string',
            'cantidad_estudiantes' => 'required|integer|min:0',
            'cantidad_estudiantes_inscritos' => 'required|integer|min:0',
        ]);

        $grupoMateria = GrupoMateria::findOrFail($id);
        $grupoMateria->grupo_id = $request->input('grupo_id');
        $grupoMateria->materia_id = $request->input('materia_id');
        $grupoMateria->contraseña = $request->input('contraseña');
        $grupoMateria->cantidad_estudiantes = $request->input('cantidad_estudiantes');
        $grupoMateria->cantidad_estudiantes_inscritos = $request->input('cantidad_estudiantes_inscritos');

        $grupoMateria->save();

        return redirect()->route('GrupoMateria.index')->with('success', 'GrupoMateria actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $grupoMateria = GrupoMateria::findOrFail($id);
        $grupoMateria->delete();

        return redirect()->route('GrupoMateria.index')->with('success', 'GrupoMateria eliminado exitosamente.');
    }

    public function listaestudiantes()
    {
        return view('VistaGrupoMateria.listadoestudiantes');
    }

    public function prueba($id)
    {
        $user = Auth::user();
        $gp = GrupoMateria::find($id);
        $materia = Materia::find($gp->materia_id);
        $grupo = Grupo::find($gp->grupo_id);
        $docente = $gp->userDocente;
        $estudiantes = [];
        $detalles = GrupoMateriaBoletaInscripcion::where('grupo_materia_id', $id)->get();

        $examenes = Examen::where('grupo_materia_id', $gp->id)->get();

        foreach($examenes as $examen){
            $ejecucion_en_proceso = Ejecucion::where('examen_id', $examen->id)
            ->whereNot('estado_ejecucion_id', 2)->get();

            if(count($ejecucion_en_proceso) > 0){
                $examen->ejecutandose = '1';
            }else{
                $examen->ejecutandose = '0';
            }
        }
        
        $ejecuciones = Ejecucion::getData(['grupo_materia_id' => $gp->id]);
        //dd($ejecuciones);
        //dd($examenes);

        foreach ($detalles as $detalle) {
            $boleta = BoletaInscripcion::where('id', $detalle->boleta_inscripcion_id)->first();
            $alumno = User::where('id', $boleta->user_estudiante_id)->first();
            $estudiantes[] = $alumno;
        }

        $usuarios = collect([$docente])->merge($estudiantes);

        return view('VistaGrupoMateria.prueba', compact('materia', 'gp', 'usuarios', 'grupo', 'docente', 'user', 'examenes', 'ejecuciones'));
    }


    public function selectGrupoMateria($docente_id){
        $user = User::find($docente_id);

        if($user->hasRole('Docente')){
            $grupo_materias = GrupoMateria::getData(['docente_id'=>$user->id]);

            $data = compact(
                'grupo_materias'
            );
            return view('VistaGrupoMateria.select', $data);
        }
    }



}
