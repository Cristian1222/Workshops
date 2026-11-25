
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MatriculaController;

// Página principal: formulario de matrícula
Route::get('/', [MatriculaController::class, 'create'])
    ->name('matriculas.create');

// Guardar matrícula
Route::post('/matriculas', [MatriculaController::class, 'store'])
    ->name('matriculas.store');

// Mostrar matrícula registrada
Route::get('/matriculas/{matricula}', [MatriculaController::class, 'show'])
    ->name('matriculas.show');

// CRUD de cursos
Route::resource('cursos', CursoController::class);
