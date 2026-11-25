<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    public function create()
    {
        $cursos = Curso::with('carrera')
            ->orderBy('nombre')
            ->get();

        return view('matriculas.create', compact('cursos'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'estudiante' => 'required|string|max:150',
            'identificacion' => 'required|string|max:30',
            'correo' => 'required|email|max:150',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $datos['fecha'] = now()->toDateString();

        $matricula = Matricula::create($datos);

        return redirect()
            ->route('matriculas.show', $matricula)
            ->with('success', '¡Matrícula registrada correctamente!');
    }

    public function show(Matricula $matricula)
    {
        $matricula->load('curso.carrera');

        return view('matriculas.show', compact('matricula'));
    }
}
