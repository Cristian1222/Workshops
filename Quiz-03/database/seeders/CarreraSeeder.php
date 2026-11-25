<?php

namespace Database\Seeders;

use App\Models\Carrera;
use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{
    public function run(): void
    {
        $carreras = [
            [
                'nombre' => 'Ingeniería del Software',
                'descripcion' => 'Formación en desarrollo y mantenimiento de software.',
            ],
            [
                'nombre' => 'Ingeniería en Sistemas',
                'descripcion' => 'Formación en sistemas informáticos y tecnologías.',
            ],
            [
                'nombre' => 'Administración de Empresas',
                'descripcion' => 'Formación en gestión y administración empresarial.',
            ],
            [
                'nombre' => 'Contabilidad',
                'descripcion' => 'Formación en gestión contable y financiera.',
            ],
        ];

        foreach ($carreras as $carrera) {
            Carrera::firstOrCreate(
                ['nombre' => $carrera['nombre']],
                ['descripcion' => $carrera['descripcion']]
            );
        }
    }
}