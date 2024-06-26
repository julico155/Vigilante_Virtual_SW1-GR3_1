<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\GrupoMateria;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $materias = Materia::query()
            ->where('nombre', 'LIKE', "%{$search}%")
            ->get();

        if ($request->ajax()) {
            return view('VistaGrupoMateria.VistaMateria.table', compact('materias'));
        }

        $totalMaterias = $materias->count();

        return view('VistaGrupoMateria.VistaMateria.index', compact('materias', 'totalMaterias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'sigla' => 'required',
            'nombre' => 'required',
        ]);

        $nombreExistente = Materia::where('nombre', $request->nombre)->first();
        $siglaExistente = Materia::where('sigla', $request->sigla)->first();

        if ($nombreExistente) {
            return redirect()->back()->with('error', 'El nombre de la materia ya existe. Por favor, elige otro nombre.');
        }

        if ($siglaExistente) {
            return redirect()->back()->with('error', 'La sigla de la materia ya existe. Por favor, elige otra sigla.');
        }

        $materia = new Materia;
        $materia->nombre = $request->nombre;
        $materia->sigla = $request->sigla;
        $materia->save();

        return redirect()->route('Materia.index')->with('success', 'Materia creada con éxito.');
    }

    public function show(Request $request, $id)
    {
        $materia = Materia::findOrFail($id);
        $search = $request->get('search');
        $totalMaterias = GrupoMateria::where('materia_id', $id)->count();

        if ($search) {
            $grupoMaterias = GrupoMateria::where('materia_id', $id)
                ->whereHas('grupo', function ($query) use ($search) {
                    $query->where('nombre', 'LIKE', "%{$search}%");
                })->get();
        } else {
            $grupoMaterias = GrupoMateria::where('materia_id', $id)->get();
        }
        $fromShow = true;

        return view('VistaGrupoMateria.VistaMateria.show', compact('materia', 'grupoMaterias', 'totalMaterias', 'fromShow'));
    }

    public function edit($id)
    {
        $materia = Materia::findOrFail($id);
        return view('VistaGrupoMateria.VistaMateria.edit', compact('materia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required',
            'sigla' => 'required',
        ]);

        $nombreExistente = Materia::where('nombre', $request->nombre)->where('id', '!=', $id)->first();
        $siglaExistente = Materia::where('sigla', $request->sigla)->where('id', '!=', $id)->first();

        if ($nombreExistente) {
            return redirect()->back()->with('error', 'El nombre de la materia ya existe. Por favor, elige otro nombre.');
        }

        if ($siglaExistente) {
            return redirect()->back()->with('error', 'La sigla de la materia ya existe. Por favor, elige otra sigla.');
        }

        $materia = Materia::findOrFail($id);
        $materia->nombre = $request->nombre;
        $materia->sigla = $request->sigla;
        $materia->save();

        return redirect()->route('Materia.index')->with('success', 'Materia actualizada con éxito.');
    }

    public function destroy($id)
    {
        $materia = Materia::findOrFail($id);
        $materia->delete();

        return redirect()->route('Materia.index')->with('success', 'Materia eliminada con éxito.');
    }

}
