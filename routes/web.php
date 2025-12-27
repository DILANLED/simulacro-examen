<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;

Route::get('/', function () {
    return view('cuestionario.dashboard');
});


Route::resource('roles', RolController::class);
Route::post('roles/{id}/cambiar-estado', [RolController::class, 'cambiarEstado'])->name('roles.cambiarEstado');
Route::post('roles/reporte-pdf', [RolController::class, 'reportePDF'])->name('roles.reportePDF');

Route::resource('usuarios', UsuarioController::class);
Route::post('usuarios/{id}/cambiar-estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.cambiarEstado');
Route::post('usuarios/reporte-pdf', [UsuarioController::class, 'reportePDF'])->name('usuarios.reportePDF');
