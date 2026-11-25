<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        $cursos = Curso::with('carrera')->get();

        return view('cursos.index', compact('cursos'));
    }

    public function create()
    {
        $carreras = Carrera::orderBy('nombre')->get();

        return view('cursos.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'required|string|max:20|unique:cursos,codigo',
            'creditos' => 'required|integer|min:1|max:255',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        Curso::create($datos);

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso registrado correctamente.');
    }

    public function show(Curso $curso)
    {
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso)
    {
        $carreras = Carrera::orderBy('nombre')->get();

        return view('cursos.edit', compact('curso', 'carreras'));
    }

    public function update(Request $request, Curso $curso)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:150',
            'codigo' => 'required|string|max:20|unique:cursos,codigo,' . $curso->id,
            'creditos' => 'required|integer|min:1|max:255',
            'carrera_id' => 'required|exists:carreras,id',
        ]);

        $curso->update($datos);

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Curso $curso)
    {
        $curso->delete();

        return redirect()
            ->route('cursos.index')
            ->with('success', 'Curso eliminado correctamente.');
    }
}