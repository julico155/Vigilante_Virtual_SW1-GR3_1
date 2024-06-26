<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Examen;
use App\Models\Calendar;
use App\Models\Ejecucion;
use App\Models\GrupoMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarioAutenticado = Auth::user();
        $events = [];

        if ($usuarioAutenticado->hasRole('Docente')) {
            // Obtener los exámenes del docente
            $grupoMaterias = GrupoMateria::where('user_docente_id', $usuarioAutenticado->id)->get();

            foreach ($grupoMaterias as $grupoMateria) {
                $examenes = Examen::where('grupo_materia_id', $grupoMateria->id)->get();

                foreach ($examenes as $examen) {
                    $ejecucion = Ejecucion::where('examen_id', $examen->id)->first();

                    if ($ejecucion) {
                        $fechaHoraI = $ejecucion->fecha . 'T' . $ejecucion->hora_inicio;
                        $fechaHoraF = $ejecucion->fecha . 'T' . $ejecucion->hora_final;

                        $events[] = [
                            'title' => $examen->tema,
                            'start' => $fechaHoraI,
                            'end' => $fechaHoraF,
                        ];
                    }
                }
            }
        } else {
            // Obtener las ejecuciones del estudiante
            $ejecuciones = $usuarioAutenticado->ejecuciones;

            foreach ($ejecuciones as $ejecucion) {
                $examen = Examen::where('id', $ejecucion->examen_id)->first();

                if ($examen) {
                    $fechaHoraI = $ejecucion->fecha . 'T' . $ejecucion->hora_inicio;
                    $fechaHoraF = $ejecucion->fecha . 'T' . $ejecucion->hora_final;

                    $events[] = [
                        'title' => $examen->tema,
                        'start' => $fechaHoraI,
                        'end' => $fechaHoraF,
                    ];
                }
            }
        }

        return view('VistaDashboard.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
