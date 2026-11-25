<?php

namespace Database\Seeders;

use App\Models\Carrera;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class CursoSeeder extends Seeder
{
    public function run(): void
    {
        $cursos = [
            [
                'nombre' => 'Programación Web',
                'codigo' => 'ISW-101',
                'creditos' => 4,
                'carrera' => 'Ingeniería del Software',
            ],
            [
                'nombre' => 'Bases de Datos',
                'codigo' => 'ISW-102',
                'creditos' => 3,
                'carrera' => 'Ingeniería del Software',
            ],
            [
                'nombre' => 'Desarrollo de Aplicaciones',
                'codigo' => 'ISW-103',
                'creditos' => 4,
                'carrera' => 'Ingeniería del Software',
            ],
            [
                'nombre' => 'Redes de Computadoras',
                'codigo' => 'SIS-101',
                'creditos' => 3,
                'carrera' => 'Ingeniería en Sistemas',
            ],
            [
                'nombre' => 'Administración General',
                'codigo' => 'ADM-101',
                'creditos' => 3,
                'carrera' => 'Administración de Empresas',
            ],
            [
                'nombre' => 'Contabilidad Financiera',
                'codigo' => 'CON-101',
                'creditos' => 4,
                'carrera' => 'Contabilidad',
            ],
        ];

        foreach ($cursos as $curso) {
            $carrera = Carrera::where('nombre', $curso['carrera'])->firstOrFail();

            Curso::firstOrCreate(
                ['codigo' => $curso['codigo']],
                [
                    'nombre' => $curso['nombre'],
                    'creditos' => $curso['creditos'],
                    'carrera_id' => $carrera->id,
                ]
            );
        }
    }
}