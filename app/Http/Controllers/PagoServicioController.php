<?php

namespace App\Http\Controllers;

use App\Models\Comprobante;
use App\Models\Servicio;
use App\Models\ServicioComprobante;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class PagoServicioController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        $fecha = $request->get('fecha');

        $comprobantes = Comprobante::query()
            ->where(function ($query) use ($search) {
                $query->whereHas('userEstudiante', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('carnet_identidad', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('userAdministrativo', function ($query) use ($search) {
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
        if ($request->ajax()) {
            return view('VistaPago.table', compact('comprobantes'));
        }

        $totalComprobantes = $comprobantes->count();
        $totalServiciosSinUtilizar = ServicioComprobante::where('usado', false)->count();
        $totalComprobantesDelDia = Comprobante::whereDate('created_at', now()->today())->count();

        return view('VistaPago.index', compact('comprobantes', 'totalComprobantes', 'totalServiciosSinUtilizar', 'totalComprobantesDelDia'));
    }

    public function create(Request $request)
    {
        $servicios = Servicio::all();
        $search = $request->get('search');

        $servicios = Servicio::query()
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%");
            })
            ->get();

        if ($servicios->isEmpty()) {
            return redirect()->back()->with('error', 'Carnet inválido');
        }

        if ($request->ajax()) {
            return view('VistaPago.tablacreate', compact('servicios'));
        }
        return view('VistaPago.create', compact('servicios'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'carnet_identidad' => 'required',
            'servicios' => 'required|array',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = '';

            if ($errors->has('carnet_identidad')) {
                $error = 'Carnet no encontrado';
            } elseif ($errors->has('servicios')) {
                $error = 'Selecciona un servicio';
            }

            return redirect()->back()->withErrors($error)->withInput();
        }

        $carnet_identidad = $request->carnet_identidad;

        $estudiante = User::where('carnet_identidad', $request->carnet_identidad)->first();

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado');
        }

        $comprobante = Comprobante::create([
            'user_estudiante_id' => $estudiante->id,
            'user_administrativo_id' => auth()->id(),
            'hora' => now()->timezone('America/La_Paz')->format('H:i:s'),
            'fecha' => now()->timezone('America/La_Paz')->format('Y-m-d'),
            'monto_total' => 0,
        ]);

        $monto_total = 0;
        if ($request->servicios) {
            foreach ($request->servicios as $servicio_id) {
                $servicio = Servicio::find($servicio_id);
                if ($servicio) {
                    $monto_total += $servicio->precio;
                    ServicioComprobante::create([
                        'comprobante_id' => $comprobante->id,
                        'servicio_id' => $servicio_id,
                        'usado' => false
                    ]);
                }
            }
        }

        $comprobante->monto_total = $monto_total;
        $comprobante->save();

        return redirect()->route('PagoServicio.index')->with('success', 'Servicio creado con éxito.');
    }

    public function show(string $id, Request $request)
    {
        $search = $request->get('search');
        $fecha = $request->get('fecha');
        $comprobantes = Comprobante::query()
            ->where(function ($query) use ($search) {
                $query->whereHas('userEstudiante', function ($query) use ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('carnet_identidad', 'LIKE', "%{$search}%");
                })
                    ->orWhereHas('userAdministrativo', function ($query) use ($search) {
                        $query->where('name', 'LIKE', "%{$search}%")
                            ->orWhere('carnet_identidad', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('servicios', function ($query) use ($search) {
                        $query->where('nombre', 'LIKE', "%{$search}%")
                            ->orWhere('descripcion', 'LIKE', "%{$search}%");
                    });
            })
            ->where(function ($query) use ($fecha) {
                if ($fecha) {
                    $query->whereDate('fecha', Carbon::parse($fecha)->format('Y-m-d'));
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $comprobante = Comprobante::find($id);

        if (!$comprobante) {
            return redirect()->back()->with('error', 'Comprobante no encontrado');
        }

        $servicios = $comprobante->servicios;

        $totalServicios = $servicios->count();

        $totalServiciosSinUtilizar = $servicios->where('pivot.usado', false)->count();
        $totalServiciosUtilizados = $servicios->where('pivot.usado', true)->count();

        return view('VistaPago.show', compact('comprobante', 'servicios', 'totalServicios', 'totalServiciosSinUtilizar', 'totalServiciosUtilizados'));
    }

    public function edit(string $id, Request $request)
    {
        $comprobante = Comprobante::find($id);
        if ($comprobante === null) {
            return redirect()->back()->with('error', 'Comprobante no encontrado');
        }

        $user = User::find($comprobante->user_estudiante_id);
        if ($user === null) {
            return redirect()->back()->with('error', 'Usuario no encontrado');
        }

        $servicios = Servicio::all();
        $search = $request->get('search');

        $servicios = Servicio::query()
            ->where(function ($query) use ($search) {
                $query->where('nombre', 'LIKE', "%{$search}%")
                    ->orWhere('descripcion', 'LIKE', "%{$search}%");
            })
            ->get();

        if ($servicios->isEmpty()) {
            return redirect()->back()->with('error', 'Carnet inválido');
        }

        if ($request->ajax()) {
            return view('VistaPago.tablacreate', compact('servicios'));
        }
        return view('VistaPago.edit', compact('servicios', 'id', 'user'));
    }

    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'carnet_identidad' => 'required',
            'servicios' => 'required|array',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = '';
            if ($errors->has('carnet_identidad')) {
                $error = 'Carnet no encontrado';
            } elseif ($errors->has('servicios')) {
                $error = 'Selecciona un servicio';
            }

            return redirect()->back()->withErrors($error)->withInput();
        }

        $carnet_identidad = $request->carnet_identidad;

        $estudiante = User::where('carnet_identidad', $request->carnet_identidad)->first();

        if (!$estudiante) {
            return redirect()->back()->with('error', 'Estudiante no encontrado');
        }

        $comprobante = Comprobante::find($id);

        if (!$comprobante) {
            return redirect()->back()->with('error', 'Comprobante no encontrado');
        }

        $comprobante->user_estudiante_id = $estudiante->id;
        $comprobante->user_administrativo_id = auth()->id();

        $comprobante->servicios()->detach();

        $monto_total = 0;
        if ($request->servicios) {
            foreach ($request->servicios as $servicio_id) {
                $servicio = Servicio::find($servicio_id);
                if ($servicio) {
                    $monto_total += $servicio->precio;
                    $comprobante->servicios()->attach($servicio_id, ['usado' => false]);
                }
            }
        }

        $comprobante->monto_total = $monto_total;
        $comprobante->save();

        return redirect()->route('PagoServicio.index')->with('success', 'Servicio actualizado con éxito.');
    }


    public function destroy(string $id)
    {
        $comprobante = Comprobante::findOrFail($id);
        $comprobante->delete();
        return redirect()->route('PagoServicio.index')->with('success', 'Comprobante eliminado exitosamente.');
    }
}
