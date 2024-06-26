<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BoletaInscripcion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use App\Models\Materia;
use App\Models\GrupoMateria;
use App\Models\Grupo;

class UsuarioController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        $rol = $request->input('rol') ? decrypt($request->input('rol')) : '';
        $user = Auth::user();

        $usuariosQuery = User::with('roles')
            ->where(function ($query) use ($search, $rol, $user) {
                if ($rol) {
                    if ($rol == 'TodosMenosMaster') {
                        $query->whereDoesntHave('roles', function ($query) {
                            $query->where('name', 'Master');
                        });
                    } else {
                        $query->whereHas('roles', function ($query) use ($rol) {
                            $query->where('name', $rol);
                        });
                    }
                }
                if ($search) {
                    $query->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                }
            });

        if ($user->hasRole('Administrativo')) {
            $usuariosQuery->where(function ($query) use ($user) {
                $query->where('jefe_id', $user->id)
                    ->orWhere('id', $user->id);
            });
        }

        $usuarios = $usuariosQuery->get();

        $usuariosSinMaster = $usuarios->reject(function ($usuario) {
            return $usuario->roles->contains('name', 'Master');
        });

        $totalUsuarios = $usuariosSinMaster->count();
        $totalDocentes = $usuarios->filter(function ($usuario) {
            return $usuario->roles->contains('name', 'Docente');
        })->count();
        $totalEstudiantes = $usuarios->filter(function ($usuario) {
            return $usuario->roles->contains('name', 'Estudiante');
        })->count();

        $roles = Role::all();
        $usuarios_creables = null;

        if ($user->hasRole('Administrativo')) {
            $usuarios_creables = $user->usuarios_creables;
        }

        if ($request->ajax()) {
            return view('VistaUsuario.table', compact('usuarios'));
        }
        return view('VistaUsuario.index', compact('usuarios', 'totalUsuarios', 'totalDocentes', 'totalEstudiantes', 'usuarios_creables', 'roles'));
    }

    public function create()
    {
        $roles = Role::all();
        $user = Auth::user();

        if (auth()->check() && !auth()->user()->hasRole('Master')) {
            $roles = $roles->reject(function ($role) {
                return $role->name == 'Master' || $role->name == 'Administrativo Premium' ||
                    $role->name == 'Docente Premium' || $role->name == 'Administrativo';
            });
        }

        if ($user->hasRole('Administrativo') || $user->hasRole('Administrativo Premium')) {
            if ($user->usuarios_creables > 0) {
                return view('VistaUsuario.create', compact('roles'));
            } else {
                return redirect()->route('Usuario.index')->with('error', 'Usuario sin usuarios creables.');
            }
        }
        if ($user->hasRole('Master')) {
            return view('VistaUsuario.create', compact('roles'));
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cantidad_usuarios' => 'nullable|integer'
        ]);

        $userauth = Auth::user();

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->jefe_id = $userauth->id;

        if ($request->hasFile('profile_photo_path')) {
            $imageName = $user->email . '.' . $request->profile_photo_path->extension();
            $request->profile_photo_path->move(public_path('images/user'), $imageName);
            $user->profile_photo_path = 'images/user/' . $imageName;
        }

        $user->usuarios_creables = $request->cantidad_usuarios;
        $user->save();

        $user->assignRole($request->role);

        if ($userauth->hasRole('Administrativo') || $userauth->hasRole('Administrativo Premium')) {
            $userauth->usuarios_creables -= 1;
            $userauth->save();
        }

        return redirect()->route('Usuario.index')->with('success', 'Usuario creado exitosamente.');
    }


    public function show($id)
    {
        $user = User::findOrFail($id);
        if($user->hasRole('Estudiante')){
        $inscripciones = BoletaInscripcion::where('user_estudiante_id', $id)
            ->with([
                'grupo_materia_boleta_inscripcions.grupo_materia.materia',
                'grupo_materia_boleta_inscripcions.grupo_materia.grupo',
                'grupo_materia_boleta_inscripcions.grupo_materia.userDocente'
            ])
            ->get();

        $materiasConGrupos = [];

        foreach ($inscripciones as $inscripcion) {
            foreach ($inscripcion->grupo_materia_boleta_inscripcions as $gmbi) {
                $grupoMateria = $gmbi->grupo_materia;

                if ($grupoMateria) {
                    $materia = $grupoMateria->materia;
                    $grupo = $grupoMateria->grupo;
                    $docente = $grupoMateria->userDocente;

                    $infoGrupoMateria = [
                        'grupo' => $grupo ? $grupo->nombre : 'N/A',
                        'materia' => $materia ? $materia->nombre : 'N/A',
                        'docente' => $docente ? $docente->name : 'N/A',
                        'gp' => $grupoMateria->id
                    ];

                    $materiasConGrupos[] = $infoGrupoMateria;
                }
            }
        }
    }else{
        $materiasConGrupos = [];
        $gmaterias = GrupoMateria::where('user_docente_id',$user->id)->get();
        $grupomaterias = [];
        foreach ($gmaterias as $gmateria) {
            $materia = Materia::find($gmateria->materia_id);
            $grupo = Grupo::find($gmateria->grupo_id);
            $infoGrupoMateria = [
                'grupo' => $grupo ? $grupo->nombre : 'N/A',
                'materia' => $materia ? $materia->nombre : 'N/A',
                'docente' => $user ? $user->name : 'N/A',
                'gp' => $gmateria->id
            ];
            $materiasConGrupos[] = $infoGrupoMateria;
        }

    }

        return view('VistaUsuario.show', compact('user', 'materiasConGrupos'));
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        return view('VistaUsuario.edit', compact('usuario', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'profile_photo_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::findOrFail($id);
        $userauth = Auth::user();

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_photo_path')) {
            $imageName = $user->email . '.' . $request->profile_photo_path->extension();
            $request->profile_photo_path->move(public_path('images/user'), $imageName);
            $user->profile_photo_path = 'images/user/' . $imageName;
        }

        if ($userauth->id !== $user->id) {
            $user->usuarios_creables = $request->cantidad_usuarios;
        }

        $user->save();
        $user->syncRoles([$request->role]);

        return redirect()->route('Usuario.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('Usuario.index')->with('success', 'Usuario eliminado con éxito');
    }

    public function obtenerCarnet($carnet_identidad)
    {
        $usuario = User::where('carnet_identidad', $carnet_identidad)->first();
        return response()->json($usuario);
    }
}
