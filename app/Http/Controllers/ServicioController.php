<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ServicioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $servicios = Servicio::query()
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%");
            })
            ->get();

        if ($request->ajax()) {
            return view('VistaServicio.table', compact('servicios'));
        }
        $totalServicios = $servicios->count();
        return view('VistaServicio.index', compact('servicios', 'totalServicios'));
    }

    public function create()
    {
        return view('VistaServicio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'precio' => 'required|numeric',
        ]);

        Servicio::create($request->all());

        return redirect()->route('Servicio.index')->with('success', 'Servicio creado exitosamente.');
    }

    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);

        return view('VistaServicio.show', compact('servicio'));
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);

        return view('VistaServicio.edit', compact('servicio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'fecha' => 'required|date',
            'precio' => 'required|numeric',
        ]);

        $servicio = Servicio::findOrFail($id);
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->fecha = $request->input('fecha');
        $servicio->precio = $request->input('precio');

        $servicio->save();

        return redirect()->route('Servicio.index')->with('success', 'Servicio actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->delete();

        return redirect()->route('Servicio.index')->with('success', 'Servicio eliminado exitosamente.');
    }
}
