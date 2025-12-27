<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AreaController;


$SUPER_ADMIN_ID = 1; // <-- AJUSTA
$ESTUDIANTE_ID  = 2; // <-- AJUSTA

/*
|---------------------------------------------------------
| LOGIN
|---------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'show'])->name('login.form');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|---------------------------------------------------------
| HOME (/): redirige según rol
|---------------------------------------------------------
*/
Route::get('/', function () use ($SUPER_ADMIN_ID, $ESTUDIANTE_ID) {

    // Si no está logueado -> login
    if (!auth()->check()) {
        return redirect()->route('login.form');
    }

    $user = auth()->user();

    // Super Admin -> welcome
    if ((int)$user->id_rol === (int)$SUPER_ADMIN_ID) {
        return view('welcome');
    }

    // Estudiante -> cuestionario dashboard
    if ((int)$user->id_rol === (int)$ESTUDIANTE_ID) {
        return view('cuestionario.dashboard');
    }

    // Cualquier otro rol -> por defecto al cuestionario (o lo cambias)
    return view('cuestionario.dashboard');
})->name('home');

/*
|---------------------------------------------------------
| RUTAS PROTEGIDAS POR ROL
|---------------------------------------------------------
*/

// ✅ SOLO SUPER ADMIN
Route::middleware(['auth', "role:$SUPER_ADMIN_ID"])->group(function () {

    Route::resource('roles', RolController::class);
    Route::post('roles/{id}/cambiar-estado', [RolController::class, 'cambiarEstado'])->name('roles.cambiarEstado');
    Route::post('roles/reporte-pdf', [RolController::class, 'reportePDF'])->name('roles.reportePDF');

    Route::resource('usuarios', UsuarioController::class);
    Route::post('usuarios/{id}/cambiar-estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.cambiarEstado');
    Route::post('usuarios/reporte-pdf', [UsuarioController::class, 'reportePDF'])->name('usuarios.reportePDF');

    Route::resource('carreras', CarreraController::class);
    Route::post('carreras/{id}/cambiar-estado', [CarreraController::class, 'cambiarEstado'])
        ->name('carreras.cambiarEstado');
    Route::post('carreras/reporte-pdf', [CarreraController::class, 'reportePDF'])
        ->name('carreras.reportePDF');

    Route::resource('areas', AreaController::class);
    Route::post('areas/{id}/cambiar-estado', [AreaController::class, 'cambiarEstado'])
    ->name('areas.cambiarEstado');
    Route::post('areas/reporte-pdf', [AreaController::class, 'reportePDF'])
    ->name('areas.reportePDF');

    // ================= Preguntas =================
Route::resource('preguntas', PreguntaController::class);

// Cambiar estado de la pregunta
Route::post('preguntas/{id}/cambiar-estado', [PreguntaController::class, 'cambiarEstado'])
    ->name('preguntas.cambiarEstado');

// Reporte PDF de preguntas
Route::post('preguntas/reporte-pdf', [PreguntaController::class, 'reportePDF'])
    ->name('preguntas.reportePDF');

// ================= Opciones =================
// Modificar opciones de una pregunta específica
Route::get('preguntas/{id}/opciones', [PreguntaController::class, 'verOpciones'])
    ->name('preguntas.opciones');

Route::post('preguntas/{id}/opciones', [PreguntaController::class, 'guardarOpciones'])
    ->name('preguntas.opciones.guardar');


});

// ✅ SOLO ESTUDIANTE
Route::middleware(['auth', "role:$ESTUDIANTE_ID"])->group(function () {
    Route::get('/cuestionario', fn() => view('cuestionario.dashboard'))->name('cuestionario.dashboard');
    Route::get('/cuestionario/index', fn() => view('cuestionario.index'))->name('cuestionario.index');
    Route::get('/cuestionario/notas', fn() => view('cuestionario.notas'))->name('cuestionario.notas');
});
