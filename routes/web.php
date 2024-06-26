<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\GrupoMateriaController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\PagoServicioController;
use App\Http\Controllers\Permisos;
use App\Http\Controllers\ReconocimientoFacialController;
use App\Http\Controllers\Roles;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoCallController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/planes', function () {
    return view('VistaWelcome.planes');
})->name('planes');
Route::get('/acerca', function () {
    return view('VistaWelcome.acerca');
})->name('acerca');
Route::get('/contacto', function () {
    return view('VistaWelcome.contacto');
})->name('contacto');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('Dashboard');

    Route::get('/teacher/video', function () {
        return view('teacher_video');
    });
    Route::post('/video/token', [VideoCallController::class, 'generateToken']);
    Route::get('/vid', [VideoCallController::class, 'vid']);

    //Rutas pertenecientes a los usuarios
        Route::controller(UsuarioController::class)->group(function () {
            Route::get('/usuarios', 'index')->name('Usuario.index');
            Route::get('/usuarios/create', 'create')->name('Usuario.create');
            Route::get('/usuarios/edit/{id}', 'edit')->name('Usuario.edit');
            Route::post('/usuarios/store', 'store')->name('Usuario.store');
            Route::put('/usuarios/update/{id}', 'update')->name('Usuario.update');
            Route::get('/usuarios/{id}', 'show')->name('Usuario.show');
            Route::delete('/usuarios/{id}', 'destroy')->name('Usuario.destroy');
            Route::get('/usuarios/buscar', 'buscar')->name('Usuario.buscar');
            Route::get('/obtener-carnet/{carnet_identidad}', 'obtenerCarnet');
            Route::get('/usuario/editar-perfil/{id}', 'editarPerfil')->name('Usuario.editarPerfil');
        });
    // });

    // Routes Permisos y Roles
    // Route::middleware('can:Ver Roles y Permisos')->group(function () {
        Route::resource('Permisos', Permisos::class);
        Route::resource('Roles', Roles::class);
    // });

    // Rutas DE IA
    Route::controller(ReconocimientoFacialController::class)->group(function () {
        Route::get('/reconocimiento-facial', 'index')->name('Reconocimiento-Facial.index');
        Route::post('/reconocimiento-facial/guardar_anomalia', 'guardarAnomalia')->name('guardar_anomalia');// sin ocupar
        Route::post('/guardar_foto_anomalia', [ReconocimientoFacialController::class, 'guardarFotoAnomalia'])->name('guardar_foto_anomalia');

    });

    // Rutas De Servicios
    // Route::middleware('can:Ver Servicios')->group(function () {
        Route::controller(ServicioController::class)->group(function () {
            Route::get('/servicios', 'index')->name('Servicio.index');
            Route::post('/servicios/store', 'store')->name('Servicio.store');
            Route::get('/servicios/create', 'create')->name('Servicio.create');
            Route::get('/servicios/{id}', 'show')->name('Servicio.show'); //sin ocupar
            Route::get('/servicios/{id}/edit', 'edit')->name('Servicio.edit');
            Route::put('/servicios/{id}', 'update')->name('Servicio.update');
            Route::delete('/servicios/{id}', 'destroy')->name('Servicio.destroy');
        });
    // });

    //Rutas De Pagos
    // Route::middleware('can:Ver Pagos')->group(function () {
        Route::controller(PagoServicioController::class)->group(function () {
            Route::get('/pagos-servicios', 'index')->name('PagoServicio.index');
            Route::post('/pagos-servicios/store', 'store')->name('PagoServicio.store');
            Route::get('/pagos-servicios/create', 'create')->name('PagoServicio.create');
            Route::get('/pagos-servicios/{id}', 'show')->name('PagoServicio.show');
            Route::get('/pagos-servicios/{id}/edit', 'edit')->name('PagoServicio.edit');
            Route::put('/pagos-servicios/{id}', 'update')->name('PagoServicio.update');
            Route::delete('/pagos-servicios/{id}', 'destroy')->name('PagoServicio.destroy');
            Route::get('/pagos-servicios/comprobante', 'buscarComprobantes')->name('PagoServicio.comprobantes');
        });
    // });

     // Rutas Inscripcion
    //  Route::middleware('can:Ver Inscripciones')->group(function () {
        Route::controller(InscripcionController::class)->group(function () {
            Route::get('/inscripcion', 'index')->name('Inscripcion.index');
            Route::post('/inscripcion/store', 'store')->name('Inscripcion.store');
            Route::get('/inscripcion/create', 'create')->name('Inscripcion.create');
            Route::get('/inscripcion/{id}', 'show')->name('Inscripcion.show');
            Route::get('/inscripcion/{id}/edit', 'edit')->name('Inscripcion.edit');
            Route::put('/inscripcion/{id}', 'update')->name('Inscripcion.update');
            Route::delete('/inscripcion/{id}', 'destroy')->name('Inscripcion.destroy');
        });
    // });

    //Rutas De Grupo-Materia
    // Route::middleware('can:Ver Grupos y Materias')->group(function () {
        Route::controller(GrupoMateriaController::class)->group(function () {
            Route::get('/grupo-materia', 'index')->name('GrupoMateria.index');
            Route::post('/grupo-materia/store', 'store')->name('GrupoMateria.store');
            Route::get('/grupo-materia/create', 'create')->name('GrupoMateria.create');
            Route::get('/grupo-materia/{id}', 'show')->name('GrupoMateria.show'); //vamos a poner la vista de la materia desde administracion
            Route::get('/grupo-materia/{id}/edit', 'edit')->name('GrupoMateria.edit');
            Route::put('/grupo-materia/{id}', 'update')->name('GrupoMateria.update');
            Route::delete('/grupo-materia/{id}', 'destroy')->name('GrupoMateria.destroy');
            Route::get('/grupo-materia/estudiantes', 'listaestudiantes')->name('GrupoMateria.listaestudiantes');
            Route::get('/grupo-materia/{id}/prueba', 'prueba')->name('GrupoMateria.prueba');
            Route::get('/grupo-materia/{docente_id}/select', 'selectGrupoMateria')->name('GrupoMateria.docente');
        });
    // });

    // Rutas De Grupos
    // Route::middleware('can:Ver Grupos y Materias')->group(function () {
        Route::controller(GrupoController::class)->group(function () {
            Route::get('/grupos', 'index')->name('Grupo.index');
            Route::post('/grupos/store', 'store')->name('Grupo.store');
            Route::get('/grupos/create', 'create')->name('Grupo.create');
            Route::get('/grupos/{id}', 'show')->name('Grupo.show');
            Route::get('/grupos/{id}/edit', 'edit')->name('Grupo.edit');
            Route::put('/grupos/{id}', 'update')->name('Grupo.update');
            Route::delete('/grupos/{id}', 'destroy')->name('Grupo.destroy');
        });
    // });

    // Rutas de Materias
    // Route::middleware('can:Ver Grupos y Materias')->group(function () {
        Route::controller(MateriaController::class)->group(function () {
            Route::get('/materia', 'index')->name('Materia.index');
            Route::post('/materia/store', 'store')->name('Materia.store');
            Route::get('/materia/create', 'create')->name('Materia.create');
            Route::get('/materia/{id}', 'show')->name('Materia.show');
            Route::get('/materia/{id}/edit', 'edit')->name('Materia.edit');
            Route::put('/materia/{id}', 'update')->name('Materia.update');
            Route::delete('/materia/{id}', 'destroy')->name('Materia.destroy');
        });
    // });

    //Rutas de Estudiantes
    // Route::middleware('can:Ver Perfil Estudiante')->group(function () {
        Route::controller(EstudianteController::class)->group(function () {
            Route::get('/estudiante', 'index')->name('Estudiante.index');
            Route::get('/unirse-curso', 'unirseCurso')->name('Estudiante.unirse_curso');
            Route::get('/historial-examenes', 'examenes')->name('Estudiante.examenes');
            Route::get('/lista-estudiantes', 'listaEstudiantes')->name('ListaEstudiantes.show');
            Route::get('/calificaciones', 'calificaciones')->name('Estudiante.calificaciones');
            Route::get('/perfil-estudiante', 'perfil')->name('Estudiante.perfil');
            Route::get('/estudiante-materia/{id}', 'materia')->name('Estudiante.materia');
            Route::get('/estudiante-edit/{id}', 'editar')->name('Estudiante.editar');
            Route::post('/estudiante/{id}/edit', 'update')->name('Estudiante.update');
            Route::get('/calendar', 'calendar')->name('Estudiante.calendar');
        });
    // });


    //RUTAS docente
    // Route::middleware('can:Ver Perfil Docente')->group(function () {
        Route::controller(DocenteController::class)->group(function () {
            Route::get('/docente', 'index')->name('Docente.index');
            Route::get('/docente-materia/{id}', 'materia')->name('Docente.materia');
        });
    // });

});
