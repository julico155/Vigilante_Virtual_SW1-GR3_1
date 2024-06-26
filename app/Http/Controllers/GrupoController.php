<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\GrupoMateria;
use App\Models\GrupoMateriaComprobante;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $grupos = Grupo::query()
            ->where('nombre', 'LIKE', "%{$search}%")
            ->get();

        if ($request->ajax()) {
            return view('VistaGrupoMateria.VistaGrupo.table', compact('grupos'));
        }

        $totalGrupos = $grupos->count();

        return view('VistaGrupoMateria.VistaGrupo.index', compact('grupos', 'totalGrupos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
        ]);
        $nombreExistente = Grupo::where('nombre', $request->nombre)->first();
        if ($nombreExistente) {
            return redirect()->back()->with('error', 'El nombre del grupo ya existe. Por favor, elige otro nombre.');
        }

        $grupo = new Grupo;
        $grupo->nombre = $request->nombre;
        $grupo->save();

        return redirect()->route('Grupo.index')->with('success', 'Grupo creado con éxito.');
    }

    public function edit($id)
    {
        $grupo = Grupo::findOrFail($id);
        return view('VistaGrupoMateria.VistaGrupo.edit', compact('grupo'));
    }

    public function show(Request $request, $id)
    {
        $grupo = Grupo::findOrFail($id);
        $search = $request->get('search');
        $totalGrupos = GrupoMateria::where('grupo_id', $id)->count();

        if ($search) {
            $grupoMaterias = GrupoMateria::where('grupo_id', $id)
                ->whereHas('materia', function ($query) use ($search) {
                    $query->where('nombre', 'LIKE', "%{$search}%");
                })->get();
        } else {
            $grupoMaterias = GrupoMateria::where('grupo_id', $id)->get();
        }
        $fromShow = true;

        return view('VistaGrupoMateria.VistaGrupo.show', compact('grupo', 'grupoMaterias', 'totalGrupos', 'fromShow'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
        ]);

        $nombreExistente = Grupo::where('nombre', $request->nombre)->where('id', '!=', $id)->first();

        if ($nombreExistente) {
            return redirect()->back()->with('error', 'El nombre del grupo ya existe. Por favor, elige otro nombre.');
        }

        $grupo = Grupo::findOrFail($id);
        $grupo->nombre = $request->nombre;
        $grupo->save();

        return redirect()->route('Grupo.index')->with('success', 'Grupo actualizado con éxito.');
    }

    public function destroy($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->delete();

        return redirect()->route('Grupo.index')->with('success', 'Grupo eliminado con éxito.');
    }

}
